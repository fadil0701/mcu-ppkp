<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckLivewireError3 extends Command
{
    protected $signature = 'livewire:check-error3';
    protected $description = 'Check Livewire error with comprehensive approach';

    public function handle()
    {
        $this->info("🔍 Comprehensive Livewire Error Check...");
        
        // Approach 1: Check all possible files that could cause the error
        $this->checkAllPossibleFiles();
        
        // Approach 2: Check if there are any issues with the current WYSIWYG editor
        $this->checkWysiwygEditor();
        
        // Approach 3: Try to create a minimal test case
        $this->createMinimalTest();
        
        // Approach 4: Check if there are any issues with the PDF template resource
        $this->checkPdfTemplateResource();
        
        $this->info("\n🎉 Comprehensive check completed!");
        
        return 0;
    }
    
    private function checkAllPossibleFiles()
    {
        $this->info("\n🔍 Approach 1: Checking all possible files...");
        
        // Get all PHP files in the project that might contain Blade templates
        $directories = [
            'resources/views',
            'app/Filament',
            'app/Http/Livewire',
            'app/Livewire',
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
        
        $files = $this->getAllFiles($fullPath);
        $this->info("📊 Found " . count($files) . " PHP files");
        
        $problematicFiles = [];
        
        foreach ($files as $file) {
            $relativePath = str_replace(base_path() . '/', '', $file);
            
            $result = $this->analyzeFile($file, $relativePath);
            
            if ($result['hasMultipleRoots']) {
                $problematicFiles[] = $result;
            }
        }
        
        if (!empty($problematicFiles)) {
            $this->error("❌ Found " . count($problematicFiles) . " problematic files:");
            
            foreach ($problematicFiles as $file) {
                $this->error("  - {$file['path']}");
                foreach ($file['issues'] as $issue) {
                    $this->warn("    ⚠️ {$issue}");
                }
            }
        } else {
            $this->info("✅ No problematic files found in {$directory}");
        }
    }
    
    private function checkWysiwygEditor()
    {
        $this->info("\n🔍 Approach 2: Checking WYSIWYG editor...");
        
        $wysiwygPath = resource_path('views/filament/forms/components/wysiwyg-editor.blade.php');
        
        if (!file_exists($wysiwygPath)) {
            $this->error("❌ WYSIWYG editor file not found!");
            return;
        }
        
        $this->info("✅ WYSIWYG editor file exists");
        
        $content = file_get_contents($wysiwygPath);
        
        // Check for specific issues
        $issues = [];
        
        // Check for template tags
        if (strpos($content, '<template') !== false) {
            $issues[] = 'Contains <template> tags';
        }
        
        // Check for style and script tags
        if (strpos($content, '<style>') !== false) {
            $issues[] = 'Contains <style> tags';
        }
        
        if (strpos($content, '<script>') !== false) {
            $issues[] = 'Contains <script> tags';
        }
        
        // Check for x-dynamic-component
        if (strpos($content, '<x-dynamic-component') !== false) {
            $this->info("✅ Contains <x-dynamic-component>");
        } else {
            $issues[] = 'Missing <x-dynamic-component>';
        }
        
        // Check for x-data
        if (strpos($content, 'x-data=') !== false) {
            $this->info("✅ Contains x-data");
        } else {
            $issues[] = 'Missing x-data';
        }
        
        if (!empty($issues)) {
            $this->warn("⚠️ Issues found:");
            foreach ($issues as $issue) {
                $this->warn("  - {$issue}");
            }
        } else {
            $this->info("✅ No issues found");
        }
    }
    
    private function createMinimalTest()
    {
        $this->info("\n🔍 Approach 3: Creating minimal test...");
        
        // Create a minimal test file to see if the issue persists
        $testContent = <<<'EOT'
<x-dynamic-component :component="$getFieldWrapperView()" :field="$getField()">
    <div x-data="testData">
        <p>Test content</p>
    </div>
</x-dynamic-component>
EOT;
        
        $testPath = resource_path('views/filament/forms/components/test-editor.blade.php');
        file_put_contents($testPath, $testContent);
        
        $this->info("✅ Created minimal test file: {$testPath}");
        
        // Check if this minimal file has multiple root elements
        $rootElements = $this->countRootElements($testContent);
        
        if ($rootElements === 1) {
            $this->info("✅ Minimal test file has single root element");
        } else {
            $this->error("❌ Minimal test file has {$rootElements} root elements");
        }
        
        // Clean up test file
        unlink($testPath);
        $this->info("✅ Cleaned up test file");
    }
    
    private function checkPdfTemplateResource()
    {
        $this->info("\n🔍 Approach 4: Checking PDF template resource...");
        
        $resourcePath = base_path('app/Filament/Resources/PdfTemplateResource.php');
        
        if (!file_exists($resourcePath)) {
            $this->error("❌ PDF template resource file not found!");
            return;
        }
        
        $this->info("✅ PDF template resource file exists");
        
        $content = file_get_contents($resourcePath);
        
        // Check if the resource uses our WYSIWYG editor
        if (strpos($content, 'WysiwygEditor') !== false) {
            $this->info("✅ Uses WysiwygEditor");
        } else {
            $this->warn("⚠️ Does not use WysiwygEditor");
        }
        
        // Check for any custom form components
        if (strpos($content, 'Forms\\Components\\') !== false) {
            $this->info("✅ Uses form components");
        }
    }
    
    private function getAllFiles($directory)
    {
        $files = [];
        
        if (!is_dir($directory)) {
            return $files;
        }
        
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory)
        );
        
        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $files[] = $file->getPathname();
            }
        }
        
        return $files;
    }
    
    private function analyzeFile($filePath, $relativePath)
    {
        $content = file_get_contents($filePath);
        
        $result = [
            'path' => $relativePath,
            'hasMultipleRoots' => false,
            'issues' => []
        ];
        
        // Check for multiple root elements
        $rootElements = $this->countRootElements($content);
        
        if ($rootElements > 1) {
            $result['hasMultipleRoots'] = true;
            $result['issues'][] = "Has {$rootElements} root elements";
        }
        
        // Check for specific issues
        if (strpos($content, '<template') !== false) {
            $result['issues'][] = 'Contains <template> tags';
        }
        
        if (strpos($content, '<style>') !== false) {
            $result['issues'][] = 'Contains <style> tags';
        }
        
        if (strpos($content, '<script>') !== false) {
            $result['issues'][] = 'Contains <script> tags';
        }
        
        return $result;
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