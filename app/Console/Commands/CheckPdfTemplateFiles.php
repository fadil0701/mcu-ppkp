<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DOMDocument;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class CheckPdfTemplateFiles extends Command
{
    protected $signature = 'pdf:check-all-files';
    protected $description = 'Check all files related to PDF templates for Livewire issues';

    public function handle()
    {
        $this->info("🔍 Checking All PDF Template Related Files...");
        
        // Check all Blade files in the project
        $this->checkAllBladeFiles();
        
        // Check specific PDF template files
        $this->checkPdfTemplateSpecificFiles();
        
        // Check for any custom views
        $this->checkCustomViews();
        
        $this->info("\n🎉 PDF template files check completed!");
        
        return 0;
    }
    
    private function checkAllBladeFiles()
    {
        $this->info("\n📁 Checking all Blade files...");
        
        $directories = [
            'resources/views',
            'app/Filament',
            'vendor/filament' // Check if there are any vendor overrides
        ];
        
        foreach ($directories as $dir) {
            $this->checkDirectory($dir);
        }
    }
    
    private function checkDirectory($directory)
    {
        $fullPath = base_path($directory);
        
        if (!is_dir($fullPath)) {
            return;
        }
        
        $this->info("\n📂 Checking directory: {$directory}");
        
        $iterator = new RecursiveIteratorIterator(
            new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($fullPath)
            )
        );
        
        $bladeFiles = [];
        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $bladeFiles[] = $file->getPathname();
            }
        }
        
        $this->info("📊 Found " . count($bladeFiles) . " PHP files");
        
        $problematicFiles = [];
        
        foreach ($bladeFiles as $file) {
            $relativePath = str_replace(base_path() . '/', '', $file);
            
            // Skip vendor files for now
            if (strpos($relativePath, 'vendor/') === 0) {
                continue;
            }
            
            $result = $this->checkBladeFile($file, $relativePath);
            
            if ($result['rootElements'] > 1) {
                $problematicFiles[] = [
                    'file' => $relativePath,
                    'rootElements' => $result['rootElements'],
                    'issues' => $result['issues']
                ];
            }
        }
        
        if (!empty($problematicFiles)) {
            $this->error("❌ Found " . count($problematicFiles) . " problematic files in {$directory}:");
            
            foreach ($problematicFiles as $file) {
                $this->error("  - {$file['file']} ({$file['rootElements']} root elements)");
                foreach ($file['issues'] as $issue) {
                    $this->warn("    ⚠️ {$issue}");
                }
            }
        } else {
            $this->info("✅ No problematic files found in {$directory}");
        }
    }
    
    private function checkPdfTemplateSpecificFiles()
    {
        $this->info("\n📄 Checking PDF template specific files...");
        
        $specificFiles = [
            'app/Filament/Resources/PdfTemplateResource.php',
            'app/Filament/Resources/PdfTemplateResource/Pages/EditPdfTemplate.php',
            'app/Filament/Resources/PdfTemplateResource/Pages/CreatePdfTemplate.php',
            'app/Filament/Resources/PdfTemplateResource/Pages/ListPdfTemplates.php',
            'app/Models/PdfTemplate.php',
            'app/Services/PdfService.php',
            'resources/views/filament/forms/components/wysiwyg-editor.blade.php',
            'resources/views/filament/forms/components/pdf-template-variables.blade.php',
        ];
        
        foreach ($specificFiles as $file) {
            $this->checkSpecificFile($file);
        }
    }
    
    private function checkSpecificFile($filePath)
    {
        $fullPath = base_path($filePath);
        
        if (!file_exists($fullPath)) {
            $this->warn("⚠️ File not found: {$filePath}");
            return;
        }
        
        $content = file_get_contents($fullPath);
        $rootElements = $this->countRootElements($content);
        $issues = $this->identifyIssues($content);
        
        if ($rootElements > 1) {
            $this->error("❌ {$filePath}: {$rootElements} root elements");
            foreach ($issues as $issue) {
                $this->warn("    ⚠️ {$issue}");
            }
        } elseif ($rootElements === 1) {
            $this->info("✅ {$filePath}: Single root element");
        } else {
            $this->info("ℹ️ {$filePath}: No root elements (PHP file)");
        }
    }
    
    private function checkCustomViews()
    {
        $this->info("\n🔍 Checking for custom views...");
        
        $customViewPaths = [
            'resources/views/filament/resources/pdf-template-resource',
            'resources/views/filament/pages/pdf-template',
            'resources/views/filament/forms/components/pdf-template',
        ];
        
        foreach ($customViewPaths as $path) {
            $fullPath = base_path($path);
            if (is_dir($fullPath)) {
                $this->warn("⚠️ Custom view directory found: {$path}");
                $this->checkDirectory($path);
            }
        }
    }
    
    private function checkBladeFile($filePath, $relativePath)
    {
        $content = file_get_contents($filePath);
        $rootElements = $this->countRootElements($content);
        $issues = $this->identifyIssues($content);
        
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