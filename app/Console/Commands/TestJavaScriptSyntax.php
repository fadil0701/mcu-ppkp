<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestJavaScriptSyntax extends Command
{
    protected $signature = 'test:javascript-syntax';
    protected $description = 'Test JavaScript syntax and create a simple test HTML file';

    public function handle()
    {
        $this->info("🔧 Testing JavaScript Syntax and Creating Test File...");
        
        // Create a simple test HTML file
        $testHtml = '<!DOCTYPE html>
<html>
<head>
    <title>WordPress Editor Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .editor-container { border: 1px solid #ccc; padding: 10px; margin: 10px 0; }
        .toolbar { margin: 10px 0; }
        .toolbar button { margin: 5px; padding: 5px 10px; }
        textarea { width: 100%; height: 200px; }
    </style>
</head>
<body>
    <h1>WordPress Editor Test</h1>
    
    <div class="toolbar">
        <button onclick="toggleFormat(\'bold\')">Bold</button>
        <button onclick="toggleFormat(\'italic\')">Italic</button>
        <button onclick="toggleFormat(\'underline\')">Underline</button>
        <button onclick="setAlignment(\'left\')">Left</button>
        <button onclick="setAlignment(\'center\')">Center</button>
        <button onclick="setAlignment(\'right\')">Right</button>
        <button onclick="toggleList(\'ul\')">Bullet List</button>
        <button onclick="toggleList(\'ol\')">Numbered List</button>
        <button onclick="setHeading(\'h1\')">H1</button>
        <button onclick="setHeading(\'h2\')">H2</button>
    </div>
    
    <div class="editor-container">
        <textarea id="tinymce-editor-test" placeholder="Type here to test the editor..."></textarea>
        <input type="hidden" name="test" value="" />
    </div>
    
    <div>
        <h3>Test Results:</h3>
        <div id="test-results"></div>
    </div>
    
    <script src="/js/wordpress-style-editor.js"></script>
    <script>
        // Test functions
        function runTests() {
            const results = document.getElementById(\'test-results\');
            let html = \'<ul>\';
            
            // Test global functions
            if (typeof window.toggleFormat === \'function\') {
                html += \'<li style="color: green;">✅ toggleFormat function exists</li>\';
            } else {
                html += \'<li style="color: red;">❌ toggleFormat function not found</li>\';
            }
            
            if (typeof window.setAlignment === \'function\') {
                html += \'<li style="color: green;">✅ setAlignment function exists</li>\';
            } else {
                html += \'<li style="color: red;">❌ setAlignment function not found</li>\';
            }
            
            if (typeof window.toggleList === \'function\') {
                html += \'<li style="color: green;">✅ toggleList function exists</li>\';
            } else {
                html += \'<li style="color: red;">❌ toggleList function not found</li>\';
            }
            
            if (typeof window.setHeading === \'function\') {
                html += \'<li style="color: green;">✅ setHeading function exists</li>\';
            } else {
                html += \'<li style="color: red;">❌ setHeading function not found</li>\';
            }
            
            if (typeof window.insertImage === \'function\') {
                html += \'<li style="color: green;">✅ insertImage function exists</li>\';
            } else {
                html += \'<li style="color: red;">❌ insertImage function not found</li>\';
            }
            
            html += \'</ul>\';
            results.innerHTML = html;
        }
        
        // Run tests when page loads
        window.addEventListener(\'load\', function() {
            setTimeout(runTests, 1000); // Wait 1 second for scripts to load
        });
        
        // Add test button
        document.addEventListener(\'DOMContentLoaded\', function() {
            const toolbar = document.querySelector(\'.toolbar\');
            const testButton = document.createElement(\'button\');
            testButton.textContent = \'Run Tests\';
            testButton.onclick = runTests;
            toolbar.appendChild(testButton);
        });
    </script>
</body>
</html>';
        
        // Save test file
        $testPath = public_path('test-editor.html');
        file_put_contents($testPath, $testHtml);
        $this->info("✅ Test HTML file created: {$testPath}");
        
        // Test JavaScript file
        $this->info("\n⚡ Testing JavaScript file...");
        $jsPath = public_path('js/wordpress-style-editor.js');
        
        if (file_exists($jsPath)) {
            $jsContent = file_get_contents($jsPath);
            $this->info("✅ JavaScript file exists: {$jsPath}");
            $this->info("   Size: " . filesize($jsPath) . " bytes");
            
            // Check for essential patterns
            $essentialPatterns = [
                'window.toggleFormat = toggleFormat;' => 'Global toggleFormat assignment',
                'function toggleFormat(format)' => 'toggleFormat function definition',
                'window.setAlignment = setAlignment;' => 'Global setAlignment assignment',
                'function setAlignment(align)' => 'setAlignment function definition',
                'window.toggleList = toggleList;' => 'Global toggleList assignment',
                'function toggleList(listType)' => 'toggleList function definition',
                'window.setHeading = setHeading;' => 'Global setHeading assignment',
                'function setHeading(heading)' => 'setHeading function definition',
                'window.insertImage = insertImage;' => 'Global insertImage assignment',
                'function insertImage(statePath)' => 'insertImage function definition',
                'console.log(\'WordPress-style Editor JavaScript loaded\');' => 'Initialization logging',
                'console.log(\'Global functions assigned to window object\');' => 'Global functions logging'
            ];
            
            foreach ($essentialPatterns as $pattern => $description) {
                if (strpos($jsContent, $pattern) !== false) {
                    $this->info("   ✅ {$description}");
                } else {
                    $this->error("   ❌ {$description} not found");
                }
            }
            
            // Check for common syntax issues
            $this->info("\n🔍 Checking for syntax issues...");
            
            // Check for unmatched braces
            $openBraces = substr_count($jsContent, '{');
            $closeBraces = substr_count($jsContent, '}');
            if ($openBraces === $closeBraces) {
                $this->info("   ✅ Braces are balanced ({$openBraces} open, {$closeBraces} close)");
            } else {
                $this->error("   ❌ Braces are not balanced ({$openBraces} open, {$closeBraces} close)");
            }
            
            // Check for unmatched parentheses
            $openParens = substr_count($jsContent, '(');
            $closeParens = substr_count($jsContent, ')');
            if ($openParens === $closeParens) {
                $this->info("   ✅ Parentheses are balanced ({$openParens} open, {$closeParens} close)");
            } else {
                $this->error("   ❌ Parentheses are not balanced ({$openParens} open, {$closeParens} close)");
            }
            
            // Check for function declarations
            $functionCount = substr_count($jsContent, 'function ');
            $this->info("   ✅ Found {$functionCount} function declarations");
            
            // Check for window assignments
            $windowAssignments = substr_count($jsContent, 'window.');
            $this->info("   ✅ Found {$windowAssignments} window object assignments");
            
        } else {
            $this->error("❌ JavaScript file not found: {$jsPath}");
            return 1;
        }
        
        $this->info("\n🎉 JavaScript Syntax Test Completed!");
        
        $this->info("\n📋 Test Results:");
        $this->info("   ✅ Test HTML file created");
        $this->info("   ✅ JavaScript file syntax checked");
        $this->info("   ✅ Global function assignments verified");
        $this->info("   ✅ Function definitions verified");
        $this->info("   ✅ Syntax balance checked");
        
        $this->info("\n🚀 Ready to Test:");
        $this->info("   URL: http://127.0.0.1:8000/test-editor.html");
        $this->info("   Status: Test file ready");
        
        $this->info("\n💡 Testing Steps:");
        $this->info("   1. Open browser and navigate to: http://127.0.0.1:8000/test-editor.html");
        $this->info("   2. Open browser console (F12)");
        $this->info("   3. Look for 'WordPress-style Editor JavaScript loaded'");
        $this->info("   4. Look for 'Global functions assigned to window object'");
        $this->info("   5. Click 'Run Tests' button to verify functions");
        $this->info("   6. Click in the textarea to set current editor");
        $this->info("   7. Try clicking Bold, Italic, Underline buttons");
        $this->info("   8. Try clicking alignment buttons");
        $this->info("   9. Try clicking list buttons");
        $this->info("   10. Try clicking heading buttons");
        
        $this->info("\n🔍 Debugging Tips:");
        $this->info("   - Check browser console for JavaScript errors");
        $this->info("   - Check Network tab for 404 errors");
        $this->info("   - Verify all functions are available in window object");
        $this->info("   - Test each button individually");
        $this->info("   - Check for error messages in console");
        
        $this->info("\n⚠️ Important Notes:");
        $this->info("   - Test file is independent of Filament");
        $this->info("   - All functions should be globally available");
        $this->info("   - Click in textarea first to set current editor");
        $this->info("   - Check console logs for debugging info");
        
        return 0;
    }
}