<?php

namespace App\Console\Commands;

use App\Models\Schedule;
use App\Services\EmailService;
use Illuminate\Console\Command;

class TestMcuEmail extends Command
{
    protected $signature = 'email:test-mcu {email}';
    protected $description = 'Test MCU email invitation to specific email address';

    public function handle()
    {
        $email = $this->argument('email');
        
        $this->info("Testing MCU email invitation to: {$email}");
        
        // Create or find a test schedule
        $schedule = Schedule::where('email', $email)->first();
        
        if (!$schedule) {
            $this->info("Creating test schedule for {$email}...");
            
            $schedule = Schedule::create([
                'participant_id' => 1,
                'nik_ktp' => '1234567890123456',
                'nrk_pegawai' => 'TEST001',
                'nama_lengkap' => 'Test User',
                'tanggal_lahir' => '1990-01-01',
                'jenis_kelamin' => 'L',
                'skpd' => 'Test SKPD',
                'ukpd' => 'Test UKPD',
                'no_telp' => '081234567890',
                'email' => $email,
                'tanggal_pemeriksaan' => now()->addDay(),
                'jam_pemeriksaan' => '09:00',
                'lokasi_pemeriksaan' => 'Klinik Test',
                'status' => 'Terjadwal',
                'email_sent' => false,
            ]);
            
            $this->info("Test schedule created with ID: {$schedule->id}");
        }
        
        $this->info("Schedule details:");
        $this->info("- Nama: {$schedule->nama_lengkap}");
        $this->info("- Email: {$schedule->email}");
        $this->info("- Tanggal: {$schedule->tanggal_pemeriksaan}");
        $this->info("- Jam: {$schedule->jam_pemeriksaan}");
        $this->info("- Lokasi: {$schedule->lokasi_pemeriksaan}");
        
        try {
            $emailService = new EmailService();
            $result = $emailService->sendMcuInvitation($schedule);
            
            if ($result) {
                $this->info("✅ Email berhasil dikirim ke {$schedule->email}!");
                $this->info("📎 PDF attachment included");
                $this->info("✅ Schedule ID {$schedule->id} telah diupdate.");
            } else {
                $this->error("❌ Email gagal dikirim ke {$schedule->email}");
            }
            
        } catch (\Exception $e) {
            $this->error("❌ Error: " . $e->getMessage());
            $this->error("File: " . $e->getFile() . " Line: " . $e->getLine());
        }
    }
}
