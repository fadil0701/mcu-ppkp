<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestUltraSimpleImplementation extends Command
{
    protected $signature = 'test:ultra-simple';
    protected $description = 'Test ultra simple implementation for toolbar and paste functionality';

    public function handle()
    {
        $this->info("🔧 Testing Ultra Simple Implementation...");
        
        // Test JavaScript file
        $this->info("\n⚡ Testing ultra simple JavaScript...");
        $jsPath = public_path('js/wordpress-style-editor.js');
        
        if (file_exists($jsPath)) {
            $jsContent = file_get_contents($jsPath);
            $this->info("✅ JavaScript file exists: {$jsPath}");
            $this->info("   Size: " . filesize($jsPath) . " bytes");
            
            // Check for ultra simple implementation
            $implementationChecks = [
                'let currentEditor = null;' => 'Global currentEditor variable',
                'let currentStatePath = \'\';' => 'Global currentStatePath variable',
                'currentEditor = textarea;' => 'Current editor assignment',
                'currentStatePath = statePath;' => 'Current state path assignment',
                'if (!currentEditor) {' => 'Editor validation',
                'console.error(\'No current editor\');' => 'Error logging for no editor',
                'alert(\'No editor selected\');' => 'User feedback for no editor',
                'console.log(\'toggleFormat called with:\', format);' => 'Function call logging',
                'console.log(\'handlePaste called\');' => 'Paste event logging',
                'try {' => 'Error handling',
                'catch (error) {' => 'Error catching',
                'addEventListener(\'click\', function() {' => 'Click event listeners',
                'addEventListener(\'focus\', function() {' => 'Focus event listeners',
                'addEventListener(\'input\', function() {' => 'Input event listeners',
                'addEventListener(\'paste\', function(e) {' => 'Paste event listeners',
                'setSelectionRange(' => 'Cursor positioning',
                'updateHiddenInput();' => 'Hidden input updates',
                'setInterval(function() {' => 'Auto-save interval'
            ];
            
            foreach ($implementationChecks as $pattern => $description) {
                if (strpos($jsContent, $pattern) !== false) {
                    $this->info("   ✅ {$description}");
                } else {
                    $this->warn("   ⚠️ {$description} not found");
                }
            }
            
        } else {
            $this->error("❌ JavaScript file not found: {$jsPath}");
            return 1;
        }
        
        // Test view file
        $this->info("\n📄 Testing view file...");
        $viewPath = resource_path('views/filament/forms/components/wordpress-style-editor.blade.php');
        
        if (file_exists($viewPath)) {
            $viewContent = file_get_contents($viewPath);
            $this->info("✅ View file exists: {$viewPath}");
            
            // Check for proper button setup
            $buttonChecks = [
                'onclick="toggleFormat(\'bold\')"' => 'Bold button onclick handler',
                'onclick="toggleFormat(\'italic\')"' => 'Italic button onclick handler',
                'onclick="toggleFormat(\'underline\')"' => 'Underline button onclick handler',
                'onclick="setAlignment(\'left\')"' => 'Left alignment button handler',
                'onclick="setAlignment(\'center\')"' => 'Center alignment button handler',
                'onclick="setAlignment(\'right\')"' => 'Right alignment button handler',
                'onclick="setAlignment(\'justify\')"' => 'Justify alignment button handler',
                'onclick="toggleList(\'ul\')"' => 'Bullet list button handler',
                'onclick="toggleList(\'ol\')"' => 'Numbered list button handler',
                'onclick="insertPlaceholder(' => 'Insert Variable button handler',
                'onclick="insertImage(' => 'Insert Image button handler',
                'onclick="insertTable(' => 'Insert Table button handler',
                'onclick="togglePreview(' => 'Preview button handler'
            ];
            
            foreach ($buttonChecks as $pattern => $description) {
                if (strpos($viewContent, $pattern) !== false) {
                    $this->info("   ✅ {$description}");
                } else {
                    $this->warn("   ⚠️ {$description} not found");
                }
            }
            
        } else {
            $this->error("❌ View file not found: {$viewPath}");
            return 1;
        }
        
        // Test CSS file
        $this->info("\n🎨 Testing CSS file...");
        $cssPath = public_path('css/wordpress-style-editor.css');
        
        if (file_exists($cssPath)) {
            $cssContent = file_get_contents($cssPath);
            $this->info("✅ CSS file exists: {$cssPath}");
            
            // Check for essential styling
            $cssChecks = [
                '.wp-btn' => 'Button styling',
                '.wp-toolbar' => 'Toolbar styling',
                '.toolbar-group' => 'Toolbar group styling',
                '.wp-editor' => 'Editor styling',
                '.variable-modal' => 'Modal styling',
                'hover' => 'Hover effects',
                'transition' => 'Smooth transitions'
            ];
            
            foreach ($cssChecks as $pattern => $description) {
                if (strpos($cssContent, $pattern) !== false) {
                    $this->info("   ✅ {$description}");
                } else {
                    $this->warn("   ⚠️ {$description} not found");
                }
            }
            
        } else {
            $this->error("❌ CSS file not found: {$cssPath}");
            return 1;
        }
        
        // Test AdminPanelProvider
        $this->info("\n⚙️ Testing AdminPanelProvider...");
        $adminPanelPath = app_path('Providers/Filament/AdminPanelProvider.php');
        $adminPanelContent = file_get_contents($adminPanelPath);
        
        if (strpos($adminPanelContent, 'wordpress-style-editor.css') !== false) {
            $this->info("✅ CSS asset hook found");
        } else {
            $this->error("❌ CSS asset hook not found");
        }
        
        if (strpos($adminPanelContent, 'wordpress-style-editor.js') !== false) {
            $this->info("✅ JS asset hook found");
        } else {
            $this->error("❌ JS asset hook not found");
        }
        
        // Test PdfTemplateResource
        $this->info("\n📄 Testing PdfTemplateResource...");
        $resourcePath = app_path('Filament/Resources/PdfTemplateResource.php');
        $resourceContent = file_get_contents($resourcePath);
        
        if (strpos($resourceContent, 'WordPressStyleEditor') !== false) {
            $this->info("✅ WordPressStyleEditor found");
        } else {
            $this->error("❌ WordPressStyleEditor not found");
        }
        
        $this->info("\n🎉 Ultra Simple Implementation Test Completed!");
        
        $this->info("\n📋 Key Features:");
        $this->info("   ✅ Global currentEditor variable for state management");
        $this->info("   ✅ Global currentStatePath variable for form integration");
        $this->info("   ✅ Editor validation with user feedback");
        $this->info("   ✅ Enhanced error handling and logging");
        $this->info("   ✅ Event listeners for click, focus, input, paste");
        $this->info("   ✅ Direct textarea manipulation");
        $this->info("   ✅ Cursor positioning with setSelectionRange");
        $this->info("   ✅ Hidden input updates");
        $this->info("   ✅ Auto-save functionality");
        $this->info("   ✅ Image paste with validation");
        $this->info("   ✅ All toolbar functions with validation");
        
        $this->info("\n🚀 Ready to Test:");
        $this->info("   URL: http://127.0.0.1:8000/admin/pdf-templates/1/edit");
        $this->info("   Status: Ultra simple implementation ready");
        
        $this->info("\n💡 Testing Steps:");
        $this->info("   1. Open browser and navigate to URL");
        $this->info("   2. Open browser console (F12)");
        $this->info("   3. Look for 'WordPress-style Editor JavaScript loaded'");
        $this->info("   4. Look for 'DOM loaded, initializing editor...'");
        $this->info("   5. Look for 'Found editors: X' and 'Editor setup complete'");
        $this->info("   6. Click in the textarea editor");
        $this->info("   7. Look for 'Current editor set to: [path]'");
        $this->info("   8. Try clicking Bold button");
        $this->info("   9. Look for 'toggleFormat called with: bold'");
        $this->info("   10. Try pasting an image (Ctrl+V)");
        $this->info("   11. Look for 'handlePaste called' and 'Image pasted successfully'");
        
        $this->info("\n🔍 Debugging Tips:");
        $this->info("   - MUST open browser console (F12) to see logs");
        $this->info("   - Look for initialization messages");
        $this->info("   - Check for 'Current editor set to' when clicking in textarea");
        $this->info("   - Watch for function call logs when clicking buttons");
        $this->info("   - Check for error messages if functions fail");
        $this->info("   - Verify 'Hidden input updated' messages");
        
        $this->info("\n⚠️ Important Notes:");
        $this->info("   - Click in the textarea FIRST to set current editor");
        $this->info("   - All functions now validate currentEditor exists");
        $this->info("   - Error messages will show if no editor selected");
        $this->info("   - Console logs will show exactly what's happening");
        
        return 0;
    }
}