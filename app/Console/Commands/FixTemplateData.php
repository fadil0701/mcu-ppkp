<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PdfTemplate;

class FixTemplateData extends Command
{
    protected $signature = 'fix:template-data';
    protected $description = 'Fix PDF template data by combining header, body, footer into combined_html';

    public function handle()
    {
        $this->info('🔧 FIXING PDF TEMPLATE DATA...');
        $this->line('');

        $template = PdfTemplate::find(1);
        if (!$template) {
            $this->error('❌ PDF Template not found (ID: 1)');
            return 1;
        }

        $this->info('📊 CURRENT STATE:');
        $this->line('Combined HTML: ' . substr($template->combined_html ?? '', 0, 100) . '...');
        $this->line('Header HTML Length: ' . strlen($template->header_html ?? ''));
        $this->line('Body HTML Length: ' . strlen($template->body_html ?? ''));
        $this->line('Footer HTML Length: ' . strlen($template->footer_html ?? ''));
        $this->line('');

        // Check if combined_html contains test data
        if (strpos($template->combined_html ?? '', 'DATABASE WRITE TEST') !== false) {
            $this->warn('⚠️  Combined HTML contains test data - will fix it');
        }

        // Combine header, body, footer into combined_html
        $combined = '';
        
        if ($template->header_html) {
            $combined .= $template->header_html . "\n";
        }
        
        if ($template->body_html) {
            $combined .= $template->body_html . "\n";
        }
        
        if ($template->footer_html) {
            $combined .= $template->footer_html . "\n";
        }

        // Clean up the combined content
        $combined = trim($combined);

        if (empty($combined)) {
            $this->error('❌ No content to combine - all sections are empty');
            return 1;
        }

        $this->info('🔄 COMBINING CONTENT:');
        $this->line('Combined length: ' . strlen($combined) . ' characters');
        $this->line('Preview: ' . substr($combined, 0, 200) . '...');
        $this->line('');

        // Update the template
        try {
            $template->update([
                'combined_html' => $combined,
                'updated_at' => now()
            ]);

            $this->info('✅ Template updated successfully!');
            $this->line('');

            // Verify the update
            $updatedTemplate = PdfTemplate::find(1);
            $this->info('📊 VERIFIED STATE:');
            $this->line('Combined HTML Length: ' . strlen($updatedTemplate->combined_html ?? ''));
            $this->line('Updated At: ' . $updatedTemplate->updated_at);
            $this->line('');

            // Check if test data is gone
            if (strpos($updatedTemplate->combined_html ?? '', 'DATABASE WRITE TEST') !== false) {
                $this->error('❌ Test data still present!');
            } else {
                $this->info('✅ Test data removed successfully!');
            }

            $this->line('');
            $this->info('🎉 TEMPLATE DATA FIXED!');
            $this->line('');
            $this->info('📋 NEXT STEPS:');
            $this->line('1. Clear browser cache (CTRL+SHIFT+DELETE)');
            $this->line('2. Open /admin/pdf-templates/1/edit');
            $this->line('3. Verify editor shows correct content');
            $this->line('4. Test save functionality');

        } catch (\Exception $e) {
            $this->error('❌ Failed to update template: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}