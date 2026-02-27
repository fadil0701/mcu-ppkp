<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'participant_id',
        'nik_ktp',
        'nrk_pegawai',
        'nama_lengkap',
        'tanggal_lahir',
        'jenis_kelamin',
        'skpd',
        'ukpd',
        'no_telp',
        'email',
        'tanggal_pemeriksaan',
        'jam_pemeriksaan',
        'lokasi_pemeriksaan',
        'status',
        'queue_number',
        'participant_confirmed',
        'participant_confirmed_at',
        'reschedule_requested',
        'reschedule_new_date',
        'reschedule_new_time',
        'reschedule_reason',
        'reschedule_requested_at',
        'email_sent',
        'whatsapp_sent',
        'email_sent_at',
        'whatsapp_sent_at',
        'catatan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_pemeriksaan' => 'date',
        'jam_pemeriksaan' => 'datetime:H:i',
        'email_sent' => 'boolean',
        'whatsapp_sent' => 'boolean',
        'email_sent_at' => 'datetime',
        'whatsapp_sent_at' => 'datetime',
        'reschedule_requested' => 'boolean',
        'reschedule_new_date' => 'date',
        'reschedule_new_time' => 'datetime:H:i',
        'reschedule_requested_at' => 'datetime',
    ];

    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }

    public function mcuResult(): HasOne
    {
        return $this->hasOne(McuResult::class);
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'Terjadwal' => 'warning',
            'Selesai' => 'success',
            'Batal' => 'danger',
            default => 'secondary',
        };
    }

    public function getJenisKelaminTextAttribute(): string
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    public function getTanggalPemeriksaanFormattedAttribute(): string
    {
        return $this->tanggal_pemeriksaan->format('d/m/Y');
    }

    public function getJamPemeriksaanFormattedAttribute(): string
    {
        return $this->jam_pemeriksaan->format('H:i');
    }

    public function getDateTimePemeriksaanAttribute(): string
    {
        return $this->tanggal_pemeriksaan->format('d/m/Y') . ' ' . $this->jam_pemeriksaan->format('H:i');
    }

    public function isToday(): bool
    {
        return $this->tanggal_pemeriksaan->isToday();
    }

    public function isPast(): bool
    {
        return $this->tanggal_pemeriksaan->isPast();
    }

    public function isFuture(): bool
    {
        return $this->tanggal_pemeriksaan->isFuture();
    }

    /**
     * Hitung jumlah jadwal aktif (Terjadwal/Selesai) per tanggal & lokasi.
     * Untuk cek kuota sebelum assign nomor antrian.
     */
    public static function countForDateAndLocation($date, string $location, ?int $excludeScheduleId = null): int
    {
        $query = static::query()
            ->whereDate('tanggal_pemeriksaan', Carbon::parse($date)->format('Y-m-d'))
            ->where('lokasi_pemeriksaan', $location)
            ->whereIn('status', ['Terjadwal', 'Selesai']);

        if ($excludeScheduleId) {
            $query->where('id', '!=', $excludeScheduleId);
        }

        return $query->count();
    }

    /**
     * Generate nomor antrian berikutnya untuk tanggal & lokasi.
     * Nomor antrian mereset setiap hari per lokasi.
     * Hanya menghitung jadwal Terjadwal dan Selesai.
     */
    public static function getNextQueueNumber($date, string $location, ?int $excludeScheduleId = null): int
    {
        $max = static::query()
            ->whereDate('tanggal_pemeriksaan', Carbon::parse($date)->format('Y-m-d'))
            ->where('lokasi_pemeriksaan', $location)
            ->whereIn('status', ['Terjadwal', 'Selesai'])
            ->when($excludeScheduleId, fn ($q) => $q->where('id', '!=', $excludeScheduleId))
            ->max('queue_number');

        return ((int) $max) + 1;
    }

    /**
     * Cek apakah masih ada slot kuota tersedia untuk tanggal & lokasi.
     */
    public static function hasQuotaAvailable($date, string $location, ?int $excludeScheduleId = null): bool
    {
        $quota = config('mcu.quota_per_location_per_day');
        if ($quota === null || $quota <= 0) {
            return true;
        }
        $count = static::countForDateAndLocation($date, $location, $excludeScheduleId);
        return $count < $quota;
    }

    /**
     * Boot the model and clear cache on changes
     */
    protected static function booted(): void
    {
        static::saved(function () {
            cache()->forget('dashboard_stats');
            cache()->forget('skpd_stats');
        });

        static::deleted(function () {
            cache()->forget('dashboard_stats');
            cache()->forget('skpd_stats');
        });
    }
}
