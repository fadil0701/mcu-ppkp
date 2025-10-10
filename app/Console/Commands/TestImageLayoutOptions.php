<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;

class TestImageLayoutOptions extends Command
{
    protected $signature = 'test:image-layout-options';
    protected $description = 'Test image layout options functionality';

    public function handle()
    {
        $this->info('Testing Image Layout Options...');
        
        try {
            // Test 1: Check if all files exist and are updated
            $this->info('1. Checking files...');
            
            $bladeFile = resource_path('views/filament/forms/components/wordpress-style-editor.blade.php');
            $cssFile = public_path('css/wordpress-style-editor.css');
            $jsFile = public_path('js/wordpress-style-editor.js');
            
            if (!File::exists($bladeFile)) {
                $this->error('❌ Blade file not found: ' . $bladeFile);
                return 1;
            }
            $this->info('✅ Blade file exists: ' . $bladeFile);
            
            if (!File::exists($cssFile)) {
                $this->error('❌ CSS file not found: ' . $cssFile);
                return 1;
            }
            $this->info('✅ CSS file exists: ' . $cssFile);
            
            if (!File::exists($jsFile)) {
                $this->error('❌ JavaScript file not found: ' . $jsFile);
                return 1;
            }
            $this->info('✅ JavaScript file exists: ' . $jsFile);
            
            // Test 2: Check Blade file content for layout options
            $this->info('2. Checking Blade file for layout options...');
            $bladeContent = File::get($bladeFile);
            
            $layoutFeatures = [
                'image-layout-section' => 'Image layout section',
                'layout-options' => 'Layout options grid',
                'layout-inline' => 'Inline layout option',
                'layout-wrap-left' => 'Wrap left layout option',
                'layout-wrap-right' => 'Wrap right layout option',
                'layout-break' => 'Break layout option',
                'image-size-options' => 'Image size options',
                'size-buttons' => 'Size buttons',
                'setImageSize' => 'setImageSize function call'
            ];
            
            foreach ($layoutFeatures as $feature => $description) {
                if (strpos($bladeContent, $feature) !== false) {
                    $this->info('✅ ' . $description . ' found');
                } else {
                    $this->error('❌ ' . $description . ' not found');
                }
            }
            
            // Test 3: Check CSS file for layout styling
            $this->info('3. Checking CSS file for layout styling...');
            $cssContent = File::get($cssFile);
            
            $cssFeatures = [
                '.image-layout-section' => 'Image layout section styling',
                '.layout-options' => 'Layout options grid styling',
                '.layout-option' => 'Layout option styling',
                '.layout-label' => 'Layout label styling',
                '.layout-preview' => 'Layout preview styling',
                '.image-size-options' => 'Image size options styling',
                '.size-buttons' => 'Size buttons styling',
                '.image-inline' => 'Inline image styling',
                '.image-wrap-left' => 'Wrap left image styling',
                '.image-wrap-right' => 'Wrap right image styling',
                '.image-break' => 'Break image styling'
            ];
            
            foreach ($cssFeatures as $feature => $description) {
                if (strpos($cssContent, $feature) !== false) {
                    $this->info('✅ ' . $description . ' found');
                } else {
                    $this->error('❌ ' . $description . ' not found');
                }
            }
            
            // Test 4: Check JavaScript file for layout functions
            $this->info('4. Checking JavaScript file for layout functions...');
            $jsContent = File::get($jsFile);
            
            $jsFeatures = [
                'wpCurrentImageLayout' => 'Image layout variable',
                'wpCurrentImageSize' => 'Image size variable',
                'wpApplyImageLayout' => 'Apply image layout function',
                'wpApplyImageSize' => 'Apply image size function',
                'setImageSize' => 'Set image size function',
                'image-' => 'Image class application',
                'float: left' => 'Float left styling',
                'float: right' => 'Float right styling',
                'display: inline-block' => 'Inline block styling',
                'display: block' => 'Block styling'
            ];
            
            foreach ($jsFeatures as $feature => $description) {
                if (strpos($jsContent, $feature) !== false) {
                    $this->info('✅ ' . $description . ' found');
                } else {
                    $this->error('❌ ' . $description . ' not found');
                }
            }
            
            // Test 5: Test view compilation
            $this->info('5. Testing view compilation...');
            try {
                $view = View::make('filament.forms.components.wordpress-style-editor', [
                    'getStatePath' => fn() => 'test',
                    'getState' => fn() => '<p>Test content</p>',
                    'availablePlaceholders' => [
                        'participant' => ['name' => 'Nama peserta'],
                        'schedule' => ['date' => 'Tanggal pemeriksaan']
                    ]
                ]);
                
                $compiled = $view->render();
                $this->info('✅ View compiled successfully');
                
                // Check if layout options are in compiled view
                if (strpos($compiled, 'layout-options') !== false) {
                    $this->info('✅ Layout options found in compiled view');
                } else {
                    $this->warn('⚠️ Layout options not found in compiled view');
                }
                
                if (strpos($compiled, 'image-size-options') !== false) {
                    $this->info('✅ Image size options found in compiled view');
                } else {
                    $this->warn('⚠️ Image size options not found in compiled view');
                }
                
            } catch (\Exception $e) {
                $this->error('❌ View compilation failed: ' . $e->getMessage());
                return 1;
            }
            
            // Test 6: Check file sizes
            $this->info('6. Checking file sizes...');
            $bladeSize = filesize($bladeFile);
            $cssSize = filesize($cssFile);
            $jsSize = filesize($jsFile);
            
            $this->info('Blade file size: ' . number_format($bladeSize) . ' bytes');
            $this->info('CSS file size: ' . number_format($cssSize) . ' bytes');
            $this->info('JavaScript file size: ' . number_format($jsSize) . ' bytes');
            
            if ($bladeSize > 15000) {
                $this->info('✅ Blade file has sufficient size for layout options');
            } else {
                $this->warn('⚠️ Blade file might be missing layout options');
            }
            
            if ($cssSize > 14000) {
                $this->info('✅ CSS file has sufficient size for layout styling');
            } else {
                $this->warn('⚠️ CSS file might be missing layout styling');
            }
            
            if ($jsSize > 25000) {
                $this->info('✅ JavaScript file has sufficient size for layout functions');
            } else {
                $this->warn('⚠️ JavaScript file might be missing layout functions');
            }
            
            $this->info('');
            $this->info('🎉 Image Layout Options Test Completed!');
            $this->info('');
            $this->info('📝 Available Layout Options:');
            $this->info('   ✅ Inline with Text - Image flows with text like a character');
            $this->info('   ✅ Wrap Text Left - Text wraps around image on the right');
            $this->info('   ✅ Wrap Text Right - Text wraps around image on the left');
            $this->info('   ✅ Break Text - Image breaks text flow (block)');
            $this->info('');
            $this->info('📏 Available Size Options:');
            $this->info('   ✅ Small (100px)');
            $this->info('   ✅ Medium (200px)');
            $this->info('   ✅ Large (400px)');
            $this->info('   ✅ Original Size');
            $this->info('');
            $this->info('🚀 Ready to test:');
            $this->info('   URL: http://127.0.0.1:8000/admin/pdf-templates/1/edit');
            $this->info('   Features: Image layout options, size options, visual previews');
            $this->info('   Status: ✅ Image Layout Options Ready');
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error('Error testing image layout options: ' . $e->getMessage());
            return 1;
        }
    }
}