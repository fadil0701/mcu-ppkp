<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PdfTemplate;
use Illuminate\Support\Facades\Storage;

class CheckImageUpload extends Command
{
    protected $signature = 'image:check-upload';
    protected $description = 'Check image upload issues';

    public function handle()
    {
        $this->info("🔍 Checking Image Upload Issues...");
        
        // Check template
        $template = PdfTemplate::find(1);
        if (!$template) {
            $this->error("Template not found!");
            return 1;
        }
        
        $this->info("✅ Template found: {$template->name}");
        
        // Check image paths
        $this->info("\n📸 Current Image Paths:");
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
                $this->info("Logo permissions: " . substr(sprintf('%o', fileperms($logoPath)), -4));
            }
        }
        
        if ($template->signature_image_path) {
            $sigPath = storage_path('app/public/' . $template->signature_image_path);
            $this->info("Signature path: {$sigPath}");
            $this->info("Signature exists: " . (file_exists($sigPath) ? 'YES' : 'NO'));
            if (file_exists($sigPath)) {
                $this->info("Signature size: " . filesize($sigPath) . " bytes");
                $this->info("Signature permissions: " . substr(sprintf('%o', fileperms($sigPath)), -4));
            }
        }
        
        if ($template->stamp_image_path) {
            $stampPath = storage_path('app/public/' . $template->stamp_image_path);
            $this->info("Stamp path: {$stampPath}");
            $this->info("Stamp exists: " . (file_exists($stampPath) ? 'YES' : 'NO'));
            if (file_exists($stampPath)) {
                $this->info("Stamp size: " . filesize($stampPath) . " bytes");
                $this->info("Stamp permissions: " . substr(sprintf('%o', fileperms($stampPath)), -4));
            }
        }
        
        // Check storage directories
        $this->info("\n📁 Storage Directory Check:");
        
        $templateImagesDir = storage_path('app/public/template-images');
        $this->info("Template images directory: {$templateImagesDir}");
        $this->info("Directory exists: " . (is_dir($templateImagesDir) ? 'YES' : 'NO'));
        
        if (is_dir($templateImagesDir)) {
            $this->info("Directory permissions: " . substr(sprintf('%o', fileperms($templateImagesDir)), -4));
            $this->info("Directory writable: " . (is_writable($templateImagesDir) ? 'YES' : 'NO'));
            
            $files = scandir($templateImagesDir);
            $this->info("Files in directory: " . (count($files) - 2) . " files");
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    $filePath = $templateImagesDir . '/' . $file;
                    $this->info("  - {$file} (" . filesize($filePath) . " bytes)");
                }
            }
        }
        
        // Check storage link
        $this->info("\n🔗 Storage Link Check:");
        $publicStorageLink = public_path('storage');
        $this->info("Public storage link: {$publicStorageLink}");
        $this->info("Link exists: " . (is_link($publicStorageLink) ? 'YES' : 'NO'));
        
        if (is_link($publicStorageLink)) {
            $linkTarget = readlink($publicStorageLink);
            $this->info("Link target: {$linkTarget}");
            $this->info("Target exists: " . (file_exists($linkTarget) ? 'YES' : 'NO'));
        }
        
        // Check Filament FileUpload configuration
        $this->info("\n⚙️ Filament FileUpload Configuration:");
        $this->info("Storage disk: public");
        $this->info("Storage visibility: public");
        
        // Test file upload
        $this->info("\n🧪 Testing File Upload:");
        
        try {
            // Create test file
            $testContent = 'test image content';
            $testFilename = 'test_upload_' . time() . '.txt';
            $testPath = 'template-images/' . $testFilename;
            
            $result = Storage::disk('public')->put($testPath, $testContent);
            
            if ($result) {
                $this->info("✅ Test file upload successful: {$testPath}");
                
                // Check if file exists
                $exists = Storage::disk('public')->exists($testPath);
                $this->info("✅ Test file exists: " . ($exists ? 'YES' : 'NO'));
                
                // Get file URL
                $url = Storage::disk('public')->url($testPath);
                $this->info("✅ Test file URL: {$url}");
                
                // Clean up test file
                Storage::disk('public')->delete($testPath);
                $this->info("✅ Test file cleaned up");
                
            } else {
                $this->error("❌ Test file upload failed");
            }
            
        } catch (\Exception $e) {
            $this->error("❌ Test file upload error: " . $e->getMessage());
        }
        
        // Check PHP configuration
        $this->info("\n🐘 PHP Configuration:");
        $this->info("Upload max filesize: " . ini_get('upload_max_filesize'));
        $this->info("Post max size: " . ini_get('post_max_size'));
        $this->info("Max execution time: " . ini_get('max_execution_time'));
        $this->info("Memory limit: " . ini_get('memory_limit'));
        
        // Recommendations
        $this->info("\n💡 Recommendations:");
        
        if (!is_dir($templateImagesDir)) {
            $this->warn("⚠️ Create template-images directory: mkdir -p {$templateImagesDir}");
        }
        
        if (!is_link($publicStorageLink)) {
            $this->warn("⚠️ Create storage link: php artisan storage:link");
        }
        
        if (!is_writable($templateImagesDir)) {
            $this->warn("⚠️ Fix directory permissions: chmod 755 {$templateImagesDir}");
        }
        
        $this->info("\n🎉 Image upload check completed!");
        
        return 0;
    }
}