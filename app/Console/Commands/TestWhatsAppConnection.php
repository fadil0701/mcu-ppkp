<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TestWhatsAppConnection extends Command
{
    protected $signature = 'whatsapp:test
                            {--phone= : Phone number to test (default: your configured number)}
                            {--provider= : WhatsApp provider (fonnte, wablas, meta, or custom)}';

    protected $description = 'Test WhatsApp API connection and configuration';

    public function handle()
    {
        $this->info('=== WhatsApp Connection Test ===');
        $this->newLine();

        // Check settings
        $this->info('1. Checking WhatsApp settings...');
        $whatsappSettings = Setting::getGroup('whatsapp');
        
        $token = $whatsappSettings['whatsapp_token'] ?? '';
        $instanceId = $whatsappSettings['whatsapp_instance_id'] ?? '';
        $phoneNumber = $whatsappSettings['whatsapp_phone_number'] ?? '';
        
        if (empty($token)) {
            $this->error('❌ WhatsApp token is not configured!');
            $this->info('Please set it in Settings > WhatsApp Settings');
            return 1;
        } else {
            $this->info('✓ Token found: ' . substr($token, 0, 10) . '...');
        }
        
        if (empty($instanceId)) {
            $this->warn('⚠ Instance ID is empty (may not be required for all providers)');
        } else {
            $this->info('✓ Instance ID: ' . $instanceId);
        }
        
        if (empty($phoneNumber)) {
            $this->warn('⚠ Phone number is empty');
        } else {
            $this->info('✓ Phone Number: ' . $phoneNumber);
        }
        
        $this->newLine();
        
        // Detect provider
        $provider = $this->option('provider');
        if (!$provider) {
            $provider = $this->choice(
                'Which WhatsApp API provider are you using?',
                ['fonnte', 'wablas', 'meta', 'custom'],
                0
            );
        }
        
        $this->newLine();
        $this->info('2. Testing connection to ' . strtoupper($provider) . ' API...');
        
        // Test phone number
        $testPhone = $this->option('phone') ?: $this->ask('Enter test phone number (e.g., 08123456789)');
        $testPhone = $this->cleanPhoneNumber($testPhone);
        
        $this->info('Testing with phone: ' . $testPhone);
        $this->newLine();
        
        try {
            $result = $this->testProvider($provider, $token, $instanceId, $testPhone);
            
            if ($result['success']) {
                $this->info('✓ Connection successful!');
                $this->info('Response: ' . json_encode($result['response'], JSON_PRETTY_PRINT));
                
                // Show configuration suggestion
                $this->newLine();
                $this->info('=== Configuration is correct ===');
                $this->info('If messages still don\'t send, check:');
                $this->info('1. Your WhatsApp API account has sufficient balance/quota');
                $this->info('2. The phone number is registered/verified');
                $this->info('3. Check logs: tail -f storage/logs/laravel.log');
                
            } else {
                $this->error('❌ Connection failed!');
                $this->error('Error: ' . $result['error']);
                $this->newLine();
                
                $this->error('=== Troubleshooting Steps ===');
                $this->displayTroubleshooting($provider);
            }
            
        } catch (\Exception $e) {
            $this->error('❌ Exception: ' . $e->getMessage());
            $this->displayTroubleshooting($provider);
        }
        
        return 0;
    }
    
    private function testProvider($provider, $token, $instanceId, $phoneNumber)
    {
        $testMessage = "Test message from MCU System at " . now()->format('Y-m-d H:i:s');
        
        try {
            switch ($provider) {
                case 'fonnte':
                    return $this->testFonnte($token, $phoneNumber, $testMessage);
                    
                case 'wablas':
                    return $this->testWablas($token, $phoneNumber, $testMessage);
                    
                case 'meta':
                    return $this->testMeta($token, $instanceId, $phoneNumber, $testMessage);
                    
                case 'custom':
                    $this->warn('Custom provider selected. Please manually configure the endpoint.');
                    return ['success' => false, 'error' => 'Custom provider requires manual configuration'];
                    
                default:
                    return ['success' => false, 'error' => 'Unknown provider'];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    private function testFonnte($token, $phoneNumber, $message)
    {
        $this->info('Using Fonnte API endpoint...');
        
        $response = Http::withOptions([
            'verify' => false, // Disable SSL verification for local development
        ])->withHeaders([
            'Authorization' => $token,
        ])->post('https://api.fonnte.com/send', [
            'target' => $phoneNumber,
            'message' => $message,
            'countryCode' => '62',
        ]);
        
        if ($response->successful()) {
            return ['success' => true, 'response' => $response->json()];
        } else {
            return ['success' => false, 'error' => $response->body()];
        }
    }
    
    private function testWablas($token, $phoneNumber, $message)
    {
        $this->info('Using Wablas API endpoint...');
        
        $response = Http::withOptions([
            'verify' => false,
        ])->withHeaders([
            'Authorization' => $token,
        ])->post('https://console.wablas.com/api/send-message', [
            'phone' => $phoneNumber,
            'message' => $message,
        ]);
        
        if ($response->successful()) {
            return ['success' => true, 'response' => $response->json()];
        } else {
            return ['success' => false, 'error' => $response->body()];
        }
    }
    
    private function testMeta($token, $phoneNumberId, $recipientPhone, $message)
    {
        $this->info('Using Meta (Facebook) WhatsApp Business API...');
        
        $response = Http::withOptions([
            'verify' => false,
        ])->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ])->post("https://graph.facebook.com/v18.0/{$phoneNumberId}/messages", [
            'messaging_product' => 'whatsapp',
            'to' => $recipientPhone,
            'type' => 'text',
            'text' => [
                'body' => $message,
            ],
        ]);
        
        if ($response->successful()) {
            return ['success' => true, 'response' => $response->json()];
        } else {
            return ['success' => false, 'error' => $response->body()];
        }
    }
    
    private function displayTroubleshooting($provider)
    {
        $this->newLine();
        
        switch ($provider) {
            case 'fonnte':
                $this->info('Fonnte Configuration:');
                $this->info('1. Token: Your Fonnte API key (not "Bearer xxx", just the key)');
                $this->info('2. Get token from: https://fonnte.com');
                $this->info('3. Instance ID: Not required for Fonnte');
                break;
                
            case 'wablas':
                $this->info('Wablas Configuration:');
                $this->info('1. Token: Your Wablas token');
                $this->info('2. Get token from: https://wablas.com');
                $this->info('3. Domain might be different (e.g., yourinstance.wablas.com)');
                break;
                
            case 'meta':
                $this->info('Meta WhatsApp Business API Configuration:');
                $this->info('1. Token: Your Meta access token');
                $this->info('2. Instance ID: Your Phone Number ID from Meta Business');
                $this->info('3. Setup guide: https://developers.facebook.com/docs/whatsapp/cloud-api');
                break;
        }
        
        $this->newLine();
        $this->info('Common Issues:');
        $this->info('1. Wrong token format');
        $this->info('2. Expired token');
        $this->info('3. Insufficient account balance');
        $this->info('4. Phone number not in correct format');
        $this->info('5. API endpoint changed by provider');
    }
    
    private function cleanPhoneNumber(string $phone): string
    {
        // Remove all non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // If starts with 0, replace with 62
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }
        
        // If doesn't start with 62, add it
        if (substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }
        
        return $phone;
    }
}
