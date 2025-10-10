<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DOMDocument;
use DOMXPath;

class DebugLivewireComponent extends Command
{
    protected $signature = 'livewire:debug-component';
    protected $description = 'Debug Livewire component structure in detail';

    public function handle()
    {
        $this->info("🔍 Debugging Livewire Component Structure...");
        
        $viewPath = resource_path('views/filament/forms/components/wysiwyg-editor.blade.php');
        
        if (!file_exists($viewPath)) {
            $this->error("View file not found: {$viewPath}");
            return 1;
        }
        
        $content = file_get_contents($viewPath);
        $this->info("✅ View file found: {$viewPath}");
        $this->info("📊 File size: " . strlen($content) . " bytes");
        
        // Count lines
        $lines = explode("\n", $content);
        $this->info("📊 Total lines: " . count($lines));
        
        // Check for multiple root elements
        $this->info("\n🔍 Analyzing HTML Structure...");
        
        // Remove Blade directives and PHP code for HTML analysis
        $htmlContent = $content;
        
        // Remove Blade directives
        $htmlContent = preg_replace('/\{\{.*?\}\}/s', '', $htmlContent);
        $htmlContent = preg_replace('/\{!!.*?!!\}/s', '', $htmlContent);
        $htmlContent = preg_replace('/@[a-zA-Z]+(\([^)]*\))?/', '', $htmlContent);
        $htmlContent = preg_replace('/<x-[^>]*>/', '', $htmlContent);
        
        // Remove PHP tags
        $htmlContent = preg_replace('/<\?php.*?\?>/s', '', $htmlContent);
        $htmlContent = preg_replace('/<\?=.*?\?>/s', '', $htmlContent);
        
        // Remove comments
        $htmlContent = preg_replace('/<!--.*?-->/s', '', $htmlContent);
        
        // Remove script and style content for now
        $htmlContent = preg_replace('/<script[^>]*>.*?<\/script>/s', '', $htmlContent);
        $htmlContent = preg_replace('/<style[^>]*>.*?<\/style>/s', '', $htmlContent);
        
        // Clean up whitespace
        $htmlContent = preg_replace('/\s+/', ' ', $htmlContent);
        $htmlContent = trim($htmlContent);
        
        $this->info("📊 Cleaned HTML length: " . strlen($htmlContent) . " characters");
        
        // Try to parse as HTML
        $dom = new DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        
        // Suppress errors
        libxml_use_internal_errors(true);
        
        $loaded = $dom->loadHTML('<!DOCTYPE html><html><body>' . $htmlContent . '</body></html>');
        
        if (!$loaded) {
            $this->error("❌ Failed to parse HTML");
            $errors = libxml_get_errors();
            foreach ($errors as $error) {
                $this->error("  - " . trim($error->message));
            }
            libxml_clear_errors();
        } else {
            $this->info("✅ HTML parsed successfully");
            
            // Get body content
            $body = $dom->getElementsByTagName('body')->item(0);
            if ($body) {
                $children = $body->childNodes;
                $elementCount = 0;
                $textCount = 0;
                
                foreach ($children as $child) {
                    if ($child->nodeType === XML_ELEMENT_NODE) {
                        $elementCount++;
                        $this->info("  - Element: <{$child->nodeName}>");
                    } elseif ($child->nodeType === XML_TEXT_NODE && trim($child->textContent)) {
                        $textCount++;
                        $this->info("  - Text: \"" . substr(trim($child->textContent), 0, 50) . "...\"");
                    }
                }
                
                $this->info("📊 Root elements found: {$elementCount}");
                $this->info("📊 Text nodes found: {$textCount}");
                
                if ($elementCount === 1) {
                    $this->info("✅ Single root element detected - Livewire compatible");
                } else {
                    $this->error("❌ Multiple root elements detected - Livewire incompatible");
                }
            }
        }
        
        // Check for specific issues
        $this->info("\n🔍 Checking for Common Issues:");
        
        // Check for script tags
        $scriptCount = preg_match_all('/<script[^>]*>.*?<\/script>/s', $content);
        $this->info("📊 Script tags found: {$scriptCount}");
        
        // Check for style tags
        $styleCount = preg_match_all('/<style[^>]*>.*?<\/style>/s', $content);
        $this->info("📊 Style tags found: {$styleCount}");
        
        // Check for Alpine.js
        $alpineCount = preg_match_all('/x-data|@click|@input|@change/', $content);
        $this->info("📊 Alpine.js directives found: {$alpineCount}");
        
        // Check for Livewire directives
        $livewireCount = preg_match_all('/wire:|@livewire/', $content);
        $this->info("📊 Livewire directives found: {$livewireCount}");
        
        // Check for template tags
        $templateCount = preg_match_all('/<template[^>]*>/', $content);
        $this->info("📊 Template tags found: {$templateCount}");
        
        // Check for conditional rendering
        $conditionalCount = preg_match_all('/x-if|x-show|x-for/', $content);
        $this->info("📊 Conditional rendering found: {$conditionalCount}");
        
        // Check for dynamic components
        $dynamicCount = preg_match_all('/<x-dynamic-component/', $content);
        $this->info("📊 Dynamic components found: {$dynamicCount}");
        
        // Recommendations
        $this->info("\n💡 Recommendations:");
        
        if ($elementCount > 1) {
            $this->warn("⚠️ Wrap all content in a single root element");
        }
        
        if ($scriptCount > 0) {
            $this->warn("⚠️ Move script tags inside the root element");
        }
        
        if ($styleCount > 0) {
            $this->warn("⚠️ Move style tags inside the root element");
        }
        
        if ($templateCount > 0) {
            $this->warn("⚠️ Ensure template tags are properly nested");
        }
        
        // Show first few lines for context
        $this->info("\n📄 First 10 lines of file:");
        for ($i = 0; $i < min(10, count($lines)); $i++) {
            $lineNum = $i + 1;
            $this->info("  {$lineNum}: " . trim($lines[$i]));
        }
        
        $this->info("\n🎉 Livewire component debug completed!");
        
        return 0;
    }
}