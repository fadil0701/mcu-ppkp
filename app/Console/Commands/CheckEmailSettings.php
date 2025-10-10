<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;

class CheckEmailSettings extends Command
{
    protected $signature = 'email:check-settings';
    protected $description = 'Check email settings from database and .env';

    public function handle()
    {
        $this->info('=== EMAIL SETTINGS CHECK ===');
        
        // Check .env settings
        $this->info("\n📧 .env Settings:");
        $this->info("MAIL_MAILER: " . config('mail.default'));
        $this->info("MAIL_HOST: " . config('mail.mailers.smtp.host'));
        $this->info("MAIL_PORT: " . config('mail.mailers.smtp.port'));
        $this->info("MAIL_USERNAME: " . config('mail.mailers.smtp.username'));
        $this->info("MAIL_PASSWORD: " . (config('mail.mailers.smtp.password') ? '[SET]' : '[NOT SET]'));
        $this->info("MAIL_ENCRYPTION: " . config('mail.mailers.smtp.encryption'));
        $this->info("MAIL_FROM_ADDRESS: " . config('mail.from.address'));
        $this->info("MAIL_FROM_NAME: " . config('mail.from.name'));
        
        // Check database settings
        $this->info("\n🗄️ Database Settings:");
        try {
            $smtpSettings = Setting::getGroup('smtp');
            foreach ($smtpSettings as $key => $value) {
                if ($key === 'smtp_password') {
                    $this->info("$key: " . ($value ? '[SET]' : '[NOT SET]'));
                } else {
                    $this->info("$key: " . ($value ?: '[NOT SET]'));
                }
            }
        } catch (\Exception $e) {
            $this->error("Error reading database settings: " . $e->getMessage());
        }
        
        $this->info("\n🔍 Analysis:");
        
        // Check if database settings are different
        $dbHost = $smtpSettings['smtp_host'] ?? '';
        $envHost = config('mail.mailers.smtp.host');
        
        if ($dbHost && $dbHost !== $envHost) {
            $this->warn("⚠️  Database SMTP host ($dbHost) different from .env ($envHost)");
            $this->info("💡 EmailService uses database settings, not .env!");
        }
        
        $dbPassword = $smtpSettings['smtp_password'] ?? '';
        $envPassword = config('mail.mailers.smtp.password');
        
        if (!$dbPassword) {
            $this->error("❌ Database SMTP password is empty!");
            $this->info("💡 Update database settings via admin panel: /admin/settings");
        } elseif (!$envPassword) {
            $this->warn("⚠️  .env MAIL_PASSWORD is empty, but database has password");
            $this->info("💡 EmailService will use database password");
        }
        
        $this->info("\n✅ Recommendations:");
        $this->info("1. Update SMTP settings via admin panel: /admin/settings");
        $this->info("2. Make sure database smtp_password is set with App Password");
        $this->info("3. Test with: php artisan email:test-mcu pusdatinppkp@gmail.com");
    }
}
