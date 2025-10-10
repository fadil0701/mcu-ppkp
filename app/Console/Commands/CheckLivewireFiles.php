<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DOMDocument;

class CheckLivewireFiles extends Command
{
    protected $signature = 'livewire:check-files';
    protected $description = 'Check all Livewire-related files for multiple root elements';

    public function handle()
    {
        $this->info("🔍 Checking All Livewire Files...");
        
        // Check the main WYSIWYG editor file
        $wysiwygPath = resource_path('views/filament/forms/components/wysiwyg-editor.blade.php');
        $this->checkFile($wysiwygPath, 'WYSIWYG Editor');
        
        // Check PDF template variables file
        $pdfVarsPath = resource_path('views/filament/forms/components/pdf-template-variables.blade.php');
        $this->checkFile($pdfVarsPath, 'PDF Template Variables');
        
        // Check email template variables file
        $emailVarsPath = resource_path('views/filament/forms/components/template-variables.blade.php');
        $this->checkFile($emailVarsPath, 'Email Template Variables');
        
        // Check if there are any other custom components
        $componentsDir = resource_path('views/filament/forms/components/');
        if (is_dir($componentsDir)) {
            $files = scandir($componentsDir);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..' && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                    $filePath = $componentsDir . $file;
                    $this->checkFile($filePath, 'Component: ' . pathinfo($file, PATHINFO_FILENAME));
                }
            }
        }
        
        $this->info("\n🎉 Livewire files check completed!");
        
        return 0;
    }
    
    private function checkFile($filePath, $description)
    {
        if (!file_exists($filePath)) {
            $this->warn("⚠️ {$description}: File not found - {$filePath}");
            return;
        }
        
        $content = file_get_contents($filePath);
        $this->info("\n📄 Checking: {$description}");
        $this->info("📊 File size: " . strlen($content) . " bytes");
        
        // Count root elements
        $rootElements = $this->countRootElements($content);
        
        if ($rootElements === 1) {
            $this->info("✅ Root elements: {$rootElements} - Livewire compatible");
        } elseif ($rootElements > 1) {
            $this->error("❌ Root elements: {$rootElements} - Livewire incompatible");
        } else {
            $this->warn("⚠️ Root elements: {$rootElements} - Unknown");
        }
        
        // Check for specific issues
        if (strpos($content, '<style>') !== false) {
            $this->warn("⚠️ Contains <style> tags");
        }
        
        if (strpos($content, '<script>') !== false) {
            $this->warn("⚠️ Contains <script> tags");
        }
        
        if (strpos($content, '<template') !== false) {
            $this->warn("⚠️ Contains <template> tags");
        }
        
        if (strpos($content, 'x-data=') !== false) {
            $this->info("✅ Contains Alpine.js x-data");
        }
        
        if (strpos($content, 'wire:') !== false) {
            $this->info("✅ Contains Livewire directives");
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
            return -1; // Unknown
            
        } catch (\Exception $e) {
            return -1; // Unknown
        }
    }
}