<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Services\EncryptionService;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'encrypted_value',
        'is_encrypted',
        'type',
        'group',
        'description',
    ];

    // Sensitive keys that should be encrypted
    protected static $sensitiveKeys = [
        'smtp_password',
        'whatsapp_token',
        'whatsapp_instance_id',
    ];

    public static function getValue(string $key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }

        // Get the actual value (encrypted or plain)
        $value = $setting->is_encrypted ? $setting->encrypted_value : $setting->value;
        
        // Decrypt if needed
        if ($setting->is_encrypted && $value) {
            try {
                $value = EncryptionService::decrypt($value);
            } catch (\Exception $e) {
                \Log::error("Failed to decrypt setting {$key}: " . $e->getMessage());
                return $default;
            }
        }

        return match($setting->type) {
            'boolean' => (bool) $value,
            'json' => json_decode($value, true),
            'text' => $value,
            default => $value,
        };
    }

    public static function setValue(string $key, $value, string $type = 'string', string $group = 'general', string $description = null): void
    {
        $setting = static::where('key', $key)->first();
        
        if (!$setting) {
            $setting = new static();
            $setting->key = $key;
            $setting->type = $type;
            $setting->group = $group;
            $setting->description = $description;
        }

        $processedValue = match($type) {
            'boolean' => (string) $value,
            'json' => json_encode($value),
            default => (string) $value,
        };

        // Check if this key should be encrypted
        if (in_array($key, static::$sensitiveKeys)) {
            $setting->encrypted_value = EncryptionService::encrypt($processedValue);
            $setting->is_encrypted = true;
            $setting->value = null; // Clear plain text
        } else {
            $setting->value = $processedValue;
            $setting->is_encrypted = false;
            $setting->encrypted_value = null; // Clear encrypted value
        }

        $setting->save();
    }

    public static function getGroup(string $group): array
    {
        return static::where('group', $group)
            ->get()
            ->keyBy('key')
            ->map(function ($setting) {
                // Get the actual value (encrypted or plain)
                $value = $setting->is_encrypted ? $setting->encrypted_value : $setting->value;
                
                // Decrypt if needed
                if ($setting->is_encrypted && $value) {
                    try {
                        $value = EncryptionService::decrypt($value);
                    } catch (\Exception $e) {
                        \Log::error("Failed to decrypt setting {$setting->key}: " . $e->getMessage());
                        $value = '';
                    }
                }

                return match($setting->type) {
                    'boolean' => (bool) $value,
                    'json' => json_decode($value, true),
                    default => $value,
                };
            })
            ->toArray();
    }
}
