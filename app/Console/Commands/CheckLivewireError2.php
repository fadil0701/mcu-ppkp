<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckLivewireError2 extends Command
{
    protected $signature = 'livewire:check-error2';
    protected $description = 'Check Livewire error with different approach';

    public function handle()
    {
        $this->info("🔍 Checking Livewire Error with Different Approach...");
        
        // Approach 1: Check if there are any vendor overrides
        $this->checkVendorOverrides();
        
        // Approach 2: Check if there are any published views
        $this->checkPublishedViews();
        
        // Approach 3: Check if there are any custom components
        $this->checkCustomComponents();
        
        // Approach 4: Check if there are any middleware issues
        $this->checkMiddleware();
        
        // Approach 5: Check if there are any configuration issues
        $this->checkConfiguration();
        
        $this->info("\n🎉 Different approach check completed!");
        
        return 0;
    }
    
    private function checkVendorOverrides()
    {
        $this->info("\n🔍 Approach 1: Checking vendor overrides...");
        
        // Check if there are any vendor overrides in resources/views
        $vendorOverridePaths = [
            'resources/views/vendor/filament',
            'resources/views/vendor/livewire',
        ];
        
        foreach ($vendorOverridePaths as $path) {
            $fullPath = base_path($path);
            if (is_dir($fullPath)) {
                $this->warn("⚠️ Vendor override directory found: {$path}");
                
                // Check files in this directory
                $files = $this->getAllFiles($fullPath);
                foreach ($files as $file) {
                    $relativePath = str_replace(base_path() . '/', '', $file);
                    $this->checkFileForMultipleRoots($file, $relativePath);
                }
            }
        }
    }
    
    private function checkPublishedViews()
    {
        $this->info("\n🔍 Approach 2: Checking published views...");
        
        // Check if there are any published Filament views
        $publishedPaths = [
            'resources/views/filament',
            'resources/views/livewire',
        ];
        
        foreach ($publishedPaths as $path) {
            $fullPath = base_path($path);
            if (is_dir($fullPath)) {
                $this->info("📁 Checking published views: {$path}");
                
                // Check files in this directory
                $files = $this->getAllFiles($fullPath);
                foreach ($files as $file) {
                    $relativePath = str_replace(base_path() . '/', '', $file);
                    $this->checkFileForMultipleRoots($file, $relativePath);
                }
            }
        }
    }
    
    private function checkCustomComponents()
    {
        $this->info("\n🔍 Approach 3: Checking custom components...");
        
        // Check if there are any custom Livewire components
        $componentPaths = [
            'app/Livewire',
            'app/Http/Livewire',
            'app/Components',
        ];
        
        foreach ($componentPaths as $path) {
            $fullPath = base_path($path);
            if (is_dir($fullPath)) {
                $this->info("📁 Checking custom components: {$path}");
                
                // Check files in this directory
                $files = $this->getAllFiles($fullPath);
                foreach ($files as $file) {
                    $relativePath = str_replace(base_path() . '/', '', $file);
                    $this->checkFileForMultipleRoots($file, $relativePath);
                }
            }
        }
    }
    
    private function checkMiddleware()
    {
        $this->info("\n🔍 Approach 4: Checking middleware...");
        
        // Check if there are any custom middleware that might affect Livewire
        $middlewarePath = base_path('app/Http/Middleware');
        if (is_dir($middlewarePath)) {
            $files = $this->getAllFiles($middlewarePath);
            foreach ($files as $file) {
                $relativePath = str_replace(base_path() . '/', '', $file);
                $this->info("📄 Middleware file: {$relativePath}");
            }
        }
    }
    
    private function checkConfiguration()
    {
        $this->info("\n🔍 Approach 5: Checking configuration...");
        
        // Check Livewire configuration
        $configPath = config_path('livewire.php');
        if (file_exists($configPath)) {
            $this->info("📄 Livewire config file exists");
            
            $config = include $configPath;
            if (isset($config['class_namespace'])) {
                $this->info("📄 Livewire class namespace: " . $config['class_namespace']);
            }
        }
        
        // Check Filament configuration
        $filamentConfigPath = config_path('filament.php');
        if (file_exists($filamentConfigPath)) {
            $this->info("📄 Filament config file exists");
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
    
    private function checkFileForMultipleRoots($filePath, $relativePath)
    {
        $content = file_get_contents($filePath);
        
        // Check for multiple root elements
        $rootElements = $this->countRootElements($content);
        
        if ($rootElements > 1) {
            $this->error("❌ {$relativePath}: {$rootElements} root elements");
            
            // Check for specific issues
            if (strpos($content, '<template') !== false) {
                $this->warn("    ⚠️ Contains <template> tags");
            }
            
            if (strpos($content, '<style>') !== false) {
                $this->warn("    ⚠️ Contains <style> tags");
            }
            
            if (strpos($content, '<script>') !== false) {
                $this->warn("    ⚠️ Contains <script> tags");
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