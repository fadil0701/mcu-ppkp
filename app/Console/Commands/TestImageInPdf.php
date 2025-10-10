<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PdfTemplate;
use App\Models\Schedule;
use App\Models\Participant;
use App\Services\PdfService;

class TestImageInPdf extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pdf:test-image {email} {--template=} {--image-path=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test PDF generation with specific image';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $templateId = $this->option('template');
        $imagePath = $this->option('image-path');

        $this->info("Testing PDF generation with image for: {$email}");

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

        // If image path is provided, update template with test image
        if ($imagePath) {
            $this->info("Setting test image: {$imagePath}");
            
            // Copy image to template-images directory
            $filename = 'test_' . time() . '.png';
            $destination = storage_path('app/public/template-images/' . $filename);
            
            if (file_exists($imagePath)) {
                copy($imagePath, $destination);
                
                // Update template with test image
                $template->logo_path = 'template-images/' . $filename;
                $template->save();
                
                $this->info("✅ Test image set as logo: template-images/{$filename}");
            } else {
                $this->error("❌ Image file not found: {$imagePath}");
                return 1;
            }
        }

        // Display image information
        $this->info("\n📸 Template Images:");
        $this->info("- Logo: " . ($template->logo_path ? "✅ {$template->logo_path}" : "❌ Not set"));
        $this->info("- Signature: " . ($template->signature_image_path ? "✅ {$template->signature_image_path}" : "❌ Not set"));
        $this->info("- Stamp: " . ($template->stamp_image_path ? "✅ {$template->stamp_image_path}" : "❌ Not set"));

        // Check if images exist
        $this->info("\n🔍 Image File Check:");
        if ($template->logo_path) {
            $logoPath = storage_path('app/public/' . $template->logo_path);
            if (file_exists($logoPath)) {
                $this->info("✅ Logo exists: {$logoPath}");
                $this->info("   Size: " . number_format(filesize($logoPath) / 1024, 2) . " KB");
            } else {
                $this->error("❌ Logo not found: {$logoPath}");
            }
        }

        if ($template->signature_image_path) {
            $sigPath = storage_path('app/public/' . $template->signature_image_path);
            if (file_exists($sigPath)) {
                $this->info("✅ Signature exists: {$sigPath}");
                $this->info("   Size: " . number_format(filesize($sigPath) / 1024, 2) . " KB");
            } else {
                $this->error("❌ Signature not found: {$sigPath}");
            }
        }

        if ($template->stamp_image_path) {
            $stampPath = storage_path('app/public/' . $template->stamp_image_path);
            if (file_exists($stampPath)) {
                $this->info("✅ Stamp exists: {$stampPath}");
                $this->info("   Size: " . number_format(filesize($stampPath) / 1024, 2) . " KB");
            } else {
                $this->error("❌ Stamp not found: {$stampPath}");
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
            
        } catch (\Exception $e) {
            $this->error("❌ Failed to generate PDF: " . $e->getMessage());
            $this->error("Stack trace: " . $e->getTraceAsString());
            return 1;
        }

        $this->info("\n🎉 PDF generation with image test completed!");
        $this->info("💡 Check the generated PDF to see if images appear correctly.");

        return 0;
    }
}
