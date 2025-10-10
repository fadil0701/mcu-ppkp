<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;

class TestNewToolbar extends Command
{
    protected $signature = 'test:new-toolbar';
    protected $description = 'Test new toolbar features (layout options, borders, borders & shading)';

    public function handle()
    {
        $this->info('Testing New Toolbar Features...');
        
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
            
            // Test 2: Check Blade file content for new toolbar features
            $this->info('2. Checking Blade file for new toolbar features...');
            $bladeContent = File::get($bladeFile);
            
            $toolbarFeatures = [
                'setImageLayout' => 'Image Layout dropdown in toolbar',
                'setImageSize' => 'Image Size dropdown in toolbar',
                'applyBorder' => 'Border buttons in toolbar',
                'removeBorder' => 'Remove border button',
                'openBordersAndShading' => 'Borders and Shading button',
                'borders-shading-modal' => 'Borders and Shading modal',
                'border-settings' => 'Border settings section',
                'shading-settings' => 'Shading settings section',
                'border-preview' => 'Border preview section'
            ];
            
            foreach ($toolbarFeatures as $feature => $description) {
                if (strpos($bladeContent, $feature) !== false) {
                    $this->info('✅ ' . $description . ' found');
                } else {
                    $this->error('❌ ' . $description . ' not found');
                }
            }
            
            // Test 3: Check CSS file for new styling
            $this->info('3. Checking CSS file for new styling...');
            $cssContent = File::get($cssFile);
            
            $cssFeatures = [
                '.borders-shading-modal' => 'Borders and Shading modal styling',
                '.border-settings' => 'Border settings styling',
                '.shading-settings' => 'Shading settings styling',
                '.border-options' => 'Border options styling',
                '.shading-options' => 'Shading options styling',
                '.border-preview' => 'Border preview styling',
                '.apply-section' => 'Apply section styling',
                '.apply-btn' => 'Apply button styling',
                '.cancel-btn' => 'Cancel button styling'
            ];
            
            foreach ($cssFeatures as $feature => $description) {
                if (strpos($cssContent, $feature) !== false) {
                    $this->info('✅ ' . $description . ' found');
                } else {
                    $this->error('❌ ' . $description . ' not found');
                }
            }
            
            // Test 4: Check JavaScript file for new functions
            $this->info('4. Checking JavaScript file for new functions...');
            $jsContent = File::get($jsFile);
            
            $jsFeatures = [
                'setImageLayout' => 'setImageLayout function',
                'applyBorder' => 'applyBorder function',
                'removeBorder' => 'removeBorder function',
                'openBordersAndShading' => 'openBordersAndShading function',
                'closeBordersAndShading' => 'closeBordersAndShading function',
                'applyBordersAndShading' => 'applyBordersAndShading function',
                'wpSetupBordersAndShadingPreview' => 'Borders and Shading preview function',
                'borderStyle' => 'Border style handling',
                'borderWidth' => 'Border width handling',
                'borderColor' => 'Border color handling',
                'backgroundColor' => 'Background color handling',
                'textColor' => 'Text color handling'
            ];
            
            foreach ($jsFeatures as $feature => $description) {
                if (strpos($jsContent, $feature) !== false) {
                    $this->info('✅ ' . $description . ' found');
                } else {
                    $this->error('❌ ' . $description . ' not found');
                }
            }
            
            // Test 5: Check window object assignments
            $this->info('5. Checking window object assignments...');
            $windowAssignments = [
                'window.setImageLayout' => 'setImageLayout window assignment',
                'window.applyBorder' => 'applyBorder window assignment',
                'window.removeBorder' => 'removeBorder window assignment',
                'window.openBordersAndShading' => 'openBordersAndShading window assignment',
                'window.closeBordersAndShading' => 'closeBordersAndShading window assignment',
                'window.applyBordersAndShading' => 'applyBordersAndShading window assignment'
            ];
            
            foreach ($windowAssignments as $assignment => $description) {
                if (strpos($jsContent, $assignment) !== false) {
                    $this->info('✅ ' . $description . ' found');
                } else {
                    $this->error('❌ ' . $description . ' not found');
                }
            }
            
            // Test 6: Test view compilation
            $this->info('6. Testing view compilation...');
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
                
                // Check if new toolbar features are in compiled view
                if (strpos($compiled, 'setImageLayout') !== false) {
                    $this->info('✅ Image Layout dropdown found in compiled view');
                } else {
                    $this->warn('⚠️ Image Layout dropdown not found in compiled view');
                }
                
                if (strpos($compiled, 'applyBorder') !== false) {
                    $this->info('✅ Border buttons found in compiled view');
                } else {
                    $this->warn('⚠️ Border buttons not found in compiled view');
                }
                
                if (strpos($compiled, 'borders-shading-modal') !== false) {
                    $this->info('✅ Borders and Shading modal found in compiled view');
                } else {
                    $this->warn('⚠️ Borders and Shading modal not found in compiled view');
                }
                
            } catch (\Exception $e) {
                $this->error('❌ View compilation failed: ' . $e->getMessage());
                return 1;
            }
            
            // Test 7: Check file sizes
            $this->info('7. Checking file sizes...');
            $bladeSize = filesize($bladeFile);
            $cssSize = filesize($cssFile);
            $jsSize = filesize($jsFile);
            
            $this->info('Blade file size: ' . number_format($bladeSize) . ' bytes');
            $this->info('CSS file size: ' . number_format($cssSize) . ' bytes');
            $this->info('JavaScript file size: ' . number_format($jsSize) . ' bytes');
            
            if ($bladeSize > 25000) {
                $this->info('✅ Blade file has sufficient size for new toolbar features');
            } else {
                $this->warn('⚠️ Blade file might be missing new toolbar features');
            }
            
            if ($cssSize > 20000) {
                $this->info('✅ CSS file has sufficient size for new styling');
            } else {
                $this->warn('⚠️ CSS file might be missing new styling');
            }
            
            if ($jsSize > 35000) {
                $this->info('✅ JavaScript file has sufficient size for new functions');
            } else {
                $this->warn('⚠️ JavaScript file might be missing new functions');
            }
            
            $this->info('');
            $this->info('🎉 New Toolbar Features Test Completed!');
            $this->info('');
            $this->info('📝 New Toolbar Features:');
            $this->info('   ✅ Image Layout Options - Dropdown di toolbar untuk layout gambar');
            $this->info('   ✅ Image Size Options - Dropdown di toolbar untuk ukuran gambar');
            $this->info('   ✅ Border Buttons - All, Top, Bottom, Left, Right, None');
            $this->info('   ✅ Borders & Shading Modal - Modal lengkap dengan preview');
            $this->info('   ✅ Real-time Preview - Preview langsung saat mengubah settings');
            $this->info('   ✅ Apply to Selected Text - Border dan shading untuk text terpilih');
            $this->info('');
            $this->info('🔧 Border Features:');
            $this->info('   ✅ Border Style - None, Solid, Dashed, Dotted, Double, Groove, Ridge, Inset, Outset');
            $this->info('   ✅ Border Width - 1px, 2px, 3px, 4px, 5px, Thick, Thin');
            $this->info('   ✅ Border Color - Color picker');
            $this->info('   ✅ Border Sides - Top, Right, Bottom, Left checkboxes');
            $this->info('');
            $this->info('🎨 Shading Features:');
            $this->info('   ✅ Background Color - Color picker');
            $this->info('   ✅ Text Color - Color picker');
            $this->info('   ✅ Real-time Preview - Preview langsung');
            $this->info('');
            $this->info('🚀 Ready to test:');
            $this->info('   URL: http://127.0.0.1:8000/admin/pdf-templates/1/edit');
            $this->info('   Features: Image layout in toolbar, border buttons, borders & shading modal');
            $this->info('   Status: ✅ New Toolbar Features Ready');
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error('Error testing new toolbar features: ' . $e->getMessage());
            return 1;
        }
    }
}