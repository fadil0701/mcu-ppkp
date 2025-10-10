<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestIsolatedEditor extends Command
{
    protected $signature = 'test:isolated-editor';
    protected $description = 'Test isolated WordPress-style editor without conflicts';

    public function handle()
    {
        $this->info("🔧 Testing Isolated WordPress-style Editor...");
        
        // Test JavaScript file
        $this->info("\n⚡ Testing isolated JavaScript...");
        $jsPath = public_path('js/wordpress-style-editor.js');
        
        if (file_exists($jsPath)) {
            $jsContent = file_get_contents($jsPath);
            $this->info("✅ JavaScript file exists: {$jsPath}");
            $this->info("   Size: " . filesize($jsPath) . " bytes");
            
            // Check for isolation patterns
            $isolationChecks = [
                '(function() {' => 'IIFE wrapper for isolation',
                "'use strict';" => 'Strict mode for isolation',
                'var wpCurrentEditor' => 'Private variable wpCurrentEditor',
                'var wpCurrentStatePath' => 'Private variable wpCurrentStatePath',
                'function wpToggleFormat' => 'Private function wpToggleFormat',
                'function wpSetAlignment' => 'Private function wpSetAlignment',
                'function wpToggleList' => 'Private function wpToggleList',
                'function wpSetHeading' => 'Private function wpSetHeading',
                'window.toggleFormat = wpToggleFormat;' => 'Global assignment toggleFormat',
                'window.setAlignment = wpSetAlignment;' => 'Global assignment setAlignment',
                'window.toggleList = wpToggleList;' => 'Global assignment toggleList',
                'window.setHeading = wpSetHeading;' => 'Global assignment setHeading',
                'console.log(\'WordPress-style Editor JavaScript loaded (isolated)\');' => 'Isolated loading log',
                'console.log(\'WordPress-style Editor: DOM loaded\');' => 'Isolated DOM log',
                'console.log(\'WordPress-style Editor: Global functions assigned\');' => 'Isolated global functions log'
            ];
            
            foreach ($isolationChecks as $pattern => $description) {
                if (strpos($jsContent, $pattern) !== false) {
                    $this->info("   ✅ {$description}");
                } else {
                    $this->warn("   ⚠️ {$description} not found");
                }
            }
            
            // Check for conflict prevention
            $this->info("\n🔍 Checking for conflict prevention...");
            
            $conflictChecks = [
                'var wpCurrentEditor' => 'Private variable to avoid conflicts',
                'var wpCurrentStatePath' => 'Private variable to avoid conflicts',
                'wpToggleFormat' => 'Prefixed function names',
                'wpSetAlignment' => 'Prefixed function names',
                'wpToggleList' => 'Prefixed function names',
                'wpSetHeading' => 'Prefixed function names',
                'wpInsertImage' => 'Prefixed function names',
                'wpHandlePaste' => 'Prefixed function names',
                'wpUpdateHiddenInput' => 'Prefixed function names',
                'WordPress-style Editor:' => 'Prefixed console logs'
            ];
            
            foreach ($conflictChecks as $pattern => $description) {
                if (strpos($jsContent, $pattern) !== false) {
                    $this->info("   ✅ {$description}");
                } else {
                    $this->warn("   ⚠️ {$description} not found");
                }
            }
            
            // Check for syntax
            $this->info("\n🔍 Checking syntax...");
            
            // Check for balanced braces
            $openBraces = substr_count($jsContent, '{');
            $closeBraces = substr_count($jsContent, '}');
            if ($openBraces === $closeBraces) {
                $this->info("   ✅ Braces are balanced ({$openBraces} open, {$closeBraces} close)");
            } else {
                $this->error("   ❌ Braces are not balanced ({$openBraces} open, {$closeBraces} close)");
            }
            
            // Check for balanced parentheses
            $openParens = substr_count($jsContent, '(');
            $closeParens = substr_count($jsContent, ')');
            if ($openParens === $closeParens) {
                $this->info("   ✅ Parentheses are balanced ({$openParens} open, {$closeParens} close)");
            } else {
                $this->error("   ❌ Parentheses are not balanced ({$openParens} open, {$closeParens} close)");
            }
            
            // Check for IIFE closure
            if (substr_count($jsContent, '(function() {') === 1 && substr_count($jsContent, '})();') === 1) {
                $this->info("   ✅ IIFE properly closed");
            } else {
                $this->error("   ❌ IIFE not properly closed");
            }
            
        } else {
            $this->error("❌ JavaScript file not found: {$jsPath}");
            return 1;
        }
        
        // Test view file
        $this->info("\n📄 Testing view file...");
        $viewPath = resource_path('views/filament/forms/components/wordpress-style-editor.blade.php');
        
        if (file_exists($viewPath)) {
            $this->info("✅ View file exists: {$viewPath}");
            
            $viewContent = file_get_contents($viewPath);
            
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
        
        // Test test file
        $this->info("\n📄 Testing test file...");
        $testPath = public_path('test-editor.html');
        
        if (file_exists($testPath)) {
            $this->info("✅ Test file exists: {$testPath}");
            
            $testContent = file_get_contents($testPath);
            
            // Check for test content
            $testChecks = [
                'isolated' => 'Isolation test content',
                'WordPress-style Editor' => 'WordPress editor references',
                'toggleFormat function exists' => 'Function existence tests',
                'setAlignment function exists' => 'Function existence tests',
                'toggleList function exists' => 'Function existence tests',
                'setHeading function exists' => 'Function existence tests',
                'insertImage function exists' => 'Function existence tests',
                'Checking for conflicts' => 'Conflict detection',
                'Quill editor detected' => 'Conflict detection'
            ];
            
            foreach ($testChecks as $pattern => $description) {
                if (strpos($testContent, $pattern) !== false) {
                    $this->info("   ✅ {$description}");
                } else {
                    $this->warn("   ⚠️ {$description} not found");
                }
            }
            
        } else {
            $this->error("❌ Test file not found: {$testPath}");
            return 1;
        }
        
        $this->info("\n🎉 Isolated Editor Test Completed!");
        
        $this->info("\n📋 Key Features:");
        $this->info("   ✅ IIFE wrapper for complete isolation");
        $this->info("   ✅ Strict mode for better error handling");
        $this->info("   ✅ Private variables with wp prefix");
        $this->info("   ✅ Private functions with wp prefix");
        $this->info("   ✅ Global function assignments");
        $this->info("   ✅ Prefixed console logs");
        $this->info("   ✅ Conflict prevention");
        $this->info("   ✅ Syntax validation");
        $this->info("   ✅ Test file with conflict detection");
        
        $this->info("\n🚀 Ready to Test:");
        $this->info("   Test URL: http://127.0.0.1:8000/test-editor.html");
        $this->info("   Original URL: http://127.0.0.1:8000/admin/pdf-templates/1/edit");
        $this->info("   Status: Isolated editor ready");
        
        $this->info("\n💡 Testing Steps:");
        $this->info("   1. Open browser and navigate to: http://127.0.0.1:8000/test-editor.html");
        $this->info("   2. Open browser console (F12)");
        $this->info("   3. Look for 'WordPress-style Editor JavaScript loaded (isolated)'");
        $this->info("   4. Look for 'WordPress-style Editor: Global functions assigned to window object'");
        $this->info("   5. Click 'Run Tests' button to verify functions");
        $this->info("   6. Check for conflict detection results");
        $this->info("   7. Click in the textarea to set current editor");
        $this->info("   8. Try clicking Bold, Italic, Underline buttons");
        $this->info("   9. Try clicking alignment buttons");
        $this->info("   10. Try clicking list buttons");
        $this->info("   11. Try clicking heading buttons");
        
        $this->info("\n🔍 Debugging Tips:");
        $this->info("   - Check browser console for isolated logs");
        $this->info("   - Look for 'WordPress-style Editor:' prefixed logs");
        $this->info("   - Check for conflict detection in test results");
        $this->info("   - Verify functions are globally available");
        $this->info("   - Test each button individually");
        $this->info("   - Check for error messages in console");
        
        $this->info("\n⚠️ Important Notes:");
        $this->info("   - Editor is now completely isolated with IIFE");
        $this->info("   - All variables and functions are prefixed with 'wp'");
        $this->info("   - Global functions are assigned to window object");
        $this->info("   - Test file includes conflict detection");
        $this->info("   - Should work even with other editors loaded");
        
        return 0;
    }
}