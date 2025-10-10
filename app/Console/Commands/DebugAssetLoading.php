<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DebugAssetLoading extends Command
{
    protected $signature = 'debug:asset-loading';
    protected $description = 'Debug asset loading issues for WordPress-style editor';

    public function handle()
    {
        $this->info("🔧 Debugging Asset Loading Issues...");
        
        // Check JavaScript file
        $this->info("\n📁 Checking JavaScript file...");
        $jsPath = public_path('js/wordpress-style-editor.js');
        
        if (file_exists($jsPath)) {
            $this->info("✅ JavaScript file exists: {$jsPath}");
            $this->info("   Size: " . filesize($jsPath) . " bytes");
            $this->info("   Last modified: " . date('Y-m-d H:i:s', filemtime($jsPath)));
            
            // Check if file is readable
            if (is_readable($jsPath)) {
                $this->info("   ✅ File is readable");
            } else {
                $this->error("   ❌ File is not readable");
            }
            
            // Check file permissions
            $perms = fileperms($jsPath);
            $this->info("   Permissions: " . substr(sprintf('%o', $perms), -4));
            
        } else {
            $this->error("❌ JavaScript file not found: {$jsPath}");
            return 1;
        }
        
        // Check CSS file
        $this->info("\n📁 Checking CSS file...");
        $cssPath = public_path('css/wordpress-style-editor.css');
        
        if (file_exists($cssPath)) {
            $this->info("✅ CSS file exists: {$cssPath}");
            $this->info("   Size: " . filesize($cssPath) . " bytes");
            $this->info("   Last modified: " . date('Y-m-d H:i:s', filemtime($cssPath)));
            
            if (is_readable($cssPath)) {
                $this->info("   ✅ File is readable");
            } else {
                $this->error("   ❌ File is not readable");
            }
            
        } else {
            $this->error("❌ CSS file not found: {$cssPath}");
            return 1;
        }
        
        // Check AdminPanelProvider
        $this->info("\n⚙️ Checking AdminPanelProvider...");
        $adminPanelPath = app_path('Providers/Filament/AdminPanelProvider.php');
        
        if (file_exists($adminPanelPath)) {
            $adminPanelContent = file_get_contents($adminPanelPath);
            $this->info("✅ AdminPanelProvider exists");
            
            // Check for asset hooks
            if (strpos($adminPanelContent, 'wordpress-style-editor.js') !== false) {
                $this->info("   ✅ JavaScript asset hook found");
            } else {
                $this->error("   ❌ JavaScript asset hook not found");
            }
            
            if (strpos($adminPanelContent, 'wordpress-style-editor.css') !== false) {
                $this->info("   ✅ CSS asset hook found");
            } else {
                $this->error("   ❌ CSS asset hook not found");
            }
            
        } else {
            $this->error("❌ AdminPanelProvider not found: {$adminPanelPath}");
            return 1;
        }
        
        // Check view file
        $this->info("\n📄 Checking view file...");
        $viewPath = resource_path('views/filament/forms/components/wordpress-style-editor.blade.php');
        
        if (file_exists($viewPath)) {
            $this->info("✅ View file exists: {$viewPath}");
            $this->info("   Size: " . filesize($viewPath) . " bytes");
            $this->info("   Last modified: " . date('Y-m-d H:i:s', filemtime($viewPath)));
            
            if (is_readable($viewPath)) {
                $this->info("   ✅ File is readable");
            } else {
                $this->error("   ❌ File is not readable");
            }
            
        } else {
            $this->error("❌ View file not found: {$viewPath}");
            return 1;
        }
        
        // Check PdfTemplateResource
        $this->info("\n📄 Checking PdfTemplateResource...");
        $resourcePath = app_path('Filament/Resources/PdfTemplateResource.php');
        
        if (file_exists($resourcePath)) {
            $this->info("✅ PdfTemplateResource exists");
            
            $resourceContent = file_get_contents($resourcePath);
            if (strpos($resourceContent, 'WordPressStyleEditor') !== false) {
                $this->info("   ✅ WordPressStyleEditor found");
            } else {
                $this->error("   ❌ WordPressStyleEditor not found");
            }
            
        } else {
            $this->error("❌ PdfTemplateResource not found: {$resourcePath}");
            return 1;
        }
        
        // Check public directory structure
        $this->info("\n📁 Checking public directory structure...");
        $publicJsDir = public_path('js');
        $publicCssDir = public_path('css');
        
        if (is_dir($publicJsDir)) {
            $this->info("✅ Public JS directory exists: {$publicJsDir}");
            $jsFiles = scandir($publicJsDir);
            $this->info("   Files: " . implode(', ', array_filter($jsFiles, function($f) { return $f !== '.' && $f !== '..'; })));
        } else {
            $this->error("❌ Public JS directory not found: {$publicJsDir}");
        }
        
        if (is_dir($publicCssDir)) {
            $this->info("✅ Public CSS directory exists: {$publicCssDir}");
            $cssFiles = scandir($publicCssDir);
            $this->info("   Files: " . implode(', ', array_filter($cssFiles, function($f) { return $f !== '.' && $f !== '..'; })));
        } else {
            $this->error("❌ Public CSS directory not found: {$publicCssDir}");
        }
        
        // Check if files are accessible via web
        $this->info("\n🌐 Checking web accessibility...");
        $baseUrl = 'http://127.0.0.1:8000';
        
        // Test JavaScript file
        $jsUrl = $baseUrl . '/js/wordpress-style-editor.js';
        $this->info("   Testing: {$jsUrl}");
        
        $jsHeaders = @get_headers($jsUrl);
        if ($jsHeaders && strpos($jsHeaders[0], '200') !== false) {
            $this->info("   ✅ JavaScript file accessible via web");
        } else {
            $this->error("   ❌ JavaScript file not accessible via web");
            $this->info("   Headers: " . ($jsHeaders ? implode(', ', $jsHeaders) : 'No headers'));
        }
        
        // Test CSS file
        $cssUrl = $baseUrl . '/css/wordpress-style-editor.css';
        $this->info("   Testing: {$cssUrl}");
        
        $cssHeaders = @get_headers($cssUrl);
        if ($cssHeaders && strpos($cssHeaders[0], '200') !== false) {
            $this->info("   ✅ CSS file accessible via web");
        } else {
            $this->error("   ❌ CSS file not accessible via web");
            $this->info("   Headers: " . ($cssHeaders ? implode(', ', $cssHeaders) : 'No headers'));
        }
        
        // Check JavaScript content
        $this->info("\n🔍 Checking JavaScript content...");
        $jsContent = file_get_contents($jsPath);
        
        // Check for essential patterns
        $essentialPatterns = [
            'window.toggleFormat = toggleFormat;' => 'Global toggleFormat assignment',
            'function toggleFormat(format)' => 'toggleFormat function definition',
            'window.setAlignment = setAlignment;' => 'Global setAlignment assignment',
            'function setAlignment(align)' => 'setAlignment function definition',
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
        
        // Check for syntax errors
        $this->info("\n🔍 Checking for syntax errors...");
        $jsLines = explode("\n", $jsContent);
        $lineNumber = 1;
        $errors = [];
        
        foreach ($jsLines as $line) {
            $line = trim($line);
            
            // Check for common syntax errors
            if (strpos($line, 'function') !== false && strpos($line, '{') === false && strpos($line, ';') === false) {
                $errors[] = "Line {$lineNumber}: Function without opening brace or semicolon";
            }
            
            if (strpos($line, 'window.') !== false && strpos($line, '=') !== false && strpos($line, ';') === false) {
                $errors[] = "Line {$lineNumber}: Assignment without semicolon";
            }
            
            $lineNumber++;
        }
        
        if (empty($errors)) {
            $this->info("   ✅ No obvious syntax errors found");
        } else {
            $this->error("   ❌ Potential syntax errors found:");
            foreach ($errors as $error) {
                $this->error("      {$error}");
            }
        }
        
        $this->info("\n🎉 Asset Loading Debug Completed!");
        
        $this->info("\n📋 Summary:");
        $this->info("   - Check if all files exist and are readable");
        $this->info("   - Check if files are accessible via web");
        $this->info("   - Check if AdminPanelProvider has asset hooks");
        $this->info("   - Check if PdfTemplateResource uses WordPressStyleEditor");
        $this->info("   - Check JavaScript content for syntax errors");
        
        $this->info("\n🚀 Next Steps:");
        $this->info("   1. Ensure server is running: php artisan serve");
        $this->info("   2. Open browser: http://127.0.0.1:8000/admin/pdf-templates/1/edit");
        $this->info("   3. Open browser console (F12)");
        $this->info("   4. Check Network tab for asset loading");
        $this->info("   5. Check Console tab for JavaScript errors");
        $this->info("   6. Look for 'WordPress-style Editor JavaScript loaded' message");
        
        $this->info("\n🔍 Debugging Tips:");
        $this->info("   - Check browser Network tab for 404 errors");
        $this->info("   - Check browser Console tab for JavaScript errors");
        $this->info("   - Check if assets are being loaded from correct URLs");
        $this->info("   - Check if there are any CORS or security issues");
        $this->info("   - Check if there are any JavaScript syntax errors");
        
        return 0;
    }
}