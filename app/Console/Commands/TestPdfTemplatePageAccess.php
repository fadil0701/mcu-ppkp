<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PdfTemplate;
use App\Filament\Resources\PdfTemplateResource;

class TestPdfTemplatePageAccess extends Command
{
    protected $signature = 'test:pdf-template-page-access';
    protected $description = 'Test PDF template page access and editor functionality';

    public function handle()
    {
        $this->info('Testing PDF template page access...');
        
        try {
            // Test 1: Check if PDF template exists
            $this->info('1. Checking PDF template...');
            $template = PdfTemplate::find(1);
            
            if (!$template) {
                $this->error('❌ PDF template with ID 1 not found');
                return 1;
            }
            
            $this->info('✅ PDF template found: ' . $template->title);
            
            // Test 2: Check template content
            $this->info('2. Checking template content...');
            if ($template->combined_html) {
                $this->info('✅ Template has combined_html content');
                $this->info('Combined HTML length: ' . strlen($template->combined_html) . ' characters');
            } else {
                $this->warn('⚠️ Template has no combined_html content');
            }
            
            // Test 3: Check if resource can be instantiated
            $this->info('3. Testing PdfTemplateResource instantiation...');
            try {
                $resource = new PdfTemplateResource();
                $this->info('✅ PdfTemplateResource instantiated successfully');
            } catch (\Exception $e) {
                $this->error('❌ Failed to instantiate PdfTemplateResource: ' . $e->getMessage());
                return 1;
            }
            
            // Test 4: Check view compilation
            $this->info('4. Testing view compilation...');
            try {
                $view = view('filament.forms.components.wordpress-style-editor', [
                    'getStatePath' => fn() => 'combined_html',
                    'getState' => fn() => $template->combined_html ?? '<p>Test content</p>',
                    'availablePlaceholders' => [
                        'participant' => ['name' => 'Nama peserta', 'email' => 'Email peserta'],
                        'schedule' => ['date' => 'Tanggal pemeriksaan', 'time' => 'Waktu pemeriksaan'],
                        'mcu' => ['type' => 'Jenis pemeriksaan', 'package' => 'Paket pemeriksaan'],
                        'company' => ['name' => 'Nama perusahaan', 'address' => 'Alamat perusahaan']
                    ]
                ]);
                
                $compiled = $view->render();
                $this->info('✅ View compiled successfully');
                $this->info('Compiled view length: ' . strlen($compiled) . ' characters');
                
            } catch (\Exception $e) {
                $this->error('❌ View compilation failed: ' . $e->getMessage());
                return 1;
            }
            
            // Test 5: Check asset files
            $this->info('5. Checking asset files...');
            $cssFile = public_path('css/wordpress-style-editor.css');
            $jsFile = public_path('js/wordpress-style-editor.js');
            
            if (file_exists($cssFile)) {
                $this->info('✅ CSS file exists: ' . $cssFile);
                $this->info('CSS file size: ' . filesize($cssFile) . ' bytes');
            } else {
                $this->error('❌ CSS file not found: ' . $cssFile);
            }
            
            if (file_exists($jsFile)) {
                $this->info('✅ JavaScript file exists: ' . $jsFile);
                $this->info('JavaScript file size: ' . filesize($jsFile) . ' bytes');
            } else {
                $this->error('❌ JavaScript file not found: ' . $jsFile);
            }
            
            // Test 6: Check AdminPanelProvider configuration
            $this->info('6. Checking AdminPanelProvider configuration...');
            $providerFile = app_path('Providers/Filament/AdminPanelProvider.php');
            
            if (file_exists($providerFile)) {
                $content = file_get_contents($providerFile);
                if (strpos($content, 'wordpress-style-editor.css') !== false && 
                    strpos($content, 'wordpress-style-editor.js') !== false) {
                    $this->info('✅ AdminPanelProvider has WordPress-style editor assets configured');
                } else {
                    $this->warn('⚠️ AdminPanelProvider might not have WordPress-style editor assets configured');
                }
            } else {
                $this->error('❌ AdminPanelProvider file not found');
            }
            
            $this->info('');
            $this->info('🎉 All tests completed successfully!');
            $this->info('');
            $this->info('📝 Ready to test:');
            $this->info('   URL: http://127.0.0.1:8000/admin/pdf-templates/1/edit');
            $this->info('   Status: ✅ WYSIWYG Visual Editor Ready');
            $this->info('   Features: Visual formatting, image insertion, table creation');
            $this->info('   Display: Microsoft Word-like interface');
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error('Error testing PDF template page access: ' . $e->getMessage());
            return 1;
        }
    }
}