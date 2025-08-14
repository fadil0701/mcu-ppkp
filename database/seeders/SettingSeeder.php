<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // SMTP Settings
        Setting::setValue('smtp_host', 'smtp.gmail.com', 'string', 'smtp', 'SMTP Host');
        Setting::setValue('smtp_port', '587', 'string', 'smtp', 'SMTP Port');
        Setting::setValue('smtp_username', '', 'string', 'smtp', 'SMTP Username');
        Setting::setValue('smtp_password', '', 'string', 'smtp', 'SMTP Password');
        Setting::setValue('smtp_encryption', 'tls', 'string', 'smtp', 'SMTP Encryption');
        Setting::setValue('smtp_from_address', 'noreply@mcu.local', 'string', 'smtp', 'SMTP From Address');
        Setting::setValue('smtp_from_name', 'Sistem MCU', 'string', 'smtp', 'SMTP From Name');

        // WhatsApp Settings
        Setting::setValue('whatsapp_token', '', 'string', 'whatsapp', 'WhatsApp API Token');
        Setting::setValue('whatsapp_instance_id', '', 'string', 'whatsapp', 'WhatsApp Instance ID');
        Setting::setValue('whatsapp_phone_number', '', 'string', 'whatsapp', 'WhatsApp Phone Number');

        // Email Templates
        Setting::setValue('email_invitation_subject', 'Undangan Medical Check Up', 'string', 'email_template', 'Subject Email Undangan');
        Setting::setValue('email_invitation_template', 'Kepada {nama_lengkap}, Anda diundang untuk mengikuti Medical Check Up pada tanggal {tanggal_pemeriksaan} pukul {jam_pemeriksaan} di {lokasi_pemeriksaan}.', 'text', 'email_template', 'Template Email Undangan');

        // WhatsApp Templates
        Setting::setValue('whatsapp_invitation_template', 'Halo {nama_lengkap}, Anda diundang untuk mengikuti Medical Check Up pada tanggal {tanggal_pemeriksaan} pukul {jam_pemeriksaan} di {lokasi_pemeriksaan}.', 'text', 'whatsapp_template', 'Template WhatsApp Undangan');

        // General Settings
        Setting::setValue('app_name', 'Sistem Monitoring MCU', 'string', 'general', 'Nama Aplikasi');
        Setting::setValue('app_description', 'Sistem Monitoring Medical Check Up', 'string', 'general', 'Deskripsi Aplikasi');
        Setting::setValue('mcu_interval_years', '3', 'string', 'general', 'Interval MCU (Tahun)');
    }
}
