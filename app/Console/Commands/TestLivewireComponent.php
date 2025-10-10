<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PdfTemplate;

class TestLivewireComponent extends Command
{
    protected $signature = 'livewire:test-component';
    protected $description = 'Test Livewire component structure';

    public function handle()
    {
        $this->info("🧪 Testing Livewire Component Structure...");
        
        // Check if template exists
        $template = PdfTemplate::find(1);
        if (!$template) {
            $this->error("Template not found! Please run PDF template seeder first.");
            return 1;
        }
        
        $this->info("✅ Template found: {$template->name}");
        
        // Check view file
        $viewPath = resource_path('views/filament/forms/components/wysiwyg-editor.blade.php');
        if (!file_exists($viewPath)) {
            $this->error("❌ WYSIWYG editor view not found: {$viewPath}");
            return 1;
        }
        
        $this->info("✅ WYSIWYG editor view exists");
        
        // Check view content for multiple root elements
        $viewContent = file_get_contents($viewPath);
        
        // Count root elements using DOM parsing
        $rootElements = 0;
        
        try {
            // Extract content between <x-dynamic-component> tags
            preg_match('/<x-dynamic-component[^>]*>(.*?)<\/x-dynamic-component>/s', $viewContent, $matches);
            
            if (isset($matches[1])) {
                $componentContent = $matches[1];
                
                // Remove Blade directives and PHP code for HTML analysis
                $htmlContent = $componentContent;
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
                        foreach ($body->childNodes as $child) {
                            if ($child->nodeType === XML_ELEMENT_NODE) {
                                $rootElements++;
                            }
                        }
                    }
                }
                libxml_clear_errors();
            }
        } catch (\Exception $e) {
            $this->warn("⚠️ Could not parse HTML: " . $e->getMessage());
            $rootElements = -1; // Unknown
        }
        
        $this->info("📊 Root elements found: {$rootElements}");
        
        if ($rootElements <= 1) {
            $this->info("✅ Single root element detected - Livewire compatible");
        } else {
            $this->error("❌ Multiple root elements detected - Livewire incompatible");
            $this->error("Livewire requires exactly one root element per component");
        }
        
        // Check for common Livewire issues
        $this->info("\n🔍 Checking for common Livewire issues:");
        
        // Check for script tags outside component
        if (strpos($viewContent, '<script>') !== false) {
            $this->warn("⚠️ Script tags found - ensure they're inside the component");
        }
        
        // Check for style tags outside component
        if (strpos($viewContent, '<style>') !== false) {
            $this->warn("⚠️ Style tags found - ensure they're inside the component");
        }
        
        // Check for proper Alpine.js usage
        if (strpos($viewContent, 'x-data=') !== false) {
            $this->info("✅ Alpine.js x-data found");
        } else {
            $this->error("❌ Alpine.js x-data not found");
        }
        
        // Check for proper Livewire wire:model
        if (strpos($viewContent, 'wire:') !== false) {
            $this->info("✅ Livewire directives found");
        } else {
            $this->warn("⚠️ No Livewire directives found");
        }
        
        $this->info("\n🎉 Livewire component test completed!");
        
        return 0;
    }
}