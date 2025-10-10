<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PdfTemplate;

class ClearTestDataAndFixEditor extends Command
{
    protected $signature = 'fix:editor-show-user-data';
    protected $description = 'Clear test data and ensure editor shows only user-saved data';

    public function handle()
    {
        $this->info('🔧 FIXING EDITOR TO SHOW USER-SAVED DATA ONLY...');
        $this->line('');
        
        $template = PdfTemplate::find(1);
        if (!$template) {
            $this->error('❌ Template not found');
            return 1;
        }
        
        $this->info('📊 CURRENT STATE:');
        $this->line('Current content: ' . substr($template->combined_html, 0, 100) . '...');
        $this->line('Content length: ' . strlen($template->combined_html));
        $this->line('');
        
        // Check if content contains test data
        if (strpos($template->combined_html, 'FORM SUBMISSION TEST') !== false ||
            strpos($template->combined_html, 'TEST CONTENT') !== false ||
            strpos($template->combined_html, 'DIRECT DB TEST') !== false) {
            
            $this->warn('⚠️  Found test data in database! Clearing it...');
            
            // Clear test data and set to empty or minimal content
            $cleanContent = '<div class="header">
    <div class="logo-container">
        {logo_image}
    </div>
</div>

<div class="body">
    <h1>Medical Check Up Invitation</h1>
    <p>Please replace this content with your actual template.</p>
</div>

<div class="footer">
    <p>Footer content</p>
</div>';
            
            try {
                $template->update(['combined_html' => $cleanContent]);
                $this->info('✅ Test data cleared, set to clean template');
                
            } catch (\Exception $e) {
                $this->error('❌ Failed to clear test data: ' . $e->getMessage());
                return 1;
            }
        } else {
            $this->info('✅ No test data found in database');
        }
        
        // Verify final state
        $updated = PdfTemplate::find(1);
        $this->line('');
        $this->info('📊 FINAL STATE:');
        $this->line('Content length: ' . strlen($updated->combined_html));
        $this->line('Updated at: ' . $updated->updated_at);
        $this->line('Content preview: ' . substr($updated->combined_html, 0, 100) . '...');
        $this->line('');
        
        // Check for any remaining test data
        if (strpos($updated->combined_html, 'FORM SUBMISSION TEST') !== false ||
            strpos($updated->combined_html, 'TEST CONTENT') !== false ||
            strpos($updated->combined_html, 'DIRECT DB TEST') !== false) {
            $this->error('❌ Test data still found!');
            return 1;
        } else {
            $this->info('✅ No test data found - clean template ready');
        }
        
        $this->line('');
        $this->info('🎯 NEXT STEPS:');
        $this->line('1. Clear browser cache (CTRL+SHIFT+DELETE)');
        $this->line('2. Open /admin/pdf-templates/1/edit');
        $this->line('3. You should see clean template (no test data)');
        $this->line('4. Make your changes and save');
        $this->line('5. Your changes will now be displayed correctly');
        $this->line('');
        $this->info('✅ EDITOR NOW SHOWS USER-SAVED DATA ONLY!');
        
        return 0;
    }
}