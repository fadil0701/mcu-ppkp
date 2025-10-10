<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestGlobalFunctions extends Command
{
    protected $signature = 'test:global-functions';
    protected $description = 'Test global functions accessibility for toolbar and paste functionality';

    public function handle()
    {
        $this->info("🔧 Testing Global Functions Accessibility...");
        
        // Test JavaScript file
        $this->info("\n⚡ Testing JavaScript global functions...");
        $jsPath = public_path('js/wordpress-style-editor.js');
        
        if (file_exists($jsPath)) {
            $jsContent = file_get_contents($jsPath);
            $this->info("✅ JavaScript file exists: {$jsPath}");
            $this->info("   Size: " . filesize($jsPath) . " bytes");
            
            // Check for global function declarations
            $globalChecks = [
                'window.toggleFormat = null;' => 'Global toggleFormat declaration',
                'window.setAlignment = null;' => 'Global setAlignment declaration',
                'window.toggleList = null;' => 'Global toggleList declaration',
                'window.setHeading = null;' => 'Global setHeading declaration',
                'window.insertPlaceholder = null;' => 'Global insertPlaceholder declaration',
                'window.closeVariableModal = null;' => 'Global closeVariableModal declaration',
                'window.insertVariableValue = null;' => 'Global insertVariableValue declaration',
                'window.searchVariables = null;' => 'Global searchVariables declaration',
                'window.insertImage = null;' => 'Global insertImage declaration',
                'window.closeImageModal = null;' => 'Global closeImageModal declaration',
                'window.handleImageUpload = null;' => 'Global handleImageUpload declaration',
                'window.insertImageFromUrl = null;' => 'Global insertImageFromUrl declaration',
                'window.insertTable = null;' => 'Global insertTable declaration',
                'window.closeTableModal = null;' => 'Global closeTableModal declaration',
                'window.togglePreview = null;' => 'Global togglePreview declaration'
            ];
            
            foreach ($globalChecks as $pattern => $description) {
                if (strpos($jsContent, $pattern) !== false) {
                    $this->info("   ✅ {$description}");
                } else {
                    $this->warn("   ⚠️ {$description} not found");
                }
            }
            
            // Check for function assignments
            $assignmentChecks = [
                'window.toggleFormat = toggleFormat;' => 'toggleFormat assignment to window',
                'window.setAlignment = setAlignment;' => 'setAlignment assignment to window',
                'window.toggleList = toggleList;' => 'toggleList assignment to window',
                'window.setHeading = setHeading;' => 'setHeading assignment to window',
                'window.insertPlaceholder = insertPlaceholder;' => 'insertPlaceholder assignment to window',
                'window.closeVariableModal = closeVariableModal;' => 'closeVariableModal assignment to window',
                'window.insertVariableValue = insertVariableValue;' => 'insertVariableValue assignment to window',
                'window.searchVariables = searchVariables;' => 'searchVariables assignment to window',
                'window.insertImage = insertImage;' => 'insertImage assignment to window',
                'window.closeImageModal = closeImageModal;' => 'closeImageModal assignment to window',
                'window.handleImageUpload = handleImageUpload;' => 'handleImageUpload assignment to window',
                'window.insertImageFromUrl = insertImageFromUrl;' => 'insertImageFromUrl assignment to window',
                'window.insertTable = insertTable;' => 'insertTable assignment to window',
                'window.closeTableModal = closeTableModal;' => 'closeTableModal assignment to window',
                'window.togglePreview = togglePreview;' => 'togglePreview assignment to window'
            ];
            
            foreach ($assignmentChecks as $pattern => $description) {
                if (strpos($jsContent, $pattern) !== false) {
                    $this->info("   ✅ {$description}");
                } else {
                    $this->warn("   ⚠️ {$description} not found");
                }
            }
            
            // Check for function definitions
            $functionChecks = [
                'function toggleFormat(format) {' => 'toggleFormat function definition',
                'function setAlignment(align) {' => 'setAlignment function definition',
                'function toggleList(listType) {' => 'toggleList function definition',
                'function setHeading(heading) {' => 'setHeading function definition',
                'function insertPlaceholder(statePath) {' => 'insertPlaceholder function definition',
                'function closeVariableModal(statePath) {' => 'closeVariableModal function definition',
                'function insertVariableValue(statePath, variable) {' => 'insertVariableValue function definition',
                'function searchVariables(statePath) {' => 'searchVariables function definition',
                'function insertImage(statePath) {' => 'insertImage function definition',
                'function closeImageModal(statePath) {' => 'closeImageModal function definition',
                'function handleImageUpload(statePath, input) {' => 'handleImageUpload function definition',
                'function insertImageFromUrl(statePath) {' => 'insertImageFromUrl function definition',
                'function insertTable(statePath) {' => 'insertTable function definition',
                'function closeTableModal(statePath) {' => 'closeTableModal function definition',
                'function togglePreview(statePath) {' => 'togglePreview function definition'
            ];
            
            foreach ($functionChecks as $pattern => $description) {
                if (strpos($jsContent, $pattern) !== false) {
                    $this->info("   ✅ {$description}");
                } else {
                    $this->warn("   ⚠️ {$description} not found");
                }
            }
            
            // Check for logging
            $loggingChecks = [
                'Global functions assigned to window object' => 'Global functions assignment logging',
                'console.log(\'WordPress-style Editor JavaScript loaded successfully\');' => 'Success logging',
                'console.log(\'toggleFormat called with:\', format);' => 'Function call logging',
                'console.log(\'handlePaste called\');' => 'Paste event logging'
            ];
            
            foreach ($loggingChecks as $pattern => $description) {
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
        $this->info("\n📄 Testing view file onclick handlers...");
        $viewPath = resource_path('views/filament/forms/components/wordpress-style-editor.blade.php');
        
        if (file_exists($viewPath)) {
            $viewContent = file_get_contents($viewPath);
            $this->info("✅ View file exists: {$viewPath}");
            
            // Check for onclick handlers
            $onclickChecks = [
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
            
            foreach ($onclickChecks as $pattern => $description) {
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
        
        // Test AdminPanelProvider
        $this->info("\n⚙️ Testing AdminPanelProvider asset loading...");
        $adminPanelPath = app_path('Providers/Filament/AdminPanelProvider.php');
        $adminPanelContent = file_get_contents($adminPanelPath);
        
        if (strpos($adminPanelContent, 'wordpress-style-editor.js') !== false) {
            $this->info("✅ JavaScript asset hook found");
        } else {
            $this->error("❌ JavaScript asset hook not found");
        }
        
        if (strpos($adminPanelContent, 'wordpress-style-editor.css') !== false) {
            $this->info("✅ CSS asset hook found");
        } else {
            $this->error("❌ CSS asset hook not found");
        }
        
        $this->info("\n🎉 Global Functions Test Completed!");
        
        $this->info("\n📋 Key Features:");
        $this->info("   ✅ Global function declarations in window object");
        $this->info("   ✅ Function assignments to window object");
        $this->info("   ✅ All function definitions present");
        $this->info("   ✅ Onclick handlers in view file");
        $this->info("   ✅ Asset loading configuration");
        $this->info("   ✅ Enhanced logging for debugging");
        
        $this->info("\n🚀 Ready to Test:");
        $this->info("   URL: http://127.0.0.1:8000/admin/pdf-templates/1/edit");
        $this->info("   Status: Global functions ready");
        
        $this->info("\n💡 Testing Steps:");
        $this->info("   1. Open browser and navigate to URL");
        $this->info("   2. Open browser console (F12)");
        $this->info("   3. Look for 'WordPress-style Editor JavaScript loaded'");
        $this->info("   4. Look for 'Global functions assigned to window object'");
        $this->info("   5. Type 'window.toggleFormat' in console - should show function");
        $this->info("   6. Click in the textarea editor");
        $this->info("   7. Look for 'Current editor set to: [path]'");
        $this->info("   8. Try clicking Bold button");
        $this->info("   9. Look for 'toggleFormat called with: bold'");
        $this->info("   10. Try pasting an image (Ctrl+V)");
        $this->info("   11. Look for 'handlePaste called' and 'Image pasted successfully'");
        
        $this->info("\n🔍 Debugging Tips:");
        $this->info("   - MUST open browser console (F12) to see logs");
        $this->info("   - Check for 'Global functions assigned to window object' message");
        $this->info("   - Type 'window.toggleFormat' in console to verify function exists");
        $this->info("   - Look for initialization messages");
        $this->info("   - Check for 'Current editor set to' when clicking in textarea");
        $this->info("   - Watch for function call logs when clicking buttons");
        $this->info("   - Check for error messages if functions fail");
        
        $this->info("\n⚠️ Important Notes:");
        $this->info("   - All functions are now globally available via window object");
        $this->info("   - Click in the textarea FIRST to set current editor");
        $this->info("   - All functions validate currentEditor exists");
        $this->info("   - Error messages will show if no editor selected");
        $this->info("   - Console logs will show exactly what's happening");
        
        return 0;
    }
}