<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Schedule;
use App\Models\Participant;
use App\Services\EmailService;
use App\Services\WhatsAppService;
use App\Models\Setting;

class TestNewTemplateVariables extends Command
{
    protected $signature = 'test:template-variables {--email=} {--whatsapp=}';
    protected $description = 'Test email and WhatsApp templates with new variables';

    public function handle()
    {
        $this->info('🧪 Testing New Template Variables...');
        $this->newLine();

        // Create test schedule
        $schedule = $this->createTestSchedule();
        
        if (!$schedule) {
            $this->error('❌ Failed to create test schedule');
            return 1;
        }

        $this->info("✅ Test schedule created for: {$schedule->nama_lengkap}");
        $this->newLine();

        // Test template variables
        $this->testTemplateVariables($schedule);

        // Test email template if email provided
        if ($email = $this->option('email')) {
            $this->testEmailTemplate($schedule, $email);
        }

        // Test WhatsApp template if WhatsApp provided
        if ($whatsapp = $this->option('whatsapp')) {
            $this->testWhatsAppTemplate($schedule, $whatsapp);
        }

        // Cleanup
        $schedule->delete();
        $this->info('🧹 Test schedule cleaned up');

        $this->newLine();
        $this->info('✅ Template variables test completed!');
        
        return 0;
    }

    private function createTestSchedule(): ?Schedule
    {
        try {
            // Create test participant with unique NIK (16 digits max)
            $uniqueNik = '1234567890' . substr(time(), -6);
            $participant = Participant::create([
                'nik_ktp' => $uniqueNik,
                'nrk_pegawai' => 'TEST' . substr(time(), -5),
                'nama_lengkap' => 'Test User Template',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1990-05-15',
                'jenis_kelamin' => 'L',
                'skpd' => 'Test SKPD',
                'ukpd' => 'Test UKPD',
                'no_telp' => '081234567890',
                'email' => 'test@example.com',
                'status_pegawai' => 'PNS',
            ]);

            // Create test schedule
            $schedule = Schedule::create([
                'participant_id' => $participant->id,
                'nik_ktp' => $participant->nik_ktp,
                'nrk_pegawai' => $participant->nrk_pegawai,
                'nama_lengkap' => $participant->nama_lengkap,
                'tanggal_lahir' => $participant->tanggal_lahir,
                'jenis_kelamin' => $participant->jenis_kelamin,
                'skpd' => $participant->skpd,
                'ukpd' => $participant->ukpd,
                'no_telp' => $participant->no_telp,
                'email' => $participant->email,
                'tanggal_pemeriksaan' => now()->addDays(7),
                'jam_pemeriksaan' => now()->setTime(9, 0),
                'lokasi_pemeriksaan' => 'Klinik Test MCU',
                'status' => 'Terjadwal',
                'queue_number' => 1,
            ]);

            return $schedule;
        } catch (\Exception $e) {
            $this->error('Error creating test schedule: ' . $e->getMessage());
            return null;
        }
    }

    private function testTemplateVariables(Schedule $schedule): void
    {
        $this->info('📋 Testing Template Variables:');
        $this->newLine();

        // Test EmailService template data
        $emailService = new EmailService();
        $emailReflection = new \ReflectionClass($emailService);
        $prepareMethod = $emailReflection->getMethod('prepareTemplateData');
        $prepareMethod->setAccessible(true);
        $emailData = $prepareMethod->invoke($emailService, $schedule);

        $this->table(
            ['Variable', 'Value', 'Description'],
            [
                ['nama_lengkap', $emailData['nama_lengkap'], 'Nama lengkap peserta'],
                ['nik_ktp', $emailData['nik_ktp'], 'NIK KTP'],
                ['nrk_pegawai', $emailData['nrk_pegawai'], 'NRK Pegawai'],
                ['tanggal_lahir', $emailData['tanggal_lahir'], 'Tanggal lahir (format: d/m/Y)'],
                ['jenis_kelamin', $emailData['jenis_kelamin'], 'Jenis kelamin (Laki-Laki/Perempuan)'],
                ['tanggal_pemeriksaan', $emailData['tanggal_pemeriksaan'], 'Tanggal MCU (format: d/m/Y)'],
                ['hari_pemeriksaan', $emailData['hari_pemeriksaan'], 'Hari pada tanggal MCU'],
                ['jam_pemeriksaan', $emailData['jam_pemeriksaan'], 'Jam MCU (format: H:i)'],
                ['lokasi_pemeriksaan', $emailData['lokasi_pemeriksaan'], 'Lokasi MCU'],
                ['queue_number', $emailData['queue_number'], 'Nomor antrian'],
                ['skpd', $emailData['skpd'], 'SKPD'],
                ['ukpd', $emailData['ukpd'], 'UKPD'],
                ['no_telp', $emailData['no_telp'], 'Nomor telepon'],
                ['email', $emailData['email'], 'Email'],
            ]
        );
    }

    private function testEmailTemplate(Schedule $schedule, string $email): void
    {
        $this->newLine();
        $this->info("📧 Testing Email Template to: {$email}");
        
        try {
            // Update schedule email for testing
            $schedule->update(['email' => $email]);
            
            // Get current email template
            $template = Setting::getValue('email_invitation_template', 'Kepada {nama_lengkap}, Anda diundang untuk mengikuti Medical Check Up.');
            $subject = Setting::getValue('email_invitation_subject', 'Undangan Medical Check Up');
            
            $this->info("📝 Current Email Template:");
            $this->line("Subject: {$subject}");
            $this->line("Body: {$template}");
            $this->newLine();
            
            // Test email service
            $emailService = new EmailService();
            $result = $emailService->sendMcuInvitation($schedule);
            
            if ($result) {
                $this->info('✅ Email sent successfully!');
            } else {
                $this->error('❌ Failed to send email');
            }
        } catch (\Exception $e) {
            $this->error('❌ Email test failed: ' . $e->getMessage());
        }
    }

    private function testWhatsAppTemplate(Schedule $schedule, string $whatsapp): void
    {
        $this->newLine();
        $this->info("📱 Testing WhatsApp Template to: {$whatsapp}");
        
        try {
            // Update schedule phone for testing
            $schedule->update(['no_telp' => $whatsapp]);
            
            // Get current WhatsApp template
            $template = Setting::getValue('whatsapp_invitation_template', 'Halo {nama_lengkap}, Anda diundang untuk mengikuti Medical Check Up pada tanggal {tanggal_pemeriksaan} pukul {jam_pemeriksaan} di {lokasi_pemeriksaan}.');
            
            $this->info("📝 Current WhatsApp Template:");
            $this->line($template);
            $this->newLine();
            
            // Test WhatsApp service
            $whatsappService = new WhatsAppService();
            $result = $whatsappService->sendMcuInvitation($schedule);
            
            if ($result) {
                $this->info('✅ WhatsApp sent successfully!');
            } else {
                $this->error('❌ Failed to send WhatsApp');
            }
        } catch (\Exception $e) {
            $this->error('❌ WhatsApp test failed: ' . $e->getMessage());
        }
    }
}