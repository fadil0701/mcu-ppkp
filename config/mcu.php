<?php

return [
    /*
    |--------------------------------------------------------------------------
    | MCU System Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi untuk sistem monitoring Medical Check Up
    |
    */

    // Interval MCU dalam tahun
    'interval_years' => env('MCU_INTERVAL_YEARS', 3),

    // Lokasi klinik permanen untuk jadwal MCU
    'default_location' => env('MCU_DEFAULT_LOCATION', 'Klinik Utama Balaikota'),

    // Status pegawai yang diizinkan
    'allowed_employee_status' => [
        'CPNS',
        'PNS', 
        'PPPK',
    ],

    // File upload settings
    'file' => [
        'max_size' => env('MCU_MAX_FILE_SIZE', 10240), // KB
        'allowed_types' => explode(',', env('MCU_ALLOWED_FILE_TYPES', 'pdf,doc,docx,jpg,jpeg,png')),
        'storage_path' => 'mcu-results',
    ],

    // Email settings
    'email' => [
        'from_name' => env('MAIL_FROM_NAME', 'Sistem MCU'),
        'from_address' => env('MAIL_FROM_ADDRESS', 'noreply@mcu.local'),
    ],

    // WhatsApp settings
    'whatsapp' => [
        'api_token' => env('WHATSAPP_API_TOKEN'),
        'instance_id' => env('WHATSAPP_INSTANCE_ID'),
        'phone_number' => env('WHATSAPP_PHONE_NUMBER'),
    ],

    // Kuota per lokasi per hari (null = tidak dibatasi)
    'quota_per_location_per_day' => env('MCU_QUOTA_PER_LOCATION_PER_DAY') ? (int) env('MCU_QUOTA_PER_LOCATION_PER_DAY') : null,

    // Pagination
    'pagination' => [
        'per_page' => 15,
    ],

    // Dashboard settings
    'dashboard' => [
        'stats_refresh_interval' => 300, // seconds
        'chart_months' => 6,
    ],

    // Notification settings
    'notifications' => [
        'email_enabled' => true,
        'whatsapp_enabled' => true,
        'reminder_days_before' => [7, 3, 1], // days before MCU
    ],
];
