<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class TestFileUploadFix extends Command
{
    protected $signature = 'file:test-upload-fix';
    protected $description = 'Test FileUpload configuration and fix issues';

    public function handle()
    {
        $this->info("🔍 Testing FileUpload Configuration...");
        
        // Test 1: Check storage link
        $this->testStorageLink();
        
        // Test 2: Check directory permissions
        $this->testDirectoryPermissions();
        
        // Test 3: Check disk configuration
        $this->testDiskConfiguration();
        
        // Test 4: Test file upload simulation
        $this->testFileUploadSimulation();
        
        $this->info("\n🎉 FileUpload test completed!");
        
        return 0;
    }
    
    private function testStorageLink()
    {
        $this->info("\n📁 Testing Storage Link...");
        
        $linkPath = public_path('storage');
        $targetPath = storage_path('app/public');
        
        if (is_link($linkPath)) {
            $this->info("✅ Storage link exists");
            
            $target = readlink($linkPath);
            if ($target === $targetPath) {
                $this->info("✅ Storage link points to correct target");
            } else {
                $this->error("❌ Storage link points to wrong target: {$target}");
                $this->warn("Expected: {$targetPath}");
            }
        } else {
            $this->error("❌ Storage link does not exist");
            $this->info("Creating storage link...");
            
            try {
                \Artisan::call('storage:link');
                $this->info("✅ Storage link created");
            } catch (\Exception $e) {
                $this->error("❌ Failed to create storage link: " . $e->getMessage());
            }
        }
    }
    
    private function testDirectoryPermissions()
    {
        $this->info("\n🔐 Testing Directory Permissions...");
        
        $directories = [
            storage_path('app/public'),
            storage_path('app/public/template-images'),
            public_path('storage'),
        ];
        
        foreach ($directories as $dir) {
            if (is_dir($dir)) {
                if (is_writable($dir)) {
                    $this->info("✅ Directory writable: " . basename($dir));
                } else {
                    $this->error("❌ Directory not writable: " . basename($dir));
                }
            } else {
                $this->warn("⚠️ Directory does not exist: " . basename($dir));
                
                // Try to create directory
                try {
                    mkdir($dir, 0755, true);
                    $this->info("✅ Directory created: " . basename($dir));
                } catch (\Exception $e) {
                    $this->error("❌ Failed to create directory: " . $e->getMessage());
                }
            }
        }
    }
    
    private function testDiskConfiguration()
    {
        $this->info("\n💾 Testing Disk Configuration...");
        
        try {
            $disk = Storage::disk('public');
            $this->info("✅ Public disk accessible");
            
            // Test write
            $testContent = 'test file content ' . time();
            $testPath = 'template-images/test-' . time() . '.txt';
            
            if ($disk->put($testPath, $testContent)) {
                $this->info("✅ File write test successful");
                
                // Test read
                if ($disk->exists($testPath)) {
                    $this->info("✅ File read test successful");
                    
                    // Clean up
                    $disk->delete($testPath);
                    $this->info("✅ File cleanup successful");
                } else {
                    $this->error("❌ File read test failed");
                }
            } else {
                $this->error("❌ File write test failed");
            }
            
        } catch (\Exception $e) {
            $this->error("❌ Disk configuration error: " . $e->getMessage());
        }
    }
    
    private function testFileUploadSimulation()
    {
        $this->info("\n📤 Testing File Upload Simulation...");
        
        try {
            // Create a test image file
            $testImagePath = storage_path('app/test-image.png');
            
            // Create a simple PNG file (1x1 pixel)
            $pngData = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');
            file_put_contents($testImagePath, $pngData);
            
            // Simulate UploadedFile
            $uploadedFile = new UploadedFile(
                $testImagePath,
                'test-image.png',
                'image/png',
                null,
                true
            );
            
            $this->info("✅ Test image created");
            
            // Test upload to public disk
            $disk = Storage::disk('public');
            $uploadPath = 'template-images/test-upload-' . time() . '.png';
            
            if ($disk->putFileAs('template-images', $uploadedFile, basename($uploadPath))) {
                $this->info("✅ File upload simulation successful");
                
                // Check if file exists
                if ($disk->exists($uploadPath)) {
                    $this->info("✅ Uploaded file exists");
                    
                    // Get URL
                    $url = $disk->url($uploadPath);
                    $this->info("✅ File URL: {$url}");
                    
                    // Clean up
                    $disk->delete($uploadPath);
                    unlink($testImagePath);
                    $this->info("✅ Cleanup successful");
                } else {
                    $this->error("❌ Uploaded file does not exist");
                }
            } else {
                $this->error("❌ File upload simulation failed");
            }
            
        } catch (\Exception $e) {
            $this->error("❌ File upload simulation error: " . $e->getMessage());
        }
    }
}