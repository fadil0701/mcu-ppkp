<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;

class UpdateEmailSettings extends Command
{
    protected $signature = 'email:update-settings {username} {password}';
    protected $description = 'Update email settings in database';

    public function handle()
    {
        $username = $this->argument('username');
        $password = $this->argument('password');
        
        $this->info('Updating email settings in database...');
        
        try {
            // Update SMTP settings
            Setting::setValue('smtp_username', $username, 'string', 'smtp', 'SMTP Username');
            Setting::setValue('smtp_password', $password, 'string', 'smtp', 'SMTP Password');
            Setting::setValue('smtp_from_address', $username, 'string', 'smtp', 'SMTP From Address');
            Setting::setValue('smtp_from_name', 'Sistem MCU', 'string', 'smtp', 'SMTP From Name');
            Setting::setValue('smtp_host', 'smtp.gmail.com', 'string', 'smtp', 'SMTP Host');
            Setting::setValue('smtp_port', '587', 'string', 'smtp', 'SMTP Port');
            Setting::setValue('smtp_encryption', 'tls', 'string', 'smtp', 'SMTP Encryption');
            
            $this->info('✅ Database email settings updated successfully!');
            $this->info("Username: $username");
            $this->info("Password: [SET]");
            $this->info("From Address: $username");
            
            $this->info("\n🧪 Testing email...");
            
            // Test email
            \Illuminate\Support\Facades\Mail::raw('Test email after updating database settings', function ($message) use ($username) {
                $message->to($username)
                    ->subject('Test Email - Database Settings Updated');
            });
            
            $this->info('✅ Test email sent successfully!');
            
        } catch (\Exception $e) {
            $this->error('❌ Error updating settings: ' . $e->getMessage());
        }
    }
}
