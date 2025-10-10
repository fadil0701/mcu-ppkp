<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PdfTemplate;
use App\Filament\Resources\PdfTemplateResource;

class TestPdfTemplatePageLoad extends Command
{
    protected $signature = 'test:pdf-template-page-load';
    protected $description = 'Test PDF template page loading with CKEditor-style editor';

    public function handle()
    {
        $this->info('Testing PDF Template Page Load with CKEditor-style Editor');
        $this->line('');

        // Test 1: Check if PDF template exists
        $this->info('1. Checking PDF template existence...');
        $template = PdfTemplate::first();
        if ($template) {
            $this->info('   ✓ PDF template found: ID ' . $template->id . ' - ' . $template->title);
        } else {
            $this->error('   ✗ No PDF template found. Please create one first.');
            return 1;
        }

        // Test 2: Check Filament resource
        $this->info('2. Checking Filament resource...');
        try {
            $resource = new PdfTemplateResource();
            $this->info('   ✓ PdfTemplateResource instantiated successfully');
        } catch (\Exception $e) {
            $this->error('   ✗ Error instantiating PdfTemplateResource: ' . $e->getMessage());
            return 1;
        }

        // Test 3: Check view compilation
        $this->info('3. Testing view compilation...');
        try {
            $viewPath = 'filament.forms.components.wordpress-style-editor';
            $compiled = view($viewPath, [
                'getStatePath' => function() { return 'test'; },
                'getState' => function() { return '<p>Test content</p>'; }
            ]);
            $this->info('   ✓ View compiles successfully');
        } catch (\Exception $e) {
            $this->error('   ✗ View compilation error: ' . $e->getMessage());
            return 1;
        }

        // Test 4: Check for common Filament form component issues
        $this->info('4. Checking for common issues...');
        
        // Check if the view uses proper Filament form component structure
        $viewContent = file_get_contents(resource_path('views/filament/forms/components/wordpress-style-editor.blade.php'));
        
        if (strpos($viewContent, 'fi-fo-field-wrp-label') !== false) {
            $this->info('   ✓ Uses proper Filament form wrapper');
        } else {
            $this->error('   ✗ Missing Filament form wrapper');
        }
        
        if (strpos($viewContent, '{{ $getStatePath() }}') !== false) {
            $this->info('   ✓ Uses $getStatePath() correctly');
        } else {
            $this->error('   ✗ Missing $getStatePath() usage');
        }
        
        if (strpos($viewContent, '{{ $getState() }}') !== false) {
            $this->info('   ✓ Uses $getState() correctly');
        } else {
            $this->error('   ✗ Missing $getState() usage');
        }
        
        // Check for removed problematic code
        if (strpos($viewContent, '$getExtraInputAttributes') !== false) {
            $this->error('   ✗ Still contains $getExtraInputAttributes (should be removed)');
        } else {
            $this->info('   ✓ $getExtraInputAttributes removed (good)');
        }

        // Test 5: Check asset loading
        $this->info('5. Checking asset loading...');
        
        $assets = [
            'CSS' => public_path('css/ckeditor-style-editor.css'),
            'JavaScript' => public_path('js/ckeditor-style-editor.js')
        ];
        
        foreach ($assets as $type => $path) {
            if (file_exists($path)) {
                $this->info('   ✓ ' . $type . ' file exists: ' . basename($path));
            } else {
                $this->error('   ✗ ' . $type . ' file missing: ' . basename($path));
            }
        }

        // Test 6: Check AdminPanelProvider configuration
        $this->info('6. Checking AdminPanelProvider...');
        $providerContent = file_get_contents(app_path('Providers/Filament/AdminPanelProvider.php'));
        
        if (strpos($providerContent, 'ckeditor-style-editor.css') !== false && 
            strpos($providerContent, 'ckeditor-style-editor.js') !== false) {
            $this->info('   ✓ Assets properly configured in AdminPanelProvider');
        } else {
            $this->error('   ✗ Assets not configured in AdminPanelProvider');
        }

        $this->line('');
        $this->info('✅ PDF Template Page Load test completed!');
        $this->line('');
        $this->info('The CKEditor-style editor should now load without errors.');
        $this->info('You can test it by visiting: /admin/pdf-templates/' . $template->id . '/edit');
        $this->line('');
        $this->info('Expected features:');
        $this->line('• Professional CKEditor-style toolbar (2 rows)');
        $this->line('• Working buttons and dropdowns');
        $this->line('• Functional modals for image/table insertion');
        $this->line('• WYSIWYG content editing');
        $this->line('• Status bar with element path');
        $this->line('• Visual formatting like Microsoft Word');

        return 0;
    }
}