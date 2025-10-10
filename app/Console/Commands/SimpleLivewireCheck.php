<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SimpleLivewireCheck extends Command
{
    protected $signature = 'livewire:simple-check';
    protected $description = 'Simple check for Livewire issues';

    public function handle()
    {
        $this->info("🔍 Simple Livewire Check...");
        
        // Check the main WYSIWYG editor file
        $wysiwygPath = resource_path('views/filament/forms/components/wysiwyg-editor.blade.php');
        
        if (!file_exists($wysiwygPath)) {
            $this->error("❌ WYSIWYG editor file not found!");
            return 1;
        }
        
        $this->info("✅ WYSIWYG editor file exists");
        
        $content = file_get_contents($wysiwygPath);
        
        // Check for specific issues
        $this->info("\n🔍 Checking for specific issues:");
        
        // Check for template tags
        if (strpos($content, '<template') !== false) {
            $this->error("❌ Still contains <template> tags");
            return 1;
        }
        $this->info("✅ No <template> tags found");
        
        // Check for multiple div elements at root level
        $divCount = substr_count($content, '<div');
        $this->info("📊 Total <div> tags: {$divCount}");
        
        // Check for style and script tags
        $styleCount = substr_count($content, '<style>');
        $scriptCount = substr_count($content, '<script>');
        $this->info("📊 <style> tags: {$styleCount}");
        $this->info("📊 <script> tags: {$scriptCount}");
        
        // Check for x-dynamic-component
        if (strpos($content, '<x-dynamic-component') !== false) {
            $this->info("✅ Contains <x-dynamic-component>");
        } else {
            $this->error("❌ Missing <x-dynamic-component>");
            return 1;
        }
        
        // Check for x-data
        if (strpos($content, 'x-data=') !== false) {
            $this->info("✅ Contains x-data");
        } else {
            $this->error("❌ Missing x-data");
            return 1;
        }
        
        // Check file size
        $this->info("📊 File size: " . strlen($content) . " bytes");
        
        // Check if file was recently modified
        $lastModified = filemtime($wysiwygPath);
        $this->info("📊 Last modified: " . date('Y-m-d H:i:s', $lastModified));
        
        $this->info("\n🎉 Simple check completed!");
        
        return 0;
    }
}