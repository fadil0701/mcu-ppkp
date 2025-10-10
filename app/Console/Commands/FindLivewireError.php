<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DOMDocument;

class FindLivewireError extends Command
{
    protected $signature = 'livewire:find-error';
    protected $description = 'Find the exact source of Livewire multiple root elements error';

    public function handle()
    {
        $this->info("🔍 Finding Livewire Multiple Root Elements Error...");
        
        // Check all possible files that could cause the error
        $filesToCheck = [
            'resources/views/filament/forms/components/wysiwyg-editor.blade.php',
            'resources/views/filament/forms/components/pdf-template-variables.blade.php',
            'resources/views/filament/forms/components/template-variables.blade.php',
            'app/Filament/Resources/PdfTemplateResource.php',
            'app/Filament/Resources/PdfTemplateResource/Pages/EditPdfTemplate.php',
        ];
        
        foreach ($filesToCheck as $file) {
            $this->checkFile($file);
        }
        
        // Check if there are any custom views for PDF template editing
        $this->checkCustomViews();
        
        // Check for any cached views that might be causing issues
        $this->checkCachedViews();
        
        $this->info("\n🎉 Livewire error analysis completed!");
        
        return 0;
    }
    
    private function checkFile($filePath)
    {
        $fullPath = base_path($filePath);
        
        if (!file_exists($fullPath)) {
            $this->warn("⚠️ File not found: {$filePath}");
            return;
        }
        
        $this->info("\n📄 Checking: {$filePath}");
        
        $content = file_get_contents($fullPath);
        $this->info("📊 File size: " . strlen($content) . " bytes");
        
        // Check for multiple root elements
        $rootElements = $this->countRootElements($content);
        
        if ($rootElements === 1) {
            $this->info("✅ Root elements: {$rootElements} - OK");
        } elseif ($rootElements > 1) {
            $this->error("❌ Root elements: {$rootElements} - PROBLEM FOUND!");
            $this->analyzeRootElements($content);
        } else {
            $this->warn("⚠️ Root elements: {$rootElements} - Unknown");
        }
        
        // Check for specific issues
        $issues = $this->identifyIssues($content);
        foreach ($issues as $issue) {
            $this->warn("⚠️ {$issue}");
        }
    }
    
    private function checkCustomViews()
    {
        $this->info("\n🔍 Checking for custom views...");
        
        // Check if there are any custom views for PDF template editing
        $customViews = [
            'resources/views/filament/resources/pdf-template-resource/pages/edit-pdf-template.blade.php',
            'resources/views/filament/pages/edit-pdf-template.blade.php',
            'resources/views/filament/resources/pdf-template-resource/forms/components/edit-form.blade.php',
        ];
        
        foreach ($customViews as $view) {
            $fullPath = base_path($view);
            if (file_exists($fullPath)) {
                $this->warn("⚠️ Custom view found: {$view}");
                $this->checkFile($view);
            }
        }
    }
    
    private function checkCachedViews()
    {
        $this->info("\n🔍 Checking cached views...");
        
        $cacheDir = storage_path('framework/views');
        if (is_dir($cacheDir)) {
            $files = scandir($cacheDir);
            $wysiwygFiles = array_filter($files, function($file) {
                return strpos($file, 'wysiwyg') !== false || strpos($file, 'pdf-template') !== false;
            });
            
            if (!empty($wysiwygFiles)) {
                $this->warn("⚠️ Found cached views that might be causing issues:");
                foreach ($wysiwygFiles as $file) {
                    $this->warn("  - {$file}");
                }
                
                $this->info("💡 Try running: php artisan view:clear");
            }
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
            $dom = new DOMDocument();
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
    
    private function identifyIssues($content)
    {
        $issues = [];
        
        if (strpos($content, '<style>') !== false && strpos($content, '<div') === false) {
            $issues[] = 'Contains <style> tags outside div container';
        }
        
        if (strpos($content, '<script>') !== false && strpos($content, '<div') === false) {
            $issues[] = 'Contains <script> tags outside div container';
        }
        
        if (preg_match('/<template[^>]*>.*?<\/template>/s', $content)) {
            $issues[] = 'Contains <template> tags';
        }
        
        if (preg_match('/<x-dynamic-component[^>]*>.*?<\/x-dynamic-component>/s', $content)) {
            // Check if content inside dynamic component has multiple root elements
            preg_match('/<x-dynamic-component[^>]*>(.*?)<\/x-dynamic-component>/s', $content, $matches);
            if (isset($matches[1])) {
                $innerContent = $matches[1];
                $innerRootElements = $this->countRootElements($innerContent);
                if ($innerRootElements > 1) {
                    $issues[] = "Dynamic component has {$innerRootElements} root elements";
                }
            }
        }
        
        return $issues;
    }
}