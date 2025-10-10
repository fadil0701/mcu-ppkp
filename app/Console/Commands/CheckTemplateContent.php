<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PdfTemplate;

class CheckTemplateContent extends Command
{
    protected $signature = 'check:template-content';
    protected $description = 'Check PDF template content';

    public function handle()
    {
        $this->info("🔍 Checking PDF Template Content...");
        
        $templates = PdfTemplate::where('type', 'mcu_letter')->get();
        
        foreach ($templates as $template) {
            $this->info("\n📄 Template: {$template->name} (ID: {$template->id})");
            $this->info("   Updated: {$template->updated_at}");
            $this->info("   Default: " . ($template->is_default ? 'Yes' : 'No'));
            $this->info("   Active: " . ($template->is_active ? 'Yes' : 'No'));
            
            if (!empty($template->combined_html)) {
                $this->info("   Combined HTML: " . strlen($template->combined_html) . " chars");
                $this->info("   Preview: " . substr(strip_tags($template->combined_html), 0, 100) . "...");
            } else {
                $this->info("   Combined HTML: Empty");
            }
            
            $this->info("   Header HTML: " . strlen($template->header_html) . " chars");
            $this->info("   Body HTML: " . strlen($template->body_html) . " chars");
            $this->info("   Footer HTML: " . strlen($template->footer_html) . " chars");
            
            // Show a preview of the content
            $content = $template->combined_html ?: ($template->header_html . $template->body_html . $template->footer_html);
            $this->info("   Content Preview: " . substr(strip_tags($content), 0, 150) . "...");
        }
        
        return 0;
    }
}