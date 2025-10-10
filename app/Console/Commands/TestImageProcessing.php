<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PdfTemplate;

class TestImageProcessing extends Command
{
    protected $signature = 'image:test-processing';
    protected $description = 'Test image processing step by step';

    public function handle()
    {
        $this->info("🔍 Testing image processing...");
        
        $template = PdfTemplate::find(1);
        if (!$template) {
            $this->error("Template not found!");
            return 1;
        }
        
        $this->info("Template: {$template->name}");
        
        // Test each image type
        $imageTypes = ['logo', 'signature', 'stamp'];
        
        foreach ($imageTypes as $type) {
            $this->info("\n=== Testing {$type} ===");
            
            $imagePath = '';
            switch ($type) {
                case 'logo':
                    $imagePath = $template->logo_path;
                    break;
                case 'signature':
                    $imagePath = $template->signature_image_path;
                    break;
                case 'stamp':
                    $imagePath = $template->stamp_image_path;
                    break;
            }
            
            $this->info("Image path: " . ($imagePath ?: 'NULL'));
            
            if ($imagePath) {
                $fullPath = storage_path('app/public/' . $imagePath);
                $this->info("Full path: {$fullPath}");
                $this->info("File exists: " . (file_exists($fullPath) ? 'YES' : 'NO'));
                
                if (file_exists($fullPath)) {
                    $fileSize = filesize($fullPath);
                    $this->info("File size: {$fileSize} bytes");
                    
                    if ($fileSize > 500000) {
                        $this->warn("File too large (>500KB)");
                        continue;
                    }
                    
                    $mimeType = mime_content_type($fullPath);
                    $this->info("MIME type: {$mimeType}");
                    
                    // Test image processing
                    try {
                        $imageInfo = getimagesize($fullPath);
                        if ($imageInfo) {
                            $this->info("Image info: {$imageInfo[0]}x{$imageInfo[1]}");
                            
                            // Test image creation with error suppression
                            switch ($mimeType) {
                                case 'image/jpeg':
                                    $sourceImage = @imagecreatefromjpeg($fullPath);
                                    break;
                                case 'image/png':
                                    $sourceImage = @imagecreatefrompng($fullPath);
                                    break;
                                case 'image/gif':
                                    $sourceImage = @imagecreatefromgif($fullPath);
                                    break;
                                default:
                                    $sourceImage = null;
                            }
                            
                            if ($sourceImage) {
                                $this->info("✅ Image created successfully");
                                
                                // Test resize
                                $maxWidth = 120;
                                $maxHeight = 120;
                                
                                $width = $imageInfo[0];
                                $height = $imageInfo[1];
                                $ratio = min($maxWidth / $width, $maxHeight / $height);
                                $newWidth = intval($width * $ratio);
                                $newHeight = intval($height * $ratio);
                                
                                $this->info("Resize to: {$newWidth}x{$newHeight}");
                                
                                $newImage = imagecreatetruecolor($newWidth, $newHeight);
                                
                                if ($mimeType === 'image/png') {
                                    imagealphablending($newImage, false);
                                    imagesavealpha($newImage, true);
                                    $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
                                    imagefilledrectangle($newImage, 0, 0, $newWidth, $newHeight, $transparent);
                                }
                                
                                imagecopyresampled(
                                    $newImage, $sourceImage,
                                    0, 0, 0, 0,
                                    $newWidth, $newHeight,
                                    $width, $height
                                );
                                
                                // Test output
                                ob_start();
                                imagepng($newImage, null, 6);
                                $imageData = ob_get_contents();
                                ob_end_clean();
                                
                                $this->info("✅ Resized image data: " . strlen($imageData) . " bytes");
                                
                                // Test base64
                                $base64 = base64_encode($imageData);
                                $this->info("✅ Base64 length: " . strlen($base64));
                                
                                // Test HTML generation
                                $html = '<img src="data:image/png;base64,' . $base64 . '" class="' . $type . '-image" alt="' . ucfirst($type) . '">';
                                $this->info("✅ HTML generated: " . strlen($html) . " chars");
                                
                                imagedestroy($sourceImage);
                                imagedestroy($newImage);
                                
                            } else {
                                $this->error("❌ Failed to create image from file");
                            }
                        } else {
                            $this->error("❌ Failed to get image info");
                        }
                    } catch (\Exception $e) {
                        $this->error("❌ Exception: " . $e->getMessage());
                    }
                }
            }
        }
        
        return 0;
    }
}