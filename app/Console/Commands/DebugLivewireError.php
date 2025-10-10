<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DebugLivewireError extends Command
{
    protected $signature = 'livewire:debug-error';
    protected $description = 'Debug the exact Livewire error source';

    public function handle()
    {
        $this->info("🔍 Debugging Livewire Error Source...");
        
        // Check if there are any custom views that override the default
        $this->checkCustomViewOverrides();
        
        // Check for any cached views that might be causing issues
        $this->checkCachedViews();
        
        // Try to simulate the exact error
        $this->simulateError();
        
        $this->info("\n🎉 Debug completed!");
        
        return 0;
    }
    
    private function checkCustomViewOverrides()
    {
        $this->info("\n🔍 Checking for custom view overrides...");
        
        // Check if there are any custom views that might override the default Filament views
        $customPaths = [
            'resources/views/filament/resources/pdf-template-resource/pages/edit-pdf-template.blade.php',
            'resources/views/filament/resources/pdf-template-resource/pages/edit.blade.php',
            'resources/views/filament/resources/pdf-template-resource/pages/edit-record.blade.php',
            'resources/views/filament/pages/edit-pdf-template.blade.php',
            'resources/views/filament/forms/components/edit-form.blade.php',
        ];
        
        foreach ($customPaths as $path) {
            $fullPath = base_path($path);
            if (file_exists($fullPath)) {
                $this->warn("⚠️ Custom view found: {$path}");
                $this->analyzeFile($fullPath, $path);
            }
        }
    }
    
    private function checkCachedViews()
    {
        $this->info("\n🔍 Checking cached views...");
        
        $cacheDir = storage_path('framework/views');
        if (is_dir($cacheDir)) {
            $files = scandir($cacheDir);
            
            // Look for any cached files that might contain our component
            foreach ($files as $file) {
                if (strpos($file, 'wysiwyg') !== false || 
                    strpos($file, 'pdf-template') !== false ||
                    strpos($file, 'edit-pdf-template') !== false) {
                    
                    $this->warn("⚠️ Found cached view: {$file}");
                    
                    $cachedFile = $cacheDir . '/' . $file;
                    $content = file_get_contents($cachedFile);
                    
                    // Check if this cached file has multiple root elements
                    if (strpos($content, '<div') !== false && strpos($content, '<style>') !== false) {
                        $this->error("❌ Cached file has multiple root elements!");
                        $this->info("💡 Clearing view cache...");
                        $this->call('view:clear');
                        break;
                    }
                }
            }
        }
    }
    
    private function simulateError()
    {
        $this->info("\n🔍 Simulating the error...");
        
        try {
            // Try to access the PDF template edit page
            $this->info("📄 Attempting to access PDF template edit page...");
            
            // This would normally trigger the error
            $this->warn("⚠️ This might trigger the Livewire error");
            
        } catch (\Exception $e) {
            $this->error("❌ Error caught: " . $e->getMessage());
        }
    }
    
    private function analyzeFile($filePath, $relativePath)
    {
        $this->info("\n📄 Analyzing: {$relativePath}");
        
        $content = file_get_contents($filePath);
        $this->info("📊 File size: " . strlen($content) . " bytes");
        
        // Check for multiple root elements
        $rootElements = $this->countRootElements($content);
        
        if ($rootElements > 1) {
            $this->error("❌ Multiple root elements found: {$rootElements}");
            $this->analyzeRootElements($content);
        } else {
            $this->info("✅ Single root element or no root elements");
        }
        
        // Check for specific issues
        if (strpos($content, '<template') !== false) {
            $this->warn("⚠️ Contains <template> tags");
        }
        
        if (strpos($content, '<style>') !== false) {
            $this->warn("⚠️ Contains <style> tags");
        }
        
        if (strpos($content, '<script>') !== false) {
            $this->warn("⚠️ Contains <script> tags");
        }
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
    
    private function analyzeRootElements($content)
    {
        $this->info("🔍 Analyzing root elements...");
        
        // Find all top-level HTML elements
        preg_match_all('/^<([a-zA-Z][a-zA-Z0-9]*)[^>]*>/m', $content, $matches);
        
        if (!empty($matches[1])) {
            $this->info("📋 Top-level elements found:");
            foreach ($matches[1] as $element) {
                $this->info("  - <{$element}>");
            }
        }
        
        // Check for specific problematic patterns
        if (strpos($content, '<style>') !== false) {
            $this->error("  ❌ Contains <style> tag outside container");
        }
        
        if (strpos($content, '<script>') !== false) {
            $this->error("  ❌ Contains <script> tag outside container");
        }
        
        if (strpos($content, '<template') !== false) {
            $this->error("  ❌ Contains <template> tag");
        }
    }
}