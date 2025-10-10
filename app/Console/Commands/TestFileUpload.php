<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class TestFileUpload extends Command
{
    protected $signature = 'upload:test {--size=1}';
    protected $description = 'Test file upload with different sizes';

    public function handle()
    {
        $size = $this->option('size'); // Size in MB
        $this->info("🧪 Testing file upload with {$size}MB file...");
        
        // Create test file
        $testContent = str_repeat('A', $size * 1024 * 1024); // Create content of specified size
        $testFilename = 'test_upload_' . $size . 'mb_' . time() . '.txt';
        $testPath = 'template-images/' . $testFilename;
        
        $this->info("Creating test file: {$testFilename}");
        $this->info("File size: " . strlen($testContent) . " bytes (" . number_format(strlen($testContent) / 1024 / 1024, 2) . " MB)");
        
        try {
            $startTime = microtime(true);
            
            // Test upload
            $result = Storage::disk('public')->put($testPath, $testContent);
            
            $endTime = microtime(true);
            $uploadTime = $endTime - $startTime;
            
            if ($result) {
                $this->info("✅ Upload successful!");
                $this->info("Upload time: " . number_format($uploadTime, 2) . " seconds");
                
                // Check if file exists
                $exists = Storage::disk('public')->exists($testPath);
                $this->info("File exists: " . ($exists ? 'YES' : 'NO'));
                
                if ($exists) {
                    $actualSize = Storage::disk('public')->size($testPath);
                    $this->info("Actual file size: " . $actualSize . " bytes");
                    
                    // Get file URL
                    $url = Storage::disk('public')->url($testPath);
                    $this->info("File URL: {$url}");
                    
                    // Test file access
                    $content = Storage::disk('public')->get($testPath);
                    $this->info("File readable: " . (strlen($content) > 0 ? 'YES' : 'NO'));
                    
                    // Clean up
                    Storage::disk('public')->delete($testPath);
                    $this->info("✅ Test file cleaned up");
                }
                
            } else {
                $this->error("❌ Upload failed");
            }
            
        } catch (\Exception $e) {
            $this->error("❌ Upload error: " . $e->getMessage());
            $this->error("Stack trace: " . $e->getTraceAsString());
        }
        
        // Test different file sizes
        $this->info("\n📊 Testing different file sizes:");
        
        $testSizes = [0.1, 0.5, 1, 2, 5, 10]; // MB
        
        foreach ($testSizes as $testSize) {
            if ($testSize <= $size) {
                $this->info("Testing {$testSize}MB file...");
                
                $testContent = str_repeat('B', $testSize * 1024 * 1024);
                $testFilename = 'test_' . $testSize . 'mb_' . time() . '.txt';
                $testPath = 'template-images/' . $testFilename;
                
                try {
                    $result = Storage::disk('public')->put($testPath, $testContent);
                    
                    if ($result) {
                        $this->info("✅ {$testSize}MB upload successful");
                        Storage::disk('public')->delete($testPath);
                    } else {
                        $this->error("❌ {$testSize}MB upload failed");
                    }
                    
                } catch (\Exception $e) {
                    $this->error("❌ {$testSize}MB upload error: " . $e->getMessage());
                }
            }
        }
        
        $this->info("\n🎉 File upload test completed!");
        
        return 0;
    }
}