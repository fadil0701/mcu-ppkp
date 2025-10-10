<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PdfTemplate;

class CheckCombinedHtml extends Command
{
    protected $signature = 'check:combined-html';
    protected $description = 'Check which templates have combined_html';

    public function handle()
    {
        $this->info("🔍 Checking Combined HTML in PDF Templates...");
        
        $templates = PdfTemplate::where('type', 'mcu_letter')->get();
        
        $hasCombinedHtml = false;
        
        foreach ($templates as $template) {
            $this->info("\n📄 Template: {$template->name} (ID: {$template->id})");
            $this->info("   Updated: {$template->updated_at}");
            $this->info("   Default: " . ($template->is_default ? 'Yes' : 'No'));
            
            if (!empty($template->combined_html)) {
                $this->info("   ✅ HAS Combined HTML: " . strlen($template->combined_html) . " chars");
                $hasCombinedHtml = true;
                
                // Show preview of combined HTML
                $preview = substr(strip_tags($template->combined_html), 0, 200);
                $this->info("   Preview: {$preview}...");
            } else {
                $this->info("   ❌ NO Combined HTML");
            }
        }
        
        if (!$hasCombinedHtml) {
            $this->warn("\n⚠️ No templates have combined_html!");
            $this->info("This means the combined editor hasn't been used yet.");
            $this->info("You need to edit a template using the new combined editor.");
        } else {
            $this->info("\n✅ Found templates with combined_html!");
        }
        
        return 0;
    }
}