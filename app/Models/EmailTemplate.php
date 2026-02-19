<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'subject',
        'body_html',
        'body_text',
        'variables',
        'is_active',
        'is_default',
        'description',
    ];

    protected $casts = [
        'variables' => 'array',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
    ];

    /**
     * Get the default template for a specific type
     */
    public static function getDefault($type)
    {
        return static::where('type', $type)
            ->where('is_default', true)
            ->where('is_active', true)
            ->first();
    }

    /**
     * Get all active templates for a specific type
     */
    public static function getByType($type)
    {
        return static::where('type', $type)
            ->where('is_active', true)
            ->orderBy('is_default', 'desc')
            ->orderBy('name')
            ->get();
    }

    /**
     * Set as default template
     */
    public function setAsDefault()
    {
        // Remove default from other templates of same type
        static::where('type', $this->type)
            ->where('id', '!=', $this->id)
            ->update(['is_default' => false]);

        // Set this template as default
        $this->update(['is_default' => true]);
    }

    /**
     * Get available variables for this template type
     */
    public function getAvailableVariables()
    {
        $defaultVariables = [
            'mcu_invitation' => [
                'participant_name' => 'Nama peserta',
                'participant_email' => 'Email peserta',
                'participant_phone' => 'Nomor telepon peserta',
                'examination_date' => 'Tanggal pemeriksaan',
                'examination_time' => 'Jam pemeriksaan',
                'examination_location' => 'Lokasi pemeriksaan',
                'queue_number' => 'Nomor antrian',
                'skpd' => 'SKPD',
                'ukpd' => 'UKPD',
                'app_name' => 'Nama aplikasi',
            ],
            'reminder' => [
                'participant_name' => 'Nama peserta',
                'examination_date' => 'Tanggal pemeriksaan',
                'examination_time' => 'Jam pemeriksaan',
                'examination_location' => 'Lokasi pemeriksaan',
                'app_name' => 'Nama aplikasi',
            ],
            'notification' => [
                'participant_name' => 'Nama peserta',
                'participant_email' => 'Email peserta',
                'participant_phone' => 'Nomor telepon peserta',
                'examination_date' => 'Tanggal pemeriksaan',
                'examination_time' => 'Jam pemeriksaan',
                'examination_location' => 'Lokasi pemeriksaan',
                'queue_number' => 'Nomor antrian',
                'skpd' => 'SKPD',
                'ukpd' => 'UKPD',
                'app_name' => 'Nama aplikasi',
            ],
            'custom' => [
                'participant_name' => 'Nama peserta',
                'participant_email' => 'Email peserta',
                'participant_phone' => 'Nomor telepon peserta',
                'examination_date' => 'Tanggal pemeriksaan',
                'examination_time' => 'Jam pemeriksaan',
                'examination_location' => 'Lokasi pemeriksaan',
                'queue_number' => 'Nomor antrian',
                'skpd' => 'SKPD',
                'ukpd' => 'UKPD',
                'app_name' => 'Nama aplikasi',
            ],
        ];

        return $defaultVariables[$this->type] ?? [];
    }

    /**
     * Get all available variables grouped by template type (for form variable tags).
     */
    public static function getVariablesByType(): array
    {
        $types = ['mcu_invitation', 'reminder', 'notification', 'custom'];
        $out = [];
        foreach ($types as $type) {
            $out[$type] = (new static(['type' => $type]))->getAvailableVariables();
        }
        return $out;
    }

    /**
     * Render template with data
     */
    public function render($data = [])
    {
        $subject = $this->subject;
        $bodyHtml = $this->body_html;
        $bodyText = $this->body_text;

        // Replace variables in subject and body
        foreach ($data as $key => $value) {
            $placeholder = '{' . $key . '}';
            $subject = str_replace($placeholder, $value, $subject);
            $bodyHtml = str_replace($placeholder, $value, $bodyHtml);
            $bodyText = str_replace($placeholder, $value, $bodyText);
        }

        return [
            'subject' => $subject,
            'body_html' => $bodyHtml,
            'body_text' => $bodyText,
        ];
    }
}
