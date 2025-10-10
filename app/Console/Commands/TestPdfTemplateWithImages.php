<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PdfTemplate;
use App\Models\Schedule;
use App\Models\Participant;
use App\Services\PdfService;

class TestPdfTemplateWithImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pdf:test-with-images {email} {--template=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test PDF generation with image support';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $templateId = $this->option('template');

        $this->info("Testing PDF generation with images for: {$email}");

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
                return 1;
            }
        }

        $this->info("Using template: {$template->name} (ID: {$template->id})");

        // Display image information
        $this->info("\n📸 Template Images:");
        $this->info("- Logo: " . ($template->logo_path ? "✅ {$template->logo_path}" : "❌ Not set"));
        $this->info("- Signature: " . ($template->signature_image_path ? "✅ {$template->signature_image_path}" : "❌ Not set"));
        $this->info("- Stamp: " . ($template->stamp_image_path ? "✅ {$template->stamp_image_path}" : "❌ Not set"));

        if ($template->image_settings) {
            $this->info("\n⚙️ Image Settings:");
            foreach ($template->image_settings as $type => $settings) {
                $this->info("- {$type}: {$settings['width']}x{$settings['height']}px, {$settings['position']}");
            }
        }

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

        $this->info("\n📋 Schedule details:");
        $this->info("- Nama: {$schedule->nama_lengkap}");
        $this->info("- Email: {$schedule->email}");
        $this->info("- Tanggal: {$schedule->tanggal_pemeriksaan}");
        $this->info("- Jam: {$schedule->jam_pemeriksaan}");
        $this->info("- Lokasi: {$schedule->lokasi_pemeriksaan}");

        // Generate PDF
        $this->info("\n🔄 Generating PDF with image support...");
        $pdfService = new PdfService();
        
        try {
            $pdfPath = $pdfService->generateMcuLetter($schedule, $template);
            $this->info("✅ PDF generated successfully!");
            $this->info("📄 PDF saved to: {$pdfPath}");
            $this->info("📊 File size: " . number_format(filesize($pdfPath) / 1024, 2) . " KB");
            
            // Also test content generation
            $this->info("\n🔄 Testing PDF content generation...");
            $pdfContent = $pdfService->generateMcuLetterContent($schedule, $template);
            $this->info("✅ PDF content generated successfully!");
            $this->info("📊 Content size: " . number_format(strlen($pdfContent) / 1024, 2) . " KB");
            
            // Check if images are included
            $this->info("\n🖼️ Image Analysis:");
            if ($template->logo_path && file_exists(storage_path('app/public/' . $template->logo_path))) {
                $this->info("✅ Logo image found and accessible");
            } else {
                $this->warn("⚠️ Logo image not found or not accessible");
            }
            
            if ($template->signature_image_path && file_exists(storage_path('app/public/' . $template->signature_image_path))) {
                $this->info("✅ Signature image found and accessible");
            } else {
                $this->warn("⚠️ Signature image not found or not accessible");
            }
            
            if ($template->stamp_image_path && file_exists(storage_path('app/public/' . $template->stamp_image_path))) {
                $this->info("✅ Stamp image found and accessible");
            } else {
                $this->warn("⚠️ Stamp image not found or not accessible");
            }
            
        } catch (\Exception $e) {
            $this->error("❌ Failed to generate PDF: " . $e->getMessage());
            $this->error("Stack trace: " . $e->getTraceAsString());
            return 1;
        }

        $this->info("\n🎉 PDF Template with Images test completed successfully!");
        $this->info("💡 To add images to your template:");
        $this->info("   1. Go to Admin Panel → Email Management → PDF Templates");
        $this->info("   2. Edit your template");
        $this->info("   3. Upload images in the 'Template Images' section");
        $this->info("   4. Save and test again");

        return 0;
    }
}
