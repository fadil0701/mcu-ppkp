<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PdfTemplate;

class CheckTemplate extends Command
{
    protected $signature = 'template:check {id}';
    protected $description = 'Check template content';

    public function handle()
    {
        $id = $this->argument('id');
        
        $template = PdfTemplate::find($id);
        if (!$template) {
            $this->error("Template with ID {$id} not found!");
            return 1;
        }
        
        $this->info("Template: {$template->name}");
        $this->info("Type: {$template->type}");
        
        $this->info("\n=== HEADER HTML ===");
        $this->info($template->header_html);
        
        $this->info("\n=== BODY HTML ===");
        $this->info($template->body_html);
        
        $this->info("\n=== FOOTER HTML ===");
        $this->info($template->footer_html);
        
        $this->info("\n=== IMAGE PATHS ===");
        $this->info("Logo: " . ($template->logo_path ?: 'NULL'));
        $this->info("Signature: " . ($template->signature_image_path ?: 'NULL'));
        $this->info("Stamp: " . ($template->stamp_image_path ?: 'NULL'));
        
        return 0;
    }
}