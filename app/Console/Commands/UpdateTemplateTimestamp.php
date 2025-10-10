<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PdfTemplate;

class UpdateTemplateTimestamp extends Command
{
    protected $signature = 'template:update-timestamp {id}';
    protected $description = 'Update template timestamp to make it latest';

    public function handle()
    {
        $id = $this->argument('id');
        
        $template = PdfTemplate::find($id);
        
        if (!$template) {
            $this->error("Template with ID {$id} not found");
            return 1;
        }
        
        $this->info("Updating timestamp for template: {$template->name}");
        
        // Update the timestamp to now
        $template->touch();
        
        $this->info("✅ Template timestamp updated to: {$template->fresh()->updated_at}");
        
        // Show which template will be selected now
        $selectedTemplate = PdfTemplate::where('type', 'mcu_letter')
            ->where('is_active', true)
            ->orderBy('is_default', 'desc')
            ->orderBy('updated_at', 'desc')
            ->first();
            
        $this->info("📄 Selected template will now be: {$selectedTemplate->name} (ID: {$selectedTemplate->id})");
        
        return 0;
    }
}