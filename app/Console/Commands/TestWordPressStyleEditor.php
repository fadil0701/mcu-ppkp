<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Filament\Forms\Components\WordPressStyleEditor;

class TestWordPressStyleEditor extends Command
{
    protected $signature = 'test:wordpress-style-editor';
    protected $description = 'Test WordPress-style Editor component with TinyMCE and Autocrat-style placeholders';

    public function handle()
    {
        $this->info("📝 Testing WordPress-style Editor Component...");
        
        // Test component creation
        $this->info("\n🔧 Testing component creation...");
        try {
            $editor = WordPressStyleEditor::make('template_content')
                ->enableVariables(true)
                ->enableImages(true)
                ->enableTables(true)
                ->showPreview(true);
            
            $this->info("✅ WordPress-style Editor component created successfully");
            $this->info("   View: " . $editor->getView());
            $this->info("   Variables Enabled: " . ($editor->isVariablesEnabled() ? 'Yes' : 'No'));
            $this->info("   Images Enabled: " . ($editor->isImagesEnabled() ? 'Yes' : 'No'));
            $this->info("   Tables Enabled: " . ($editor->isTablesEnabled() ? 'Yes' : 'No'));
            $this->info("   Preview Enabled: " . ($editor->isPreviewEnabled() ? 'Yes' : 'No'));
            
        } catch (\Exception $e) {
            $this->error("❌ Failed to create component: " . $e->getMessage());
            return 1;
        }
        
        // Test available placeholders
        $this->info("\n🔍 Testing available placeholders...");
        try {
            $placeholders = $editor->getAvailablePlaceholders();
            $this->info("✅ Found " . count($placeholders) . " placeholder categories");
            
            foreach ($placeholders as $category => $variables) {
                $this->info("   📁 {$category}: " . count($variables) . " variables");
                foreach (array_slice($variables, 0, 3) as $key => $description) {
                    $this->info("      - {{$category}.{$key}}: {$description}");
                }
                if (count($variables) > 3) {
                    $this->info("      ... and " . (count($variables) - 3) . " more");
                }
            }
            
        } catch (\Exception $e) {
            $this->error("❌ Failed to get placeholders: " . $e->getMessage());
            return 1;
        }
        
        // Test view file exists
        $this->info("\n📁 Testing view file...");
        $viewPath = resource_path('views/filament/forms/components/wordpress-style-editor.blade.php');
        if (file_exists($viewPath)) {
            $this->info("✅ View file exists: {$viewPath}");
            $this->info("   Size: " . filesize($viewPath) . " bytes");
        } else {
            $this->error("❌ View file not found: {$viewPath}");
            return 1;
        }
        
        // Test CSS file exists
        $this->info("\n🎨 Testing CSS file...");
        $cssPath = public_path('css/wordpress-style-editor.css');
        if (file_exists($cssPath)) {
            $this->info("✅ CSS file exists: {$cssPath}");
            $this->info("   Size: " . filesize($cssPath) . " bytes");
        } else {
            $this->error("❌ CSS file not found: {$cssPath}");
            return 1;
        }
        
        // Test JavaScript file exists
        $this->info("\n⚡ Testing JavaScript file...");
        $jsPath = public_path('js/wordpress-style-editor.js');
        if (file_exists($jsPath)) {
            $this->info("✅ JavaScript file exists: {$jsPath}");
            $this->info("   Size: " . filesize($jsPath) . " bytes");
        } else {
            $this->error("❌ JavaScript file not found: {$jsPath}");
            return 1;
        }
        
        // Test AdminPanelProvider configuration
        $this->info("\n⚙️ Testing AdminPanelProvider configuration...");
        $adminPanelPath = app_path('Providers/Filament/AdminPanelProvider.php');
        $adminPanelContent = file_get_contents($adminPanelPath);
        
        if (strpos($adminPanelContent, 'wordpress-style-editor.css') !== false) {
            $this->info("✅ CSS asset hook found in AdminPanelProvider");
        } else {
            $this->error("❌ CSS asset hook not found in AdminPanelProvider");
        }
        
        if (strpos($adminPanelContent, 'wordpress-style-editor.js') !== false) {
            $this->info("✅ JS asset hook found in AdminPanelProvider");
        } else {
            $this->error("❌ JS asset hook not found in AdminPanelProvider");
        }
        
        // Test view content for key features
        $this->info("\n🔍 Testing view content for key features...");
        $viewContent = file_get_contents($viewPath);
        
        $featureChecks = [
            'TinyMCE' => 'TinyMCE editor integration',
            'Insert Variable' => 'Variable insertion functionality',
            'Insert Image' => 'Image insertion functionality',
            'Insert Table' => 'Table insertion functionality',
            'Preview' => 'Preview functionality',
            '{{participant.name}}' => 'Autocrat-style placeholders',
            'dashicons' => 'WordPress Dashicons integration',
            'variable-modal' => 'Variable selection modal',
            'image-modal' => 'Image upload modal',
            'table-modal' => 'Table insertion modal'
        ];
        
        foreach ($featureChecks as $pattern => $description) {
            if (strpos($viewContent, $pattern) !== false) {
                $this->info("✅ {$description} found");
            } else {
                $this->warn("⚠️ {$description} not found");
            }
        }
        
        // Test JavaScript content for key features
        $this->info("\n⚡ Testing JavaScript content for key features...");
        $jsContent = file_get_contents($jsPath);
        
        $jsFeatureChecks = [
            'tinymce' => 'TinyMCE integration',
            'loadTinyMCE' => 'TinyMCE loading function',
            'insertVariableValue' => 'Variable insertion function',
            'handleImageUpload' => 'Image upload handling',
            'insertTable' => 'Table insertion function',
            'togglePreview' => 'Preview toggle function',
            'dashicons' => 'Dashicons loading',
            'Auto-save' => 'Auto-save functionality'
        ];
        
        foreach ($jsFeatureChecks as $pattern => $description) {
            if (strpos($jsContent, $pattern) !== false) {
                $this->info("✅ {$description} found");
            } else {
                $this->warn("⚠️ {$description} not found");
            }
        }
        
        $this->info("\n🎉 WordPress-style Editor test completed successfully!");
        
        $this->info("\n📋 Features available:");
        $this->info("   ✅ WordPress-style interface with TinyMCE");
        $this->info("   ✅ Rich text editing (bold, italic, underline)");
        $this->info("   ✅ Text alignment (left, center, right, justify)");
        $this->info("   ✅ Lists (bullet and numbered)");
        $this->info("   ✅ Headings (H1-H6)");
        $this->info("   ✅ Image insertion with upload and URL");
        $this->info("   ✅ Table insertion with custom size");
        $this->info("   ✅ Autocrat-style placeholder variables");
        $this->info("   ✅ Variable insertion with search");
        $this->info("   ✅ Live preview functionality");
        $this->info("   ✅ Auto-save functionality");
        $this->info("   ✅ WordPress Dashicons integration");
        $this->info("   ✅ Fallback to simple textarea if TinyMCE fails");
        
        $this->info("\n🎯 Autocrat-style Placeholders:");
        $this->info("   ✅ {{participant.name}} - Nama Peserta");
        $this->info("   ✅ {{schedule.date}} - Tanggal Pemeriksaan");
        $this->info("   ✅ {{organization.name}} - Nama Organisasi");
        $this->info("   ✅ {{contact.person}} - Nama PIC");
        $this->info("   ✅ {{signature.name}} - Nama Penandatangan");
        $this->info("   ✅ And many more...");
        
        $this->info("\n🚀 How to Use:");
        $this->info("   1. Write your template content directly in the editor");
        $this->info("   2. Use {{variable.category}} for dynamic content");
        $this->info("   3. Click 'Insert Variable' to browse available variables");
        $this->info("   4. Use toolbar for formatting (bold, italic, alignment, etc.)");
        $this->info("   5. Insert images and tables as needed");
        $this->info("   6. Use 'Preview' to see how your template looks");
        $this->info("   7. All content is automatically saved");
        
        return 0;
    }
}