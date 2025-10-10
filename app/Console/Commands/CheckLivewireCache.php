<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckLivewireCache extends Command
{
    protected $signature = 'livewire:check-cache';
    protected $description = 'Check Livewire cache and clear if needed';

    public function handle()
    {
        $this->info("🔍 Checking Livewire Cache...");
        
        // Check view cache directory
        $viewCacheDir = storage_path('framework/views');
        if (is_dir($viewCacheDir)) {
            $this->info("📁 View cache directory exists: {$viewCacheDir}");
            
            $files = scandir($viewCacheDir);
            $wysiwygFiles = array_filter($files, function($file) {
                return strpos($file, 'wysiwyg') !== false || 
                       strpos($file, 'pdf-template') !== false ||
                       strpos($file, 'edit-pdf-template') !== false;
            });
            
            if (!empty($wysiwygFiles)) {
                $this->warn("⚠️ Found cached views that might be causing issues:");
                foreach ($wysiwygFiles as $file) {
                    $this->warn("  - {$file}");
                }
                
                $this->info("💡 Clearing view cache...");
                $this->call('view:clear');
            } else {
                $this->info("✅ No problematic cached views found");
            }
        }
        
        // Check bootstrap cache
        $bootstrapCacheDir = base_path('bootstrap/cache');
        if (is_dir($bootstrapCacheDir)) {
            $this->info("📁 Bootstrap cache directory exists: {$bootstrapCacheDir}");
            
            $files = scandir($bootstrapCacheDir);
            $cacheFiles = array_filter($files, function($file) {
                return pathinfo($file, PATHINFO_EXTENSION) === 'php';
            });
            
            if (!empty($cacheFiles)) {
                $this->warn("⚠️ Found bootstrap cache files:");
                foreach ($cacheFiles as $file) {
                    $this->warn("  - {$file}");
                }
                
                $this->info("💡 Clearing bootstrap cache...");
                $this->call('config:clear');
                $this->call('route:clear');
                $this->call('cache:clear');
            }
        }
        
        // Check if there are any Livewire-specific cache files
        $this->checkLivewireSpecificCache();
        
        $this->info("\n🎉 Livewire cache check completed!");
        
        return 0;
    }
    
    private function checkLivewireSpecificCache()
    {
        $this->info("\n🔍 Checking Livewire-specific cache...");
        
        // Check for Livewire cache in storage
        $livewireCacheDir = storage_path('livewire');
        if (is_dir($livewireCacheDir)) {
            $this->info("📁 Livewire cache directory exists: {$livewireCacheDir}");
            
            $files = scandir($livewireCacheDir);
            $cacheFiles = array_filter($files, function($file) {
                return $file !== '.' && $file !== '..';
            });
            
            if (!empty($cacheFiles)) {
                $this->warn("⚠️ Found Livewire cache files:");
                foreach ($cacheFiles as $file) {
                    $this->warn("  - {$file}");
                }
                
                $this->info("💡 Clearing Livewire cache...");
                // Clear Livewire cache if it exists
                $this->call('livewire:clear-cache');
            }
        }
        
        // Check for any other cache directories
        $cacheDirs = [
            storage_path('framework/cache'),
            storage_path('framework/sessions'),
            storage_path('logs'),
        ];
        
        foreach ($cacheDirs as $dir) {
            if (is_dir($dir)) {
                $this->info("📁 Cache directory exists: {$dir}");
            }
        }
    }
}