<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\Schedule;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

class EmailService
{
    public function sendMcuInvitation(Schedule $schedule): bool
    {
        try {
            // Get SMTP settings
            $smtpSettings = Setting::getGroup('smtp');
            
            // Configure mail settings
            Config::set('mail.mailers.smtp.host', $smtpSettings['smtp_host'] ?? 'smtp.gmail.com');
            Config::set('mail.mailers.smtp.port', $smtpSettings['smtp_port'] ?? 587);
            Config::set('mail.mailers.smtp.username', $smtpSettings['smtp_username'] ?? '');
            Config::set('mail.mailers.smtp.password', $smtpSettings['smtp_password'] ?? '');
            Config::set('mail.mailers.smtp.encryption', $smtpSettings['smtp_encryption'] ?? 'tls');
            Config::set('mail.from.address', $smtpSettings['smtp_from_address'] ?? 'noreply@mcu.local');
            Config::set('mail.from.name', $smtpSettings['smtp_from_name'] ?? 'Sistem MCU');

            // Get email template
            $subject = Setting::getValue('email_invitation_subject', 'Undangan Medical Check Up');
            $template = Setting::getValue('email_invitation_template', 'Kepada {nama_lengkap}, Anda diundang untuk mengikuti Medical Check Up pada tanggal {tanggal_pemeriksaan} pukul {jam_pemeriksaan} di {lokasi_pemeriksaan}.');

            // Replace placeholders
            $message = str_replace([
                '{nama_lengkap}',
                '{tanggal_pemeriksaan}',
                '{jam_pemeriksaan}',
                '{lokasi_pemeriksaan}',
            ], [
                $schedule->nama_lengkap,
                $schedule->tanggal_pemeriksaan->format('d/m/Y'),
                $schedule->jam_pemeriksaan->format('H:i'),
                $schedule->lokasi_pemeriksaan,
            ], $template);

            // Send email
            Mail::raw($message, function ($message) use ($schedule, $subject) {
                $message->to($schedule->email)
                    ->subject($subject);
            });

            // Update schedule
            $schedule->update([
                'email_sent' => true,
                'email_sent_at' => now(),
            ]);

            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to send email invitation: ' . $e->getMessage());
            return false;
        }
    }

    public function sendBulkMcuInvitations(array $scheduleIds): array
    {
        $results = [
            'success' => 0,
            'failed' => 0,
            'errors' => [],
        ];

        foreach ($scheduleIds as $scheduleId) {
            $schedule = Schedule::find($scheduleId);
            if ($schedule) {
                if ($this->sendMcuInvitation($schedule)) {
                    $results['success']++;
                } else {
                    $results['failed']++;
                    $results['errors'][] = "Failed to send email to {$schedule->nama_lengkap} ({$schedule->email})";
                }
            }
        }

        return $results;
    }
}
