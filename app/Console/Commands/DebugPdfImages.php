<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PdfTemplate;
use App\Models\Schedule;
use App\Models\Participant;
use App\Services\PdfService;

class DebugPdfImages extends Command
{
    protected $signature = 'pdf:debug-images {email}';
    protected $description = 'Debug PDF image processing step by step';

    public function handle()
    {
        $email = $this->argument('email');
        
        $this->info("🔍 Debugging PDF image processing for: {$email}");
        
        // Get template
        $template = PdfTemplate::getDefault('mcu_letter');
        if (!$template) {
            $this->error("No template found!");
            return 1;
        }
        
        $this->info("📋 Using template: {$template->name} (ID: {$template->id})");
        
        // Check template images
        $this->info("\n📸 Template Image Paths:");
        $this->info("- Logo: " . ($template->logo_path ?: 'NULL'));
        $this->info("- Signature: " . ($template->signature_image_path ?: 'NULL'));
        $this->info("- Stamp: " . ($template->stamp_image_path ?: 'NULL'));
        
        // Check if files exist
        $this->info("\n🔍 File Existence Check:");
        
        if ($template->logo_path) {
            $logoPath = storage_path('app/public/' . $template->logo_path);
            $this->info("Logo path: {$logoPath}");
            $this->info("Logo exists: " . (file_exists($logoPath) ? 'YES' : 'NO'));
            if (file_exists($logoPath)) {
                $this->info("Logo size: " . filesize($logoPath) . " bytes");
                $this->info("Logo mime: " . mime_content_type($logoPath));
            }
        }
        
        if ($template->signature_image_path) {
            $sigPath = storage_path('app/public/' . $template->signature_image_path);
            $this->info("Signature path: {$sigPath}");
            $this->info("Signature exists: " . (file_exists($sigPath) ? 'YES' : 'NO'));
            if (file_exists($sigPath)) {
                $this->info("Signature size: " . filesize($sigPath) . " bytes");
                $this->info("Signature mime: " . mime_content_type($sigPath));
            }
        }
        
        if ($template->stamp_image_path) {
            $stampPath = storage_path('app/public/' . $template->stamp_image_path);
            $this->info("Stamp path: {$stampPath}");
            $this->info("Stamp exists: " . (file_exists($stampPath) ? 'YES' : 'NO'));
            if (file_exists($stampPath)) {
                $this->info("Stamp size: " . filesize($stampPath) . " bytes");
                $this->info("Stamp mime: " . mime_content_type($stampPath));
            }
        }
        
        // Create test schedule
        $participant = Participant::firstOrCreate(
            ['email' => $email],
            [
                'nik_ktp' => '6474035106910002',
                'nrk_pegawai' => '12345',
                'nama_lengkap' => 'Test User',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1991-11-06',
                'jenis_kelamin' => 'P',
                'skpd' => 'Test SKPD',
                'ukpd' => 'Test UKPD',
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
                'lokasi_pemeriksaan' => 'Test Location',
                'status' => 'Terjadwal',
                'queue_number' => 1,
            ]
        );
        
        // Test image processing directly
        $this->info("\n🔄 Testing image processing...");
        
        $pdfService = new PdfService();
        
        // Use reflection to access private methods
        $reflection = new \ReflectionClass($pdfService);
        
        // Test getImageBase64 method
        $getImageBase64Method = $reflection->getMethod('getImageBase64');
        $getImageBase64Method->setAccessible(true);
        
        $this->info("\n🖼️ Testing image base64 conversion:");
        
        if ($template->logo_path) {
            $logoBase64 = $getImageBase64Method->invoke($pdfService, $template, 'logo');
            $this->info("Logo base64 length: " . strlen($logoBase64));
            $this->info("Logo base64 preview: " . substr($logoBase64, 0, 100) . "...");
        }
        
        if ($template->signature_image_path) {
            $sigBase64 = $getImageBase64Method->invoke($pdfService, $template, 'signature');
            $this->info("Signature base64 length: " . strlen($sigBase64));
            $this->info("Signature base64 preview: " . substr($sigBase64, 0, 100) . "...");
        }
        
        if ($template->stamp_image_path) {
            $stampBase64 = $getImageBase64Method->invoke($pdfService, $template, 'stamp');
            $this->info("Stamp base64 length: " . strlen($stampBase64));
            $this->info("Stamp base64 preview: " . substr($stampBase64, 0, 100) . "...");
        }
        
        // Test HTML processing
        $this->info("\n🔄 Testing HTML processing...");
        
        $processImagesMethod = $reflection->getMethod('processImagesInHtml');
        $processImagesMethod->setAccessible(true);
        
        $testHtml = '<div>{logo_image}</div><div>{signature_image}</div><div>{stamp_image}</div>';
        $processedHtml = $processImagesMethod->invoke($pdfService, $testHtml, $template);
        
        $this->info("Original HTML: {$testHtml}");
        $this->info("Processed HTML length: " . strlen($processedHtml));
        $this->info("Processed HTML preview: " . substr($processedHtml, 0, 200) . "...");
        
        // Generate actual PDF and save HTML for inspection
        $this->info("\n🔄 Generating PDF...");
        
        try {
            $pdfContent = $pdfService->generateMcuLetterContent($schedule, $template);
            
            // Save HTML for inspection
            $htmlFile = storage_path('app/public/debug_template.html');
            file_put_contents($htmlFile, $this->getHtmlFromPdfService($pdfService, $schedule, $template));
            
            $this->info("✅ PDF generated successfully!");
            $this->info("📄 PDF size: " . strlen($pdfContent) . " bytes");
            $this->info("📄 HTML saved to: {$htmlFile}");
            
        } catch (\Exception $e) {
            $this->error("❌ PDF generation failed: " . $e->getMessage());
            $this->error("Stack trace: " . $e->getTraceAsString());
        }
        
        return 0;
    }
    
    private function getHtmlFromPdfService(PdfService $pdfService, Schedule $schedule, PdfTemplate $template): string
    {
        $reflection = new \ReflectionClass($pdfService);
        
        // Get prepareTemplateData method
        $prepareMethod = $reflection->getMethod('prepareTemplateData');
        $prepareMethod->setAccessible(true);
        $templateData = $prepareMethod->invoke($pdfService, $schedule);
        
        // Get render method from template
        $rendered = $template->render($templateData);
        
        // Get buildHtmlDocument method
        $buildMethod = $reflection->getMethod('buildHtmlDocument');
        $buildMethod->setAccessible(true);
        
        return $buildMethod->invoke($pdfService, $rendered, $template);
    }
}