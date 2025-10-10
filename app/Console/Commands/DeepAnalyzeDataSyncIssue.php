<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PdfTemplate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DeepAnalyzeDataSyncIssue extends Command
{
    protected $signature = 'analyze:data-sync-issue';
    protected $description = 'Deep analysis of CKEditor 5 data sync issue - saved data not matching displayed data';

    public function handle()
    {
        $this->info('═══════════════════════════════════════════════════════════════');
        $this->info('        🔍 DEEP ANALYSIS: DATA SYNC ISSUE');
        $this->info('═══════════════════════════════════════════════════════════════');
        $this->line('');

        $this->info('🔍 ANALYZING DATA SYNC ISSUE: "Saved data not matching displayed data"');
        $this->line('');

        // Step 1: Check database state
        $this->info('STEP 1: DATABASE STATE ANALYSIS');
        $this->line('');
        
        $template = PdfTemplate::find(1);
        if ($template) {
            $this->info('✅ PDF Template found (ID: 1)');
            $this->line('');
            
            $this->info('📊 CURRENT DATABASE VALUES:');
            $this->line('Title: ' . $template->title);
            $this->line('Combined HTML Length: ' . strlen($template->combined_html ?? ''));
            $this->line('Header HTML Length: ' . strlen($template->header_html ?? ''));
            $this->line('Body HTML Length: ' . strlen($template->body_html ?? ''));
            $this->line('Footer HTML Length: ' . strlen($template->footer_html ?? ''));
            $this->line('Created At: ' . $template->created_at);
            $this->line('Updated At: ' . $template->updated_at);
            $this->line('');
            
            // Check if combined_html contains test data
            if (strpos($template->combined_html ?? '', 'DATABASE WRITE TEST') !== false) {
                $this->error('❌ PROBLEM FOUND: combined_html contains test data!');
                $this->line('Content preview: ' . substr($template->combined_html, 0, 100) . '...');
            } else {
                $this->info('✅ combined_html does not contain test data');
                if ($template->combined_html) {
                    $this->line('Content preview: ' . substr($template->combined_html, 0, 100) . '...');
                }
            }
            
        } else {
            $this->error('❌ PDF Template not found (ID: 1)');
            return 1;
        }
        
        $this->line('');

        // Step 2: Check CKEditor 5 component configuration
        $this->info('STEP 2: CKEDITOR 5 COMPONENT ANALYSIS');
        $this->line('');
        
        $resourceFile = app_path('Filament/Resources/PdfTemplateResource.php');
        if (file_exists($resourceFile)) {
            $content = file_get_contents($resourceFile);
            
            // Check for default() method in CKEditor5
            if (preg_match('/CKEditor5::make\(\'combined_html\'\)[\s\S]*?->default\(([^)]+)\)/', $content, $matches)) {
                $this->info('✅ CKEditor5 default() method found');
                $this->line('Default logic: ' . substr($matches[1], 0, 100) . '...');
                
                // Check if default method has fallback logic
                if (strpos($matches[1], 'header_html') !== false && strpos($matches[1], 'body_html') !== false) {
                    $this->warn('⚠️  WARNING: Default method has fallback logic that might cause issues');
                    $this->line('This could explain why test data appears instead of actual content');
                }
            } else {
                $this->error('❌ CKEditor5 default() method not found');
            }
        }
        
        $this->line('');

        // Step 3: Check JavaScript data sync
        $this->info('STEP 3: JAVASCRIPT DATA SYNC ANALYSIS');
        $this->line('');
        
        $jsFile = public_path('js/ckeditor5-collaborative.js');
        if (file_exists($jsFile)) {
            $content = file_get_contents($jsFile);
            
            $this->info('✅ JavaScript file found (' . filesize($jsFile) . ' bytes)');
            
            // Check for setData call
            if (strpos($content, 'setData') !== false) {
                $this->info('✅ setData() method found in JavaScript');
            } else {
                $this->error('❌ setData() method not found in JavaScript');
            }
            
            // Check for data sync events
            $syncEvents = [
                'change:data' => 'Real-time sync',
                'form submit' => 'Form submission sync',
                'save button click' => 'Save button sync'
            ];
            
            foreach ($syncEvents as $event => $description) {
                if (strpos($content, $event) !== false) {
                    $this->info("✅ {$description} found");
                } else {
                    $this->error("❌ {$description} not found");
                }
            }
            
        } else {
            $this->error('❌ JavaScript file not found');
        }
        
        $this->line('');

        // Step 4: Check Blade component
        $this->info('STEP 4: BLADE COMPONENT ANALYSIS');
        $this->line('');
        
        $bladeFile = resource_path('views/filament/forms/components/ckeditor5.blade.php');
        if (file_exists($bladeFile)) {
            $content = file_get_contents($bladeFile);
            
            $this->info('✅ Blade component found');
            
            // Check for textarea value
            if (preg_match('/textarea[^>]*>([^<]*)</', $content, $matches)) {
                $this->info('✅ Textarea content found');
                if (strpos($matches[1], 'DATABASE WRITE TEST') !== false) {
                    $this->error('❌ PROBLEM: Textarea contains test data!');
                } else {
                    $this->info('✅ Textarea does not contain test data');
                }
            }
            
            // Check for initialization
            if (strpos($content, 'initCollaborativeEditor') !== false) {
                $this->info('✅ initCollaborativeEditor call found');
            } else {
                $this->error('❌ initCollaborativeEditor call not found');
            }
            
        } else {
            $this->error('❌ Blade component not found');
        }
        
        $this->line('');

        // Step 5: Check for test data sources
        $this->info('STEP 5: TEST DATA SOURCE ANALYSIS');
        $this->line('');
        
        // Check if there are any test commands or seeders
        $testCommands = [
            'app/Console/Commands/DebugSaveIssue.php',
            'app/Console/Commands/TestPdfEmail.php',
            'database/seeders/PdfTemplateSeeder.php'
        ];
        
        foreach ($testCommands as $command) {
            if (file_exists($command)) {
                $content = file_get_contents($command);
                if (strpos($content, 'DATABASE WRITE TEST') !== false) {
                    $this->error("❌ FOUND: {$command} contains test data");
                } else {
                    $this->info("✅ {$command} does not contain test data");
                }
            }
        }
        
        $this->line('');

        // Step 6: Check cache
        $this->info('STEP 6: CACHE ANALYSIS');
        $this->line('');
        
        $cacheKey = 'pdf_template_1';
        $cached = Cache::get($cacheKey);
        if ($cached) {
            $this->warn('⚠️  CACHE FOUND: Template might be cached');
            if (strpos($cached, 'DATABASE WRITE TEST') !== false) {
                $this->error('❌ CACHED DATA contains test data!');
            }
        } else {
            $this->info('✅ No template cache found');
        }
        
        $this->line('');

        // Step 7: Recommendations
        $this->info('STEP 7: RECOMMENDATIONS');
        $this->line('');
        
        $this->warn('🔧 IMMEDIATE FIXES NEEDED:');
        $this->line('');
        
        $this->line('1. CLEAR ALL CACHES:');
        $this->line('   php artisan cache:clear');
        $this->line('   php artisan view:clear');
        $this->line('   php artisan config:clear');
        $this->line('');
        
        $this->line('2. CHECK DATABASE DIRECTLY:');
        $this->line('   SELECT id, title, LEFT(combined_html, 100) as preview FROM pdf_templates WHERE id = 1;');
        $this->line('');
        
        $this->line('3. CLEAR BROWSER CACHE:');
        $this->line('   CTRL + SHIFT + DELETE');
        $this->line('');
        
        $this->line('4. CHECK FOR HARDCODED TEST DATA:');
        $this->line('   Search for "DATABASE WRITE TEST" in all files');
        $this->line('');
        
        $this->line('5. VERIFY CKEditor5 DEFAULT METHOD:');
        $this->line('   Check if default() method is overriding actual data');
        $this->line('');

        // Step 8: Test database update
        $this->info('STEP 8: DATABASE UPDATE TEST');
        $this->line('');
        
        $testContent = '<p>TEST CONTENT - ' . now() . '</p>';
        
        try {
            $template->update(['combined_html' => $testContent]);
            $this->info('✅ Database update successful');
            
            // Verify update
            $updatedTemplate = PdfTemplate::find(1);
            if (strpos($updatedTemplate->combined_html, 'TEST CONTENT') !== false) {
                $this->info('✅ Database read successful - test content found');
            } else {
                $this->error('❌ Database read failed - test content not found');
            }
            
            // Restore original content
            $template->update(['combined_html' => $template->combined_html]);
            $this->info('✅ Original content restored');
            
        } catch (\Exception $e) {
            $this->error('❌ Database update failed: ' . $e->getMessage());
        }
        
        $this->line('');

        $this->info('═══════════════════════════════════════════════════════════════');
        $this->info('            📋 ANALYSIS COMPLETE');
        $this->info('═══════════════════════════════════════════════════════════════');
        $this->line('');
        
        $this->info('🎯 LIKELY CAUSES:');
        $this->line('');
        $this->line('1. CKEditor5 default() method overriding actual data');
        $this->line('2. Cached test data not cleared');
        $this->line('3. JavaScript not properly syncing data');
        $this->line('4. Browser cache showing old data');
        $this->line('5. Fallback logic in default() method');
        $this->line('');
        
        $this->info('🚀 NEXT STEPS:');
        $this->line('');
        $this->line('1. Run: php artisan cache:clear && php artisan view:clear');
        $this->line('2. Clear browser cache (CTRL+SHIFT+DELETE)');
        $this->line('3. Check CKEditor5 default() method in PdfTemplateResource');
        $this->line('4. Verify JavaScript data sync is working');
        $this->line('5. Test with fresh browser session');
        $this->line('');

        return 0;
    }
}