<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;

class DebugFonnteToken extends Command
{
    protected $signature = 'fonnte:debug';
    protected $description = 'Debug Fonnte token and show detailed response';

    public function handle()
    {
        $this->info('=== Fonnte Token Debug ===');
        $this->newLine();

        $token = Setting::getValue('whatsapp_token');
        
        if (empty($token)) {
            $this->error('Token is empty!');
            return 1;
        }
        
        $this->info('Token: ' . $token);
        $this->info('Token length: ' . strlen($token));
        $this->newLine();
        
        // Test 1: Check device status
        $this->info('Test 1: Checking device status...');
        try {
            $response = Http::withOptions(['verify' => false])
                ->withHeaders(['Authorization' => $token])
                ->post('https://api.fonnte.com/get-devices');
                
            $this->info('Status Code: ' . $response->status());
            $this->info('Response: ' . $response->body());
            $this->newLine();
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
        
        // Test 2: Send test message
        $this->info('Test 2: Sending test message...');
        $testPhone = $this->ask('Enter test phone number (e.g., 08123456789)');
        $testPhone = $this->cleanPhoneNumber($testPhone);
        
        try {
            $response = Http::withOptions(['verify' => false])
                ->withHeaders(['Authorization' => $token])
                ->post('https://api.fonnte.com/send', [
                    'target' => $testPhone,
                    'message' => 'Test message from MCU System at ' . now()->format('Y-m-d H:i:s'),
                    'countryCode' => '62',
                ]);
                
            $this->info('Status Code: ' . $response->status());
            $this->info('Headers: ' . json_encode($response->headers(), JSON_PRETTY_PRINT));
            $this->info('Response: ' . $response->body());
            
            $data = $response->json();
            if (isset($data['status'])) {
                if ($data['status'] === true) {
                    $this->info('✓ Success! Message sent!');
                } else {
                    $this->error('✗ Failed: ' . ($data['reason'] ?? 'Unknown reason'));
                    
                    // Show troubleshooting
                    $this->newLine();
                    $this->warn('=== Troubleshooting ===');
                    $this->line('Possible issues based on response:');
                    
                    $reason = $data['reason'] ?? '';
                    if (str_contains($reason, 'invalid token') || str_contains($reason, 'unknown token')) {
                        $this->line('1. Token salah atau expired - Cek token di https://fonnte.com');
                        $this->line('2. Device tidak terhubung - Scan QR code di dashboard Fonnte');
                        $this->line('3. Akun Fonnte belum aktif atau suspended');
                    } elseif (str_contains($reason, 'device')) {
                        $this->line('1. Device WhatsApp tidak connected');
                        $this->line('2. Scan ulang QR code di https://fonnte.com');
                    } elseif (str_contains($reason, 'balance') || str_contains($reason, 'quota')) {
                        $this->line('1. Saldo/kuota habis');
                        $this->line('2. Top up di https://fonnte.com');
                    }
                }
            }
            
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
        
        $this->newLine();
        $this->info('=== Langkah Selanjutnya ===');
        $this->line('1. Login ke https://fonnte.com');
        $this->line('2. Pastikan device WhatsApp tersambung (status: Connected)');
        $this->line('3. Jika tidak connected, scan ulang QR code');
        $this->line('4. Copy token yang benar dari dashboard');
        $this->line('5. Cek saldo/kuota mencukupi');
        
        return 0;
    }
    
    private function cleanPhoneNumber(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }
        if (substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }
        return $phone;
    }
}
