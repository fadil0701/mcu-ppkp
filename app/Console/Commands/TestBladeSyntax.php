<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\View\Factory;
use Illuminate\View\Compilers\BladeCompiler;

class TestBladeSyntax extends Command
{
    protected $signature = 'test:blade-syntax';
    protected $description = 'Test Blade syntax for WordPress-style editor';

    public function handle()
    {
        $this->info("🔍 Testing Blade Syntax for WordPress-style Editor...");
        
        $viewPath = resource_path('views/filament/forms/components/wordpress-style-editor.blade.php');
        
        if (!file_exists($viewPath)) {
            $this->error("❌ View file not found: {$viewPath}");
            return 1;
        }
        
        $this->info("✅ View file found: {$viewPath}");
        
        // Read the file content
        $content = file_get_contents($viewPath);
        $this->info("📄 File size: " . strlen($content) . " bytes");
        
        // Test basic syntax
        $this->info("\n🔧 Testing basic Blade syntax...");
        
        // Check for unclosed parentheses and braces
        $parentheses = substr_count($content, '(') - substr_count($content, ')');
        $braces = substr_count($content, '{') - substr_count($content, '}');
        $brackets = substr_count($content, '[') - substr_count($content, ']');
        
        $this->info("   Parentheses balance: " . ($parentheses === 0 ? "✅ Balanced" : "❌ Unbalanced ({$parentheses})"));
        $this->info("   Braces balance: " . ($braces === 0 ? "✅ Balanced" : "❌ Unbalanced ({$braces})"));
        $this->info("   Brackets balance: " . ($brackets === 0 ? "✅ Balanced" : "❌ Unbalanced ({$brackets})"));
        
        // Check for common Blade syntax issues
        $this->info("\n🔍 Checking for common Blade syntax issues...");
        
        $issues = [];
        
        // Check for unescaped @ symbols
        if (preg_match_all('/@(?!\w+)/', $content, $matches)) {
            $issues[] = "Unescaped @ symbols found: " . implode(', ', array_unique($matches[0]));
        }
        
        // Check for malformed Blade directives
        if (preg_match_all('/@\w+\s*\([^)]*$/', $content, $matches)) {
            $issues[] = "Malformed Blade directives: " . implode(', ', $matches[0]);
        }
        
        // Check for unclosed strings
        $singleQuotes = substr_count($content, "'") % 2;
        $doubleQuotes = substr_count($content, '"') % 2;
        
        if ($singleQuotes !== 0) {
            $issues[] = "Unclosed single quotes";
        }
        
        if ($doubleQuotes !== 0) {
            $issues[] = "Unclosed double quotes";
        }
        
        if (empty($issues)) {
            $this->info("✅ No common syntax issues found");
        } else {
            foreach ($issues as $issue) {
                $this->error("❌ " . $issue);
            }
        }
        
        // Test specific problematic line
        $this->info("\n🎯 Testing specific line 148...");
        $lines = explode("\n", $content);
        if (isset($lines[147])) { // Line 148 is index 147
            $line148 = $lines[147];
            $this->info("   Line 148: " . trim($line148));
            
            // Check if the line has proper syntax
            if (strpos($line148, '{{') !== false && strpos($line148, '}}') !== false) {
                $this->info("   ✅ Line 148 has proper Blade syntax");
            } else {
                $this->warn("   ⚠️ Line 148 might have syntax issues");
            }
        }
        
        // Try to compile the view
        $this->info("\n⚙️ Testing view compilation...");
        try {
            $bladeCompiler = app(BladeCompiler::class);
            $compiled = $bladeCompiler->compile($viewPath);
            $this->info("✅ View compiled successfully");
            $this->info("   Compiled size: " . strlen($compiled) . " bytes");
        } catch (\Exception $e) {
            $this->error("❌ View compilation failed: " . $e->getMessage());
            return 1;
        }
        
        // Test view rendering
        $this->info("\n🎨 Testing view rendering...");
        try {
            $viewFactory = app(Factory::class);
            $view = $viewFactory->make('filament.forms.components.wordpress-style-editor', [
                'getStatePath' => fn() => 'test-path',
                'getState' => fn() => '',
                'getFieldWrapperView' => fn() => 'filament::forms.components.field-wrapper',
                'getField' => fn() => (object)['getName' => fn() => 'test'],
                'getAvailablePlaceholders' => fn() => [
                    'participant' => ['name' => 'Nama Peserta'],
                    'schedule' => ['date' => 'Tanggal Pemeriksaan']
                ]
            ]);
            
            $rendered = $view->render();
            $this->info("✅ View rendered successfully");
            $this->info("   Rendered size: " . strlen($rendered) . " bytes");
            
            // Check if rendered content contains expected elements
            $expectedElements = [
                'wordpress-editor-wrapper',
                'wp-toolbar',
                'tinymce-editor',
                'variable-modal',
                'image-modal',
                'table-modal'
            ];
            
            $this->info("\n🔍 Checking rendered content for key elements...");
            foreach ($expectedElements as $element) {
                if (strpos($rendered, $element) !== false) {
                    $this->info("   ✅ Found: {$element}");
                } else {
                    $this->warn("   ⚠️ Missing: {$element}");
                }
            }
            
        } catch (\Exception $e) {
            $this->error("❌ View rendering failed: " . $e->getMessage());
            return 1;
        }
        
        $this->info("\n🎉 Blade syntax test completed successfully!");
        
        return 0;
    }
}