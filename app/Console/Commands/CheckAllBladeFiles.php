<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DOMDocument;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class CheckAllBladeFiles extends Command
{
    protected $signature = 'blade:check-all {--path=resources/views}';
    protected $description = 'Check all Blade files for multiple root elements';

    public function handle()
    {
        $path = $this->option('path');
        $this->info("🔍 Checking All Blade Files in: {$path}");
        
        $files = $this->getBladeFiles($path);
        $this->info("📊 Found " . count($files) . " Blade files");
        
        $problematicFiles = [];
        
        foreach ($files as $file) {
            $relativePath = str_replace(base_path() . '/', '', $file);
            $result = $this->checkBladeFile($file, $relativePath);
            
            if ($result['rootElements'] > 1) {
                $problematicFiles[] = [
                    'file' => $relativePath,
                    'rootElements' => $result['rootElements'],
                    'issues' => $result['issues']
                ];
            }
        }
        
        if (empty($problematicFiles)) {
            $this->info("\n✅ All Blade files are Livewire compatible!");
        } else {
            $this->error("\n❌ Found " . count($problematicFiles) . " problematic files:");
            
            foreach ($problematicFiles as $file) {
                $this->error("  - {$file['file']} ({$file['rootElements']} root elements)");
                foreach ($file['issues'] as $issue) {
                    $this->warn("    ⚠️ {$issue}");
                }
            }
        }
        
        $this->info("\n🎉 Blade files check completed!");
        
        return 0;
    }
    
    private function getBladeFiles($path)
    {
        $fullPath = base_path($path);
        $files = [];
        
        if (!is_dir($fullPath)) {
            return $files;
        }
        
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($fullPath)
        );
        
        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $files[] = $file->getPathname();
            }
        }
        
        return $files;
    }
    
    private function checkBladeFile($filePath, $relativePath)
    {
        $content = file_get_contents($filePath);
        $rootElements = $this->countRootElements($content);
        $issues = $this->identifyIssues($content);
        
        if ($rootElements > 1 || !empty($issues)) {
            $this->warn("⚠️ {$relativePath}: {$rootElements} root elements");
            foreach ($issues as $issue) {
                $this->warn("    - {$issue}");
            }
        }
        
        return [
            'rootElements' => $rootElements,
            'issues' => $issues
        ];
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