<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PdfTemplate;
use App\Models\Schedule;
use App\Models\Participant;
use App\Services\PdfService;

class TestPdfGeneration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pdf:test {email} {--template=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test PDF generation for MCU letter';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $templateId = $this->option('template');

        $this->info("Testing PDF generation for: {$email}");

        // Get template
        $template = null;
        if ($templateId) {
            $template = PdfTemplate::find($templateId);
            if (!$template) {
                $this->error("Template with ID {$templateId} not found!");
                return 1;
            }
        } else {
            $template = PdfTemplate::getDefault('mcu_letter');
            if (!$template) {
                $this->error("No default template found for type: mcu_letter");
                $this->info("Available templates:");
                $templates = PdfTemplate::getByType('mcu_letter');
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
                'nik_ktp' => '6474035106910002',
                'nrk_pegawai' => '12345',
                'nama_lengkap' => 'Armila Yunitasari',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1991-11-06',
                'jenis_kelamin' => 'P',
                'skpd' => 'Dinas Pariwisata dan Kebudayaan',
                'ukpd' => 'Sudin pariwisata jakarta utara',
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
                'tanggal_pemeriksaan' => '2025-10-03',
                'jam_pemeriksaan' => '07:30:00',
                'lokasi_pemeriksaan' => 'Klinik Utama Balaikota Blok A & F lantai dasar Jl. Medan Merdeka Selatan No. 8-9 Jakarta Pusat',
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

        // Generate PDF
        $this->info("\nGenerating PDF...");
        $pdfService = new PdfService();
        
        try {
            $pdfPath = $pdfService->generateMcuLetter($schedule, $template);
            $this->info("✅ PDF generated successfully!");
            $this->info("PDF saved to: {$pdfPath}");
            $this->info("File size: " . number_format(filesize($pdfPath) / 1024, 2) . " KB");
            
            // Also test content generation
            $this->info("\nTesting PDF content generation...");
            $pdfContent = $pdfService->generateMcuLetterContent($schedule, $template);
            $this->info("✅ PDF content generated successfully!");
            $this->info("Content size: " . number_format(strlen($pdfContent) / 1024, 2) . " KB");
            
        } catch (\Exception $e) {
            $this->error("❌ Failed to generate PDF: " . $e->getMessage());
            $this->error("Stack trace: " . $e->getTraceAsString());
            return 1;
        }

        return 0;
    }
}
