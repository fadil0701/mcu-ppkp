<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Schedule;
use App\Models\EmailTemplate;
use App\Models\PdfTemplate;
use App\Services\EmailService;

class TestEmailWithLatestTemplate extends Command
{
    protected $signature = 'email:test-latest-template {email?}';
    protected $description = 'Test email with latest templates';

    public function handle()
    {
        $email = $this->argument('email') ?? 'test@example.com';
        
        $this->info("🧪 Testing Email with Latest Templates...");
        $this->info("📧 Target email: {$email}");
        
        // Get latest templates
        $this->info("\n🔍 Getting latest templates...");
        
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
        
        if ($emailTemplate) {
            $this->info("✅ Email Template: {$emailTemplate->name}");
            $this->info("   📅 Updated: {$emailTemplate->updated_at}");
            $this->info("   🎯 Default: " . ($emailTemplate->is_default ? 'Yes' : 'No'));
        } else {
            $this->error("❌ No email template found");
            return 1;
        }
        
        if ($pdfTemplate) {
            $this->info("✅ PDF Template: {$pdfTemplate->name}");
            $this->info("   📅 Updated: {$pdfTemplate->updated_at}");
            $this->info("   🎯 Default: " . ($pdfTemplate->is_default ? 'Yes' : 'No'));
            
            // Check if template has combined_html
            if (!empty($pdfTemplate->combined_html)) {
                $this->info("   📝 Combined HTML: " . strlen($pdfTemplate->combined_html) . " characters");
            } else {
                $this->warn("   ⚠️ No combined_html found, using individual sections");
            }
            
            // Check individual sections
            if (!empty($pdfTemplate->header_html)) {
                $this->info("   📄 Header HTML: " . strlen($pdfTemplate->header_html) . " characters");
            }
            if (!empty($pdfTemplate->body_html)) {
                $this->info("   📄 Body HTML: " . strlen($pdfTemplate->body_html) . " characters");
            }
            if (!empty($pdfTemplate->footer_html)) {
                $this->info("   📄 Footer HTML: " . strlen($pdfTemplate->footer_html) . " characters");
            }
        } else {
            $this->error("❌ No PDF template found");
            return 1;
        }
        
        // Create a test schedule
        $this->info("\n📋 Creating test schedule...");
        $schedule = new Schedule([
            'nama_lengkap' => 'Test User',
            'email' => $email,
            'no_telp' => '08123456789',
            'nik_ktp' => '1234567890123456',
            'tanggal_lahir' => now()->subYears(30),
            'jenis_kelamin' => 'L',
            'skpd' => 'Test SKPD',
            'ukpd' => 'Test Unit',
            'tanggal_pemeriksaan' => now()->addDays(7),
            'jam_pemeriksaan' => now()->setTime(8, 0),
            'lokasi_pemeriksaan' => 'Test Location',
            'queue_number' => 1,
        ]);
        
        $this->info("✅ Test schedule created");
        
        // Test email service
        $this->info("\n📤 Testing email service...");
        
        try {
            $emailService = new EmailService();
            $success = $emailService->sendMcuInvitation($schedule, $emailTemplate, $pdfTemplate);
            
            if ($success) {
                $this->info("✅ Email sent successfully!");
                $this->info("📧 Check your email at: {$email}");
                
                // Show template details
                $this->info("\n📊 Template Details:");
                $this->info("   Email Subject: {$emailTemplate->subject}");
                $this->info("   Email Body: " . strlen($emailTemplate->body_html) . " characters");
                $this->info("   PDF Template: {$pdfTemplate->name}");
                
                if (!empty($pdfTemplate->combined_html)) {
                    $this->info("   📝 Using combined HTML: " . strlen($pdfTemplate->combined_html) . " characters");
                }
                
            } else {
                $this->error("❌ Failed to send email");
                return 1;
            }
            
        } catch (\Exception $e) {
            $this->error("❌ Email service error: " . $e->getMessage());
            return 1;
        }
        
        $this->info("\n🎉 Test completed successfully!");
        return 0;
    }
}