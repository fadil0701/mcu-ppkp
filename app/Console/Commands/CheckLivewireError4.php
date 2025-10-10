<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckLivewireError4 extends Command
{
    protected $signature = 'livewire:check-error4';
    protected $description = 'Check Livewire error with final approach';

    public function handle()
    {
        $this->info("🔍 Final Livewire Error Check...");
        
        // Approach 1: Check the exact WYSIWYG editor file
        $this->checkWysiwygEditorExact();
        
        // Approach 2: Try to disable the WYSIWYG editor temporarily
        $this->disableWysiwygEditor();
        
        // Approach 3: Check if there are any other issues
        $this->checkOtherIssues();
        
        $this->info("\n🎉 Final check completed!");
        
        return 0;
    }
    
    private function checkWysiwygEditorExact()
    {
        $this->info("\n🔍 Approach 1: Checking WYSIWYG editor exactly...");
        
        $wysiwygPath = resource_path('views/filament/forms/components/wysiwyg-editor.blade.php');
        
        if (!file_exists($wysiwygPath)) {
            $this->error("❌ WYSIWYG editor file not found!");
            return;
        }
        
        $this->info("✅ WYSIWYG editor file exists");
        
        $content = file_get_contents($wysiwygPath);
        
        // Check the exact structure
        $this->info("📊 File size: " . strlen($content) . " bytes");
        
        // Count lines
        $lines = explode("\n", $content);
        $this->info("📊 Total lines: " . count($lines));
        
        // Check for specific patterns
        $divCount = substr_count($content, '<div');
        $styleCount = substr_count($content, '<style>');
        $scriptCount = substr_count($content, '<script>');
        $templateCount = substr_count($content, '<template');
        
        $this->info("📊 <div> tags: {$divCount}");
        $this->info("📊 <style> tags: {$styleCount}");
        $this->info("📊 <script> tags: {$scriptCount}");
        $this->info("📊 <template> tags: {$templateCount}");
        
        // Check for x-dynamic-component
        if (strpos($content, '<x-dynamic-component') !== false) {
            $this->info("✅ Contains <x-dynamic-component>");
        } else {
            $this->error("❌ Missing <x-dynamic-component>");
        }
        
        // Check for x-data
        if (strpos($content, 'x-data=') !== false) {
            $this->info("✅ Contains x-data");
        } else {
            $this->error("❌ Missing x-data");
        }
        
        // Check the exact structure
        $this->checkExactStructure($content);
    }
    
    private function checkExactStructure($content)
    {
        $this->info("\n🔍 Checking exact structure...");
        
        // Check if there are multiple root elements
        $rootElements = $this->countRootElements($content);
        
        if ($rootElements === 1) {
            $this->info("✅ Single root element confirmed");
        } else {
            $this->error("❌ Multiple root elements detected: {$rootElements}");
        }
        
        // Check for specific issues
        if (strpos($content, '<template') !== false) {
            $this->warn("⚠️ Still contains <template> tags");
        }
        
        if (strpos($content, '<style>') !== false) {
            $this->warn("⚠️ Still contains <style> tags");
        }
        
        if (strpos($content, '<script>') !== false) {
            $this->warn("⚠️ Still contains <script> tags");
        }
    }
    
    private function disableWysiwygEditor()
    {
        $this->info("\n🔍 Approach 2: Temporarily disabling WYSIWYG editor...");
        
        // Check if we can temporarily disable the WYSIWYG editor
        $resourcePath = base_path('app/Filament/Resources/PdfTemplateResource.php');
        
        if (!file_exists($resourcePath)) {
            $this->error("❌ PDF template resource file not found!");
            return;
        }
        
        $this->info("✅ PDF template resource file exists");
        
        $content = file_get_contents($resourcePath);
        
        // Check if it uses WysiwygEditor
        if (strpos($content, 'WysiwygEditor') !== false) {
            $this->info("✅ Uses WysiwygEditor");
            
            // Create a backup
            $backupPath = $resourcePath . '.backup';
            file_put_contents($backupPath, $content);
            $this->info("✅ Created backup: {$backupPath}");
            
            // Temporarily replace WysiwygEditor with RichEditor
            $newContent = str_replace('WysiwygEditor', 'RichEditor', $content);
            file_put_contents($resourcePath, $newContent);
            $this->info("✅ Temporarily replaced WysiwygEditor with RichEditor");
            
            // Clear cache
            $this->call('view:clear');
            $this->info("✅ Cleared view cache");
            
            $this->warn("⚠️ WYSIWYG editor temporarily disabled. Test the page now!");
            $this->info("💡 If the error is gone, the issue is with the WYSIWYG editor");
            $this->info("💡 If the error persists, the issue is elsewhere");
            
            // Restore the original file
            file_put_contents($resourcePath, $content);
            $this->info("✅ Restored original file");
            
            // Clear cache again
            $this->call('view:clear');
            $this->info("✅ Cleared view cache again");
            
        } else {
            $this->warn("⚠️ Does not use WysiwygEditor");
        }
    }
    
    private function checkOtherIssues()
    {
        $this->info("\n🔍 Approach 3: Checking other issues...");
        
        // Check if there are any other custom components
        $componentPath = base_path('app/Filament/Forms/Components/WysiwygEditor.php');
        
        if (!file_exists($componentPath)) {
            $this->error("❌ WysiwygEditor component file not found!");
            return;
        }
        
        $this->info("✅ WysiwygEditor component file exists");
        
        $content = file_get_contents($componentPath);
        
        // Check if the component is properly configured
        if (strpos($content, 'extends') !== false) {
            $this->info("✅ Component extends proper class");
        } else {
            $this->error("❌ Component does not extend proper class");
        }
        
        if (strpos($content, 'getView') !== false) {
            $this->info("✅ Component has getView method");
        } else {
            $this->error("❌ Component missing getView method");
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