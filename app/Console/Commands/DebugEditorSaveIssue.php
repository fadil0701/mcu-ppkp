<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PdfTemplate;
use Illuminate\Support\Facades\DB;

class DebugEditorSaveIssue extends Command
{
    protected $signature = 'debug:editor-save-issue';
    protected $description = 'Debug why editor content does not update after save';

    public function handle()
    {
        $this->info('🔍 DEBUGGING EDITOR SAVE ISSUE...');
        $this->line('');

        // Step 1: Check current database state
        $template = PdfTemplate::find(1);
        if (!$template) {
            $this->error('❌ Template not found');
            return 1;
        }

        $this->info('📊 CURRENT DATABASE STATE:');
        $this->line('ID: ' . $template->id);
        $this->line('Title: ' . $template->title);
        $this->line('Combined HTML Length: ' . strlen($template->combined_html ?? ''));
        $this->line('Updated At: ' . $template->updated_at);
        $this->line('Combined HTML Preview: ' . substr($template->combined_html ?? '', 0, 100) . '...');
        $this->line('');

        // Step 2: Check CKEditor5 component default method
        $this->info('🔍 CHECKING CKEDITOR5 COMPONENT...');
        $resourceFile = app_path('Filament/Resources/PdfTemplateResource.php');
        
        if (file_exists($resourceFile)) {
            $content = file_get_contents($resourceFile);
            
            // Find CKEditor5 component
            if (preg_match('/CKEditor5::make\(\'combined_html\'\)[\s\S]*?->default\(([^}]+)\)/', $content, $matches)) {
                $this->warn('⚠️  FOUND: CKEditor5 default() method');
                $this->line('This method might be overriding saved data!');
                $this->line('');
                
                // Check if it has fallback logic
                if (strpos($matches[1], 'header_html') !== false || strpos($matches[1], 'body_html') !== false) {
                    $this->error('❌ PROBLEM: Default method has fallback logic!');
                    $this->line('This explains why editor shows old content instead of saved content.');
                    $this->line('');
                    
                    $this->info('🔧 SOLUTION: Remove or modify the default() method');
                }
            } else {
                $this->info('✅ No problematic default() method found');
            }
        }
        
        $this->line('');

        // Step 3: Check JavaScript data sync
        $this->info('🔍 CHECKING JAVASCRIPT DATA SYNC...');
        $jsFile = public_path('js/ckeditor5-collaborative.js');
        
        if (file_exists($jsFile)) {
            $content = file_get_contents($jsFile);
            
            // Check setData call
            if (preg_match('/editor\.setData\(([^)]+)\)/', $content, $matches)) {
                $this->info('✅ setData() call found');
                $this->line('Parameter: ' . $matches[1]);
                
                if (strpos($matches[1], 'textarea.value') !== false) {
                    $this->info('✅ setData uses textarea.value - correct');
                } else {
                    $this->warn('⚠️  setData might not use correct data source');
                }
            } else {
                $this->error('❌ setData() call not found');
            }
            
            // Check data sync events
            $events = [
                'change:data' => 'Real-time sync',
                'form.addEventListener.*submit' => 'Form submit sync',
                'click.*save' => 'Save button sync'
            ];
            
            foreach ($events as $pattern => $description) {
                if (preg_match('/' . str_replace('*', '.*', $pattern) . '/', $content)) {
                    $this->info("✅ {$description} found");
                } else {
                    $this->warn("⚠️  {$description} not found");
                }
            }
        }
        
        $this->line('');

        // Step 4: Test database update
        $this->info('🔍 TESTING DATABASE UPDATE...');
        
        $testContent = '<p>SAVE TEST - ' . now()->format('Y-m-d H:i:s') . '</p>';
        
        try {
            $template->update(['combined_html' => $testContent]);
            $this->info('✅ Database update successful');
            
            // Verify immediately
            $updated = PdfTemplate::find(1);
            if (strpos($updated->combined_html, 'SAVE TEST') !== false) {
                $this->info('✅ Database read successful - content saved correctly');
            } else {
                $this->error('❌ Database read failed - content not saved');
            }
            
            // Restore original
            $template->update(['combined_html' => $template->combined_html]);
            $this->info('✅ Original content restored');
            
        } catch (\Exception $e) {
            $this->error('❌ Database update failed: ' . $e->getMessage());
        }
        
        $this->line('');

        // Step 5: Check for caching issues
        $this->info('🔍 CHECKING FOR CACHING ISSUES...');
        
        // Check if there's any model caching
        if (method_exists($template, 'getCachedAttribute')) {
            $this->warn('⚠️  Model might have attribute caching');
        }
        
        // Check for global scopes
        $scopes = $template->getGlobalScopes();
        if (!empty($scopes)) {
            $this->warn('⚠️  Model has global scopes that might affect data');
        }
        
        $this->info('✅ No obvious caching issues found');
        $this->line('');

        // Step 6: Recommendations
        $this->info('🔧 IMMEDIATE SOLUTIONS:');
        $this->line('');
        
        $this->line('1. REMOVE CKEditor5 default() method:');
        $this->line('   - Edit PdfTemplateResource.php');
        $this->line('   - Remove or comment out ->default() method');
        $this->line('');
        
        $this->line('2. CLEAR ALL CACHES:');
        $this->line('   php artisan cache:clear');
        $this->line('   php artisan view:clear');
        $this->line('   php artisan config:clear');
        $this->line('');
        
        $this->line('3. CLEAR BROWSER CACHE:');
        $this->line('   CTRL + SHIFT + DELETE');
        $this->line('');
        
        $this->line('4. CHECK JAVASCRIPT CONSOLE:');
        $this->line('   - Open F12 Developer Tools');
        $this->line('   - Look for JavaScript errors');
        $this->line('   - Check if data sync events are firing');
        $this->line('');
        
        $this->line('5. VERIFY FORM SUBMISSION:');
        $this->line('   - Check if form is actually submitting');
        $this->line('   - Verify POST data in Network tab');
        $this->line('');

        $this->info('🎯 LIKELY ROOT CAUSE:');
        $this->line('CKEditor5 default() method is overriding saved data with fallback content');
        $this->line('');

        return 0;
    }
}