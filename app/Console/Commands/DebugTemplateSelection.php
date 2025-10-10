<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EmailTemplate;
use App\Models\PdfTemplate;

class DebugTemplateSelection extends Command
{
    protected $signature = 'debug:template-selection';
    protected $description = 'Debug template selection logic';

    public function handle()
    {
        $this->info("🔍 Debugging Template Selection Logic...");
        
        // Debug Email Templates
        $this->debugEmailTemplates();
        
        // Debug PDF Templates
        $this->debugPdfTemplates();
        
        // Test the exact query used in ScheduleResource
        $this->testScheduleResourceQuery();
        
        $this->info("\n🎉 Debug completed!");
        
        return 0;
    }
    
    private function debugEmailTemplates()
    {
        $this->info("\n📧 Email Templates Debug:");
        
        // Show all email templates
        $allTemplates = EmailTemplate::where('type', 'mcu_invitation')->get();
        $this->info("Total MCU Invitation templates: " . $allTemplates->count());
        
        foreach ($allTemplates as $template) {
            $this->info("  - ID: {$template->id}, Name: {$template->name}");
            $this->info("    Active: " . ($template->is_active ? 'Yes' : 'No'));
            $this->info("    Default: " . ($template->is_default ? 'Yes' : 'No'));
            $this->info("    Updated: {$template->updated_at}");
            $this->info("    Subject: " . substr($template->subject, 0, 50) . "...");
            $this->info("");
        }
        
        // Test the exact query from ScheduleResource
        $this->info("🔍 Testing ScheduleResource query for Email Templates:");
        $selectedTemplate = EmailTemplate::where('type', 'mcu_invitation')
            ->where('is_active', true)
            ->orderBy('is_default', 'desc')
            ->orderBy('updated_at', 'desc')
            ->first();
            
        if ($selectedTemplate) {
            $this->info("✅ Selected Email Template:");
            $this->info("   ID: {$selectedTemplate->id}");
            $this->info("   Name: {$selectedTemplate->name}");
            $this->info("   Updated: {$selectedTemplate->updated_at}");
            $this->info("   Default: " . ($selectedTemplate->is_default ? 'Yes' : 'No'));
        } else {
            $this->error("❌ No email template selected");
        }
    }
    
    private function debugPdfTemplates()
    {
        $this->info("\n📄 PDF Templates Debug:");
        
        // Show all PDF templates
        $allTemplates = PdfTemplate::where('type', 'mcu_letter')->get();
        $this->info("Total MCU Letter templates: " . $allTemplates->count());
        
        foreach ($allTemplates as $template) {
            $this->info("  - ID: {$template->id}, Name: {$template->name}");
            $this->info("    Active: " . ($template->is_active ? 'Yes' : 'No'));
            $this->info("    Default: " . ($template->is_default ? 'Yes' : 'No'));
            $this->info("    Updated: {$template->updated_at}");
            $this->info("    Combined HTML: " . (!empty($template->combined_html) ? strlen($template->combined_html) . ' chars' : 'Empty'));
            $this->info("    Header HTML: " . (!empty($template->header_html) ? strlen($template->header_html) . ' chars' : 'Empty'));
            $this->info("    Body HTML: " . (!empty($template->body_html) ? strlen($template->body_html) . ' chars' : 'Empty'));
            $this->info("    Footer HTML: " . (!empty($template->footer_html) ? strlen($template->footer_html) . ' chars' : 'Empty'));
            $this->info("");
        }
        
        // Test the exact query from ScheduleResource
        $this->info("🔍 Testing ScheduleResource query for PDF Templates:");
        $selectedTemplate = PdfTemplate::where('type', 'mcu_letter')
            ->where('is_active', true)
            ->orderBy('is_default', 'desc')
            ->orderBy('updated_at', 'desc')
            ->first();
            
        if ($selectedTemplate) {
            $this->info("✅ Selected PDF Template:");
            $this->info("   ID: {$selectedTemplate->id}");
            $this->info("   Name: {$selectedTemplate->name}");
            $this->info("   Updated: {$selectedTemplate->updated_at}");
            $this->info("   Default: " . ($selectedTemplate->is_default ? 'Yes' : 'No'));
            $this->info("   Combined HTML: " . (!empty($selectedTemplate->combined_html) ? strlen($selectedTemplate->combined_html) . ' chars' : 'Empty'));
            
            // Show a preview of the template content
            if (!empty($selectedTemplate->combined_html)) {
                $this->info("   Preview (first 200 chars): " . substr(strip_tags($selectedTemplate->combined_html), 0, 200) . "...");
            } else {
                $this->info("   Preview (first 200 chars): " . substr(strip_tags($selectedTemplate->body_html), 0, 200) . "...");
            }
        } else {
            $this->error("❌ No PDF template selected");
        }
    }
    
    private function testScheduleResourceQuery()
    {
        $this->info("\n🧪 Testing ScheduleResource Query Logic:");
        
        // Test the exact same logic as in ScheduleResource
        $emailTemplate = EmailTemplate::where('type', 'mcu_invitation')
            ->where('is_active', true)
            ->orderBy('is_default', 'desc')
            ->orderBy('updated_at', 'desc')
            ->first();
            
        $pdfTemplate = PdfTemplate::where('type', 'mcu_letter')
            ->where('is_active', true)
            ->orderBy('is_default', 'desc')
            ->orderBy('updated_at', 'desc')
            ->first();
        
        $this->info("📧 Email Template Query Result:");
        if ($emailTemplate) {
            $this->info("   ✅ Found: {$emailTemplate->name} (ID: {$emailTemplate->id})");
            $this->info("   📅 Updated: {$emailTemplate->updated_at}");
            $this->info("   🎯 Default: " . ($emailTemplate->is_default ? 'Yes' : 'No'));
        } else {
            $this->error("   ❌ No template found");
        }
        
        $this->info("📄 PDF Template Query Result:");
        if ($pdfTemplate) {
            $this->info("   ✅ Found: {$pdfTemplate->name} (ID: {$pdfTemplate->id})");
            $this->info("   📅 Updated: {$pdfTemplate->updated_at}");
            $this->info("   🎯 Default: " . ($pdfTemplate->is_default ? 'Yes' : 'No'));
            $this->info("   📝 Combined HTML: " . (!empty($pdfTemplate->combined_html) ? 'Yes (' . strlen($pdfTemplate->combined_html) . ' chars)' : 'No'));
        } else {
            $this->error("   ❌ No template found");
        }
        
        // Show the SQL query
        $this->info("\n🔍 SQL Queries being executed:");
        $this->info("Email Template Query:");
        $emailQuery = EmailTemplate::where('type', 'mcu_invitation')
            ->where('is_active', true)
            ->orderBy('is_default', 'desc')
            ->orderBy('updated_at', 'desc');
        $this->info("   " . $emailQuery->toSql());
        $this->info("   Bindings: " . json_encode($emailQuery->getBindings()));
        
        $this->info("PDF Template Query:");
        $pdfQuery = PdfTemplate::where('type', 'mcu_letter')
            ->where('is_active', true)
            ->orderBy('is_default', 'desc')
            ->orderBy('updated_at', 'desc');
        $this->info("   " . $pdfQuery->toSql());
        $this->info("   Bindings: " . json_encode($pdfQuery->getBindings()));
    }
}