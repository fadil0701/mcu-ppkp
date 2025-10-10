<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PdfTemplate;

class TestLivewireFix extends Command
{
    protected $signature = 'livewire:test-fix';
    protected $description = 'Test if Livewire multiple root elements error is fixed';

    public function handle()
    {
        $this->info("🧪 Testing Livewire Fix...");
        
        // Test database access
        $template = PdfTemplate::find(1);
        if (!$template) {
            $this->error("❌ PDF template not found!");
            return 1;
        }
        
        $this->info("✅ PDF template found: {$template->name}");
        
        // Test WYSIWYG editor component
        try {
            $component = new \App\Filament\Forms\Components\WysiwygEditor('test_field');
            $this->info("✅ WysiwygEditor component created successfully");
            
        } catch (\Exception $e) {
            $this->error("❌ WysiwygEditor error: " . $e->getMessage());
            return 1;
        }
        
        // Test view file
        $viewPath = resource_path('views/filament/forms/components/wysiwyg-editor.blade.php');
        if (!file_exists($viewPath)) {
            $this->error("❌ WYSIWYG editor view not found");
            return 1;
        }
        
        $this->info("✅ WYSIWYG editor view exists");
        
        // Check file content
        $content = file_get_contents($viewPath);
        
        // Check for template tags
        if (strpos($content, '<template') !== false) {
            $this->error("❌ Still contains <template> tags");
            return 1;
        }
        
        $this->info("✅ No <template> tags found");
        
        // Check for single root element
        $rootElements = $this->countRootElements($content);
        
        if ($rootElements === 1) {
            $this->info("✅ Single root element confirmed");
        } else {
            $this->error("❌ Multiple root elements detected: {$rootElements}");
            return 1;
        }
        
        // Check for proper structure
        if (strpos($content, '<x-dynamic-component') !== false) {
            $this->info("✅ Dynamic component wrapper found");
        } else {
            $this->error("❌ Dynamic component wrapper not found");
            return 1;
        }
        
        if (strpos($content, 'x-data=') !== false) {
            $this->info("✅ Alpine.js x-data found");
        } else {
            $this->error("❌ Alpine.js x-data not found");
            return 1;
        }
        
        $this->info("\n🎉 Livewire fix test completed successfully!");
        $this->info("✅ All checks passed - Error should be resolved!");
        
        return 0;
    }
    
    private function countRootElements($content)
    {
        try {
            // Remove Blade directives and PHP code for HTML analysis
            $htmlContent = $content;
            $htmlContent = preg_replace('/\{\{.*?\}\}/s', '', $htmlContent);
            $htmlContent = preg_replace('/\{!!.*?!!\}/s', '', $htmlContent);
            $htmlContent = preg_replace('/@[a-zA-Z]+(\([^)]*\))?/', '', $htmlContent);
            $htmlContent = preg_replace('/<\?php.*?\?>/s', '', $htmlContent);
            $htmlContent = preg_replace('/<\?=.*?\?>/s', '', $htmlContent);
            $htmlContent = preg_replace('/<!--.*?-->/s', '', $htmlContent);
            
            // Parse HTML
            $dom = new \DOMDocument();
            $dom->preserveWhiteSpace = false;
            libxml_use_internal_errors(true);
            
            $loaded = $dom->loadHTML('<!DOCTYPE html><html><body>' . $htmlContent . '</body></html>');
            
            if ($loaded) {
                $body = $dom->getElementsByTagName('body')->item(0);
                if ($body) {
                    $elementCount = 0;
                    foreach ($body->childNodes as $child) {
                        if ($child->nodeType === XML_ELEMENT_NODE) {
                            $elementCount++;
                        }
                    }
                    libxml_clear_errors();
                    return $elementCount;
                }
            }
            
            libxml_clear_errors();
            return 0;
            
        } catch (\Exception $e) {
            return 0;
        }
    }
}