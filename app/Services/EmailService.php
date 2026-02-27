<?php

namespace App\Services;

use App\Models\EmailTemplate;
use App\Models\McuResult;
use App\Models\Setting;
use App\Models\Schedule;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EmailService
{
    public function sendMcuInvitation(Schedule $schedule): bool
    {
        try {
            // Configure SMTP settings
            $this->configureMailSettings();
            
            // Get email template from Settings (new simple template)
            $subject = Setting::getValue('email_invitation_subject', 'Undangan Medical Check Up');
            $template = Setting::getValue('email_invitation_template', 'Kepada {nama_lengkap}, Anda diundang untuk mengikuti Medical Check Up.');
            
            // Prepare template data
            $templateData = $this->prepareTemplateData($schedule);
            
            // Render template (replace variables)
            $renderedSubject = $this->renderTemplate($subject, $templateData);
            $renderedBody = $this->renderTemplate($template, $templateData);
            
            // Send plain text email (no PDF attachment)
            Mail::raw($renderedBody, function ($message) use ($schedule, $renderedSubject) {
                $message->to($schedule->email)
                    ->subject($renderedSubject);
            });

            // Update schedule
            $schedule->update([
                'email_sent' => true,
                'email_sent_at' => now(),
            ]);

            Log::info("Email invitation sent successfully to {$schedule->email}");
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send email invitation: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Configure mail settings from Settings table
     */
    private function configureMailSettings(): void
    {
        $smtpSettings = Setting::getGroup('smtp');
        
        // Gunakan Settings, fallback ke .env jika kosong
        $host = ($smtpSettings['smtp_host'] ?? '') ?: env('MAIL_HOST', 'smtp.gmail.com');
        $port = ($smtpSettings['smtp_port'] ?? '') ?: env('MAIL_PORT', 587);
        $username = ($smtpSettings['smtp_username'] ?? '') ?: env('MAIL_USERNAME', '');
        $password = ($smtpSettings['smtp_password'] ?? '') ?: env('MAIL_PASSWORD', '');
        $encryption = ($smtpSettings['smtp_encryption'] ?? '') ?: env('MAIL_ENCRYPTION', 'tls');
        $fromAddress = ($smtpSettings['smtp_from_address'] ?? '') ?: env('MAIL_FROM_ADDRESS', 'noreply@mcu.local');
        $fromName = ($smtpSettings['smtp_from_name'] ?? '') ?: env('MAIL_FROM_NAME', 'Sistem MCU');
        
        Config::set('mail.default', 'smtp');
        Config::set('mail.mailers.smtp.host', $host);
        Config::set('mail.mailers.smtp.port', $port);
        Config::set('mail.mailers.smtp.username', $username);
        Config::set('mail.mailers.smtp.password', $password);
        Config::set('mail.mailers.smtp.encryption', $encryption);
        Config::set('mail.from.address', $fromAddress);
        Config::set('mail.from.name', $fromName);
    }

    /**
     * Prepare template data from schedule
     */
    private function prepareTemplateData(Schedule $schedule): array
    {
        return [
            'nama_lengkap' => $schedule->nama_lengkap,
            'nik_ktp' => $schedule->nik_ktp,
            'nrk_pegawai' => $schedule->nrk_pegawai,
            'tanggal_lahir' => $schedule->tanggal_lahir ? $schedule->tanggal_lahir->format('d/m/Y') : '-',
            'jenis_kelamin' => $schedule->jenis_kelamin === 'L' ? 'Laki-Laki' : 'Perempuan',
            'tanggal_pemeriksaan' => $schedule->tanggal_pemeriksaan ? $schedule->tanggal_pemeriksaan->format('d/m/Y') : '-',
            'hari_pemeriksaan' => $schedule->tanggal_pemeriksaan ? $schedule->tanggal_pemeriksaan->locale('id')->dayName : '-',
            'jam_pemeriksaan' => $schedule->jam_pemeriksaan ? $schedule->jam_pemeriksaan->format('H:i') : '-',
            'lokasi_pemeriksaan' => $schedule->lokasi_pemeriksaan,
            'queue_number' => $schedule->queue_number,
            'skpd' => $schedule->skpd,
            'ukpd' => $schedule->ukpd,
            'no_telp' => $schedule->no_telp,
            'email' => $schedule->email,
        ];
    }

    /**
     * Render template by replacing variables
     */
    private function renderTemplate(string $template, array $data): string
    {
        $rendered = $template;
        
        foreach ($data as $key => $value) {
            $rendered = str_replace('{' . $key . '}', $value, $rendered);
        }
        
        return $rendered;
    }

    /**
     * Send MCU result notification via Email
     */
    public function sendMcuResult(McuResult $result): bool
    {
        try {
            $participant = $result->participant;
            if (!$participant || empty($participant->email)) {
                Log::error('MCU result Email: Participant or email not found');
                return false;
            }

            $this->configureMailSettings();

            $templateModel = EmailTemplate::getDefault('mcu_result');
            $templateData = $this->prepareMcuResultTemplateData($result);

            if ($templateModel) {
                $rendered = $templateModel->render($templateData);
                $subject = $rendered['subject'];
                $body = $rendered['body_html'] ?: $rendered['body_text'];
            } else {
                $subject = Setting::getValue('email_result_subject', 'Hasil MCU Anda Tersedia');
                $template = Setting::getValue('email_result_template', '');
                if (empty($template)) {
                    $template = "Kepada {participant_name},\n\nHasil MCU Anda untuk pemeriksaan tanggal {tanggal_pemeriksaan} telah tersedia.\n\nStatus Kesehatan: {status_kesehatan}\nDiagnosis: {diagnosis}\n\nSilakan login ke {hasil_url} untuk melihat dan mendownload hasil lengkap.\n\nTerima kasih.";
                }
                $subject = $this->renderTemplate($subject, $templateData);
                $body = $this->renderTemplate($template, $templateData);
            }

            $isHtml = !empty($templateModel?->body_html);
            $attachments = $this->getMcuResultAttachmentPaths($result);

            Mail::send([], [], function ($message) use ($participant, $subject, $body, $isHtml, $attachments) {
                $message->to($participant->email)
                    ->subject($subject);
                if ($isHtml) {
                    $message->html($body);
                } else {
                    $message->text($body);
                }
                foreach ($attachments as $fullPath => $name) {
                    $message->attach($fullPath, ['as' => $name]);
                }
            });

            Log::info("MCU result email sent to {$participant->email}");
            return true;
        } catch (\Exception $e) {
            Log::error('MCU result email failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get attachment file paths for MCU result (untuk dilampirkan ke email)
     */
    private function getMcuResultAttachmentPaths(McuResult $result): array
    {
        $paths = [];
        $fileList = $result->file_hasil_files ?? [];
        if (empty($fileList) && $result->file_hasil) {
            $fileList = [$result->file_hasil];
        }
        foreach ($fileList as $idx => $relativePath) {
            $relativePath = ltrim($relativePath, '/');
            $fullPath = Storage::disk('public')->path($relativePath);
            if (file_exists($fullPath)) {
                $baseName = basename($relativePath);
                $ext = pathinfo($baseName, PATHINFO_EXTENSION);
                $nameWithoutExt = pathinfo($baseName, PATHINFO_FILENAME);
                $displayName = count($fileList) > 1
                    ? "Hasil_MCU_{$result->tanggal_pemeriksaan?->format('Y-m-d')}_{$nameWithoutExt}.{$ext}"
                    : "Hasil_MCU_{$result->tanggal_pemeriksaan?->format('Y-m-d')}.{$ext}";
                $paths[$fullPath] = $displayName;
            }
        }
        return $paths;
    }

    /**
     * Prepare template data for MCU result
     */
    private function prepareMcuResultTemplateData(McuResult $result): array
    {
        $participant = $result->participant;
        $appName = config('app.name', 'Sistem MCU PPKP');
        $hasilUrl = route('client.results');

        return [
            'participant_name' => $participant?->nama_lengkap ?? '-',
            'participant_email' => $participant?->email ?? '-',
            'participant_phone' => $participant?->no_telp ?? '-',
            'tanggal_pemeriksaan' => $result->tanggal_pemeriksaan?->format('d/m/Y') ?? '-',
            'status_kesehatan' => $result->status_kesehatan ?? '-',
            'diagnosis' => $result->diagnosis_text ?? $result->diagnosis ?? '-',
            'rekomendasi' => $result->rekomendasi ?? '-',
            'hasil_url' => $hasilUrl,
            'app_name' => $appName,
        ];
    }

    /**
     * Send reminder (legacy method for backward compatibility)
     */
    public function sendReminder(Schedule $schedule, $template = null): bool
    {
        // Use the same invitation method
        return $this->sendMcuInvitation($schedule);
    }
}