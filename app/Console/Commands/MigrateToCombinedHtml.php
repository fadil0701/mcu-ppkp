<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PdfTemplate;

class MigrateToCombinedHtml extends Command
{
    protected $signature = 'template:migrate-combined {id?}';
    protected $description = 'Migrate template to combined_html format';

    public function handle()
    {
        $id = $this->argument('id');
        
        if ($id) {
            $templates = PdfTemplate::where('id', $id)->get();
        } else {
            $templates = PdfTemplate::where('type', 'mcu_letter')->get();
        }
        
        foreach ($templates as $template) {
            $this->info("📄 Processing template: {$template->name} (ID: {$template->id})");
            
            if (!empty($template->combined_html)) {
                $this->info("   ⏭️ Already has combined_html, skipping");
                continue;
            }
            
            // Combine header, body, footer with markers
            $combined = '';
            
            if (!empty($template->header_html)) {
                $combined .= $template->header_html . "\n<!-- HEADER_END -->\n";
            }
            
            if (!empty($template->body_html)) {
                $combined .= $template->body_html . "\n<!-- FOOTER_START -->\n";
            }
            
            if (!empty($template->footer_html)) {
                $combined .= $template->footer_html;
            }
            
            // Update template
            $template->combined_html = $combined;
            $template->save();
            
            $this->info("   ✅ Migrated to combined_html: " . strlen($combined) . " chars");
        }
        
        $this->info("\n🎉 Migration completed!");
        
        // Show updated templates
        $this->info("\n📋 Updated templates:");
        foreach ($templates as $template) {
            $template->refresh();
            $this->info("   - {$template->name}: " . (!empty($template->combined_html) ? strlen($template->combined_html) . ' chars' : 'No combined_html'));
        }
        
        return 0;
    }
}