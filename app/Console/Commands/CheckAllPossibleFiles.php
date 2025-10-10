<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckAllPossibleFiles extends Command
{
    protected $signature = 'livewire:check-all-possible';
    protected $description = 'Check all possible files that could cause Livewire issues';

    public function handle()
    {
        $this->info("🔍 Checking All Possible Files...");
        
        // Check all possible files that could cause the error
        $filesToCheck = [
            'resources/views/filament/forms/components/wysiwyg-editor.blade.php',
            'resources/views/filament/forms/components/pdf-template-variables.blade.php',
            'resources/views/filament/forms/components/template-variables.blade.php',
            'app/Filament/Resources/PdfTemplateResource.php',
            'app/Filament/Resources/PdfTemplateResource/Pages/EditPdfTemplate.php',
            'app/Filament/Resources/PdfTemplateResource/Pages/CreatePdfTemplate.php',
            'app/Filament/Resources/PdfTemplateResource/Pages/ListPdfTemplates.php',
            'app/Models/PdfTemplate.php',
            'app/Services/PdfService.php',
        ];
        
        foreach ($filesToCheck as $file) {
            $this->checkFile($file);
        }
        
        // Check for any custom views
        $this->checkCustomViews();
        
        $this->info("\n🎉 All possible files check completed!");
        
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
        
        // Check for specific issues
        $issues = [];
        
        if (strpos($content, '<template') !== false) {
            $issues[] = 'Contains <template> tags';
        }
        
        if (strpos($content, '<style>') !== false) {
            $issues[] = 'Contains <style> tags';
        }
        
        if (strpos($content, '<script>') !== false) {
            $issues[] = 'Contains <script> tags';
        }
        
        if (strpos($content, '<x-dynamic-component') !== false) {
            $this->info("✅ Contains <x-dynamic-component>");
        }
        
        if (strpos($content, 'x-data=') !== false) {
            $this->info("✅ Contains x-data");
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
                
                // Check files in this directory
                $files = scandir($fullPath);
                foreach ($files as $file) {
                    if ($file !== '.' && $file !== '..' && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                        $this->checkFile($path . '/' . $file);
                    }
                }
            }
        }
    }
}