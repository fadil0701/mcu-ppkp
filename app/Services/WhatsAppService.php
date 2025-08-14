<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\Schedule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    public function sendMcuInvitation(Schedule $schedule): bool
    {
        try {
            // Get WhatsApp settings
            $whatsappSettings = Setting::getGroup('whatsapp');
            
            $token = $whatsappSettings['whatsapp_token'] ?? '';
            $instanceId = $whatsappSettings['whatsapp_instance_id'] ?? '';
            
            if (empty($token) || empty($instanceId)) {
                Log::error('WhatsApp settings not configured');
                return false;
            }

            // Get WhatsApp template
            $template = Setting::getValue('whatsapp_invitation_template', 'Halo {nama_lengkap}, Anda diundang untuk mengikuti Medical Check Up pada tanggal {tanggal_pemeriksaan} pukul {jam_pemeriksaan} di {lokasi_pemeriksaan}.');

            // Replace placeholders
            $message = str_replace([
                '{nama_lengkap}',
                '{tanggal_pemeriksaan}',
                '{jam_pemeriksaan}',
                '{lokasi_pemeriksaan}',
            ], [
                $schedule->nama_lengkap,
                $schedule->tanggal_pemeriksaan->format('d/m/Y'),
                $schedule->jam_pemeriksaan->format('H:i'),
                $schedule->lokasi_pemeriksaan,
            ], $template);

            // Clean phone number
            $phoneNumber = $this->cleanPhoneNumber($schedule->no_telp);

            // Send WhatsApp message
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post("https://api.whatsapp.com/v1/{$instanceId}/messages", [
                'messaging_product' => 'whatsapp',
                'to' => $phoneNumber,
                'type' => 'text',
                'text' => [
                    'body' => $message,
                ],
            ]);

            if ($response->successful()) {
                // Update schedule
                $schedule->update([
                    'whatsapp_sent' => true,
                    'whatsapp_sent_at' => now(),
                ]);

                return true;
            } else {
                Log::error('WhatsApp API error: ' . $response->body());
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Failed to send WhatsApp invitation: ' . $e->getMessage());
            return false;
        }
    }

    public function sendBulkMcuInvitations(array $scheduleIds): array
    {
        $results = [
            'success' => 0,
            'failed' => 0,
            'errors' => [],
        ];

        foreach ($scheduleIds as $scheduleId) {
            $schedule = Schedule::find($scheduleId);
            if ($schedule) {
                if ($this->sendMcuInvitation($schedule)) {
                    $results['success']++;
                } else {
                    $results['failed']++;
                    $results['errors'][] = "Failed to send WhatsApp to {$schedule->nama_lengkap} ({$schedule->no_telp})";
                }
            }
        }

        return $results;
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
