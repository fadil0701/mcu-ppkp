<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EmailTemplate;
use App\Models\Schedule;
use App\Models\Participant;
use App\Services\EmailService;

class TestEmailTemplate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test-template {email} {--template=} {--type=mcu_invitation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email template by sending to specified email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $templateId = $this->option('template');
        $type = $this->option('type');

        $this->info("Testing email template for: {$email}");
        $this->info("Template type: {$type}");

        // Get template
        $template = null;
        if ($templateId) {
            $template = EmailTemplate::find($templateId);
            if (!$template) {
                $this->error("Template with ID {$templateId} not found!");
                return 1;
            }
        } else {
            $template = EmailTemplate::getDefault($type);
            if (!$template) {
                $this->error("No default template found for type: {$type}");
                $this->info("Available templates:");
                $templates = EmailTemplate::getByType($type);
                foreach ($templates as $t) {
                    $this->info("- ID: {$t->id}, Name: {$t->name}");
                }
                return 1;
            }
        }

        $this->info("Using template: {$template->name} (ID: {$template->id})");

        // Create test schedule
        $participant = Participant::firstOrCreate(
            ['email' => $email],
            [
                'nik_ktp' => '1234567890123456',
                'nrk_pegawai' => '12345',
                'nama_lengkap' => 'Test User',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1990-01-01',
                'jenis_kelamin' => 'L',
                'skpd' => 'SKPD Test',
                'ukpd' => 'UKPD Test',
                'no_telp' => '081234567890',
                'status_pegawai' => 'PNS',
                'status_mcu' => 'Belum MCU',
            ]
        );

        $schedule = Schedule::firstOrCreate(
            ['participant_id' => $participant->id, 'email' => $email],
            [
                'nik_ktp' => $participant->nik_ktp,
                'nrk_pegawai' => $participant->nrk_pegawai,
                'nama_lengkap' => $participant->nama_lengkap,
                'tanggal_lahir' => $participant->tanggal_lahir,
                'jenis_kelamin' => $participant->jenis_kelamin,
                'skpd' => $participant->skpd,
                'ukpd' => $participant->ukpd,
                'no_telp' => $participant->no_telp,
                'tanggal_pemeriksaan' => now()->addDay(),
                'jam_pemeriksaan' => now()->setTime(9, 0),
                'lokasi_pemeriksaan' => 'Klinik Test - Gedung A Lantai 2',
                'status' => 'Terjadwal',
                'queue_number' => 1,
            ]
        );

        $this->info("Schedule details:");
        $this->info("- Nama: {$schedule->nama_lengkap}");
        $this->info("- Email: {$schedule->email}");
        $this->info("- Tanggal: {$schedule->tanggal_pemeriksaan}");
        $this->info("- Jam: {$schedule->jam_pemeriksaan}");
        $this->info("- Lokasi: {$schedule->lokasi_pemeriksaan}");

        // Test template rendering
        $this->info("\nTesting template rendering...");
        $templateData = [
            'participant_name' => $schedule->nama_lengkap,
            'participant_email' => $schedule->email,
            'participant_phone' => $schedule->no_telp,
            'examination_date' => $schedule->tanggal_pemeriksaan->format('d F Y'),
            'examination_time' => $schedule->jam_pemeriksaan->format('H:i'),
            'examination_location' => $schedule->lokasi_pemeriksaan,
            'queue_number' => $schedule->queue_number,
            'skpd' => $schedule->skpd,
            'ukpd' => $schedule->ukpd,
            'app_name' => config('app.name', 'Sistem MCU'),
        ];

        $rendered = $template->render($templateData);
        $this->info("Subject: {$rendered['subject']}");
        $this->info("Body length: " . strlen($rendered['body_html'] ?? $rendered['body_text']));

        // Send email
        $this->info("\nSending email...");
        $emailService = new EmailService();
        
        if ($type === 'reminder') {
            $success = $emailService->sendReminder($schedule, $template);
        } else {
            $success = $emailService->sendMcuInvitation($schedule, $template);
        }

        if ($success) {
            $this->info("✅ Email sent successfully to {$email}!");
            $this->info("Template used: {$template->name}");
        } else {
            $this->error("❌ Failed to send email to {$email}");
            $this->error("Check the logs for more details.");
        }

        return $success ? 0 : 1;
    }
}
