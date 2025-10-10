<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use App\Models\Setting;

class TestEmailConfiguration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {email} {--use-db-settings : Use database settings instead of .env}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email configuration by sending a test email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $useDbSettings = $this->option('use-db-settings');

        if ($useDbSettings) {
            $this->configureFromDatabase();
        }

        $this->info('Testing email configuration...');
        $this->info('Mail Driver: ' . config('mail.default'));
        $this->info('SMTP Host: ' . config('mail.mailers.smtp.host'));
        $this->info('SMTP Port: ' . config('mail.mailers.smtp.port'));
        $this->info('From Address: ' . config('mail.from.address'));

        try {
            Mail::raw('This is a test email from Monitoring MCU System.', function ($message) use ($email) {
                $message->to($email)
                    ->subject('Test Email - Monitoring MCU System');
            });

            $this->info("✅ Test email sent successfully to {$email}!");
            return 0;
        } catch (\Exception $e) {
            $this->error("❌ Failed to send test email: " . $e->getMessage());
            $this->error("Please check your email configuration.");
            return 1;
        }
    }

    private function configureFromDatabase()
    {
        try {
            $smtpSettings = Setting::getGroup('smtp');
            
            Config::set('mail.mailers.smtp.host', $smtpSettings['smtp_host'] ?? config('mail.mailers.smtp.host'));
            Config::set('mail.mailers.smtp.port', $smtpSettings['smtp_port'] ?? config('mail.mailers.smtp.port'));
            Config::set('mail.mailers.smtp.username', $smtpSettings['smtp_username'] ?? config('mail.mailers.smtp.username'));
            Config::set('mail.mailers.smtp.password', $smtpSettings['smtp_password'] ?? config('mail.mailers.smtp.password'));
            Config::set('mail.mailers.smtp.encryption', $smtpSettings['smtp_encryption'] ?? config('mail.mailers.smtp.encryption'));
            Config::set('mail.from.address', $smtpSettings['smtp_from_address'] ?? config('mail.from.address'));
            Config::set('mail.from.name', $smtpSettings['smtp_from_name'] ?? config('mail.from.name'));

            $this->info('✅ Configuration loaded from database settings.');
        } catch (\Exception $e) {
            $this->warn('⚠️  Could not load database settings: ' . $e->getMessage());
        }
    }
}
