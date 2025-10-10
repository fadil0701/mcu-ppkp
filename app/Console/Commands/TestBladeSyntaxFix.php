<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;

class TestBladeSyntaxFix extends Command
{
    protected $signature = 'test:blade-syntax-fix';
    protected $description = 'Test Blade syntax fix for WordPress-style editor';

    public function handle()
    {
        $this->info('Testing Blade syntax fix...');
        
        try {
            // Test the specific file that was causing the error
            $filePath = resource_path('views/filament/forms/components/wordpress-style-editor.blade.php');
            
            if (!File::exists($filePath)) {
                $this->error('File not found: ' . $filePath);
                return 1;
            }
            
            $this->info('File exists: ' . $filePath);
            
            // Read file content
            $content = File::get($filePath);
            $this->info('File size: ' . strlen($content) . ' bytes');
            
            // Check for common Blade syntax issues
            $issues = [];
            
            // Check for unclosed parentheses in Blade directives
            if (preg_match_all('/@\w+\([^)]*$/', $content, $matches)) {
                $issues[] = 'Unclosed parentheses in Blade directives: ' . implode(', ', $matches[0]);
            }
            
            // Check for mismatched brackets in PHP expressions
            if (preg_match_all('/\{\{[^}]*$/', $content, $matches)) {
                $issues[] = 'Unclosed double braces: ' . implode(', ', $matches[0]);
            }
            
            // Check for mismatched brackets in escaped expressions
            if (preg_match_all('/\{!![^!]*$/', $content, $matches)) {
                $issues[] = 'Unclosed escaped braces: ' . implode(', ', $matches[0]);
            }
            
            // Check line 226 specifically (the problematic line)
            $lines = explode("\n", $content);
            if (isset($lines[225])) { // Line 226 (0-indexed)
                $line226 = $lines[225];
                $this->info('Line 226 content: ' . $line226);
                
                // Check if the line has proper syntax
                if (strpos($line226, '{!!') !== false && strpos($line226, '!!}') !== false) {
                    $this->info('✅ Line 226 has proper escaped braces syntax');
                } elseif (strpos($line226, '{{') !== false && strpos($line226, '}}') !== false) {
                    $this->info('✅ Line 226 has proper double braces syntax');
                } else {
                    $this->warn('⚠️ Line 226 might have syntax issues');
                }
            }
            
            if (empty($issues)) {
                $this->info('✅ No obvious Blade syntax issues found');
            } else {
                foreach ($issues as $issue) {
                    $this->error('❌ ' . $issue);
                }
            }
            
            // Try to compile the view (this will catch syntax errors)
            try {
                $view = View::make('filament.forms.components.wordpress-style-editor', [
                    'getStatePath' => fn() => 'test',
                    'getState' => fn() => '<p>Test content</p>',
                    'availablePlaceholders' => [
                        'participant' => ['name' => 'Nama peserta'],
                        'schedule' => ['date' => 'Tanggal pemeriksaan']
                    ]
                ]);
                
                $compiled = $view->render();
                $this->info('✅ View compiled successfully');
                $this->info('Compiled content length: ' . strlen($compiled) . ' characters');
                
            } catch (\Exception $e) {
                $this->error('❌ View compilation failed: ' . $e->getMessage());
                $this->error('Error at line: ' . $e->getLine());
                return 1;
            }
            
            $this->info('✅ Blade syntax fix test completed successfully');
            return 0;
            
        } catch (\Exception $e) {
            $this->error('Error testing Blade syntax: ' . $e->getMessage());
            return 1;
        }
    }
}