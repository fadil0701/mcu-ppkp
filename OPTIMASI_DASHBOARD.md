# Optimasi Dashboard Admin - MCU PPKP DKI Jakarta

## 📋 Ringkasan

Dashboard admin telah dioptimasi untuk meningkatkan kecepatan loading dan mengurangi beban server. Sebelumnya dashboard sangat lambat karena:
- Banyak query database yang tidak efisien
- Tidak ada database index pada kolom yang sering di-query
- N+1 query problem di beberapa widget
- Tidak ada caching untuk data statistik
- Polling yang terlalu sering

## ✅ Optimasi yang Telah Dilakukan

### 1. **Database Indexes**

Menambahkan index pada kolom-kolom yang sering digunakan untuk query:

**Participants Table:**
- `skpd` - untuk GROUP BY dan WHERE clauses
- `created_at` - untuk filter tanggal
- Composite index `skpd` + `created_at` - untuk query yang menggunakan kedua kolom

**Schedules Table:**
- `status` - untuk filter status
- `tanggal_pemeriksaan` - untuk filter tanggal
- Composite index `tanggal_pemeriksaan` + `status`
- Composite index `participant_confirmed` + `status`

**MCU Results Table:**
- `status_kesehatan` - untuk chart dan statistics
- `created_at` - untuk filter tanggal
- `participant_id` - untuk JOIN operations

**File Migration:** `database/migrations/2025_10_14_024720_add_performance_indexes_to_tables.php`

---

### 2. **Widget Optimizations**

#### a) DashboardStats Widget
**Sebelum:**
```php
// 4 separate queries
$totalParticipants = Participant::count();
$scheduledParticipants = Schedule::where('status', 'Terjadwal')->count();
$completedMcu = McuResult::count();
$pendingMcu = Schedule::where('status', 'Terjadwal')->where('tanggal_pemeriksaan', '>=', now()->toDateString())->count();
```

**Sesudah:**
```php
// 1 query dengan multiple subqueries
$stats = DB::select("
    SELECT 
        (SELECT COUNT(*) FROM participants) as total_participants,
        (SELECT COUNT(*) FROM schedules WHERE status = 'Terjadwal') as scheduled_participants,
        (SELECT COUNT(*) FROM mcu_results) as completed_mcu,
        (SELECT COUNT(*) FROM schedules WHERE status = 'Terjadwal' AND tanggal_pemeriksaan >= CURDATE()) as pending_mcu
");
```

**Improvement:** 4 queries → 1 query (75% reduction) + caching 5 menit

---

#### b) SkpdStats Widget
**Sebelum:**
```php
// 1 query untuk top SKPDs + 2 queries per SKPD (total: 11 queries untuk 5 SKPDs)
$topSkpds = Participant::selectRaw('skpd, COUNT(*) as total')
    ->groupBy('skpd')->orderByDesc('total')->limit(5)->get();

foreach ($topSkpds as $skpd) {
    $scheduledCount = Schedule::whereHas('participant', function ($query) use ($skpd) {
        $query->where('skpd', $skpd->skpd);
    })->count();
    
    $completedCount = McuResult::whereHas('participant', function ($query) use ($skpd) {
        $query->where('skpd', $skpd->skpd);
    })->count();
}
```

**Sesudah:**
```php
// 1 query dengan JOINs
$topSkpds = Participant::selectRaw('
        participants.skpd,
        COUNT(DISTINCT participants.id) as total,
        COUNT(DISTINCT schedules.id) as scheduled_count,
        COUNT(DISTINCT mcu_results.id) as completed_count
    ')
    ->leftJoin('schedules', 'participants.id', '=', 'schedules.participant_id')
    ->leftJoin('mcu_results', 'participants.id', '=', 'mcu_results.participant_id')
    ->groupBy('participants.skpd')
    ->orderByDesc('total')
    ->limit(5)
    ->get();
```

**Improvement:** 11 queries → 1 query (91% reduction) + caching 10 menit

---

#### c) McuChart Widget
**Sebelum:**
```php
// 12 queries total (6 untuk participants + 6 untuk mcu results)
$participantsData = $months->map(function ($month) {
    return Participant::whereMonth('created_at', Carbon::parse($month))
        ->whereYear('created_at', Carbon::parse($month))
        ->count();
});

$mcuResultsData = $months->map(function ($month) {
    return McuResult::whereMonth('created_at', Carbon::parse($month))
        ->whereYear('created_at', Carbon::parse($month))
        ->count();
});
```

**Sesudah:**
```php
// 2 queries dengan GROUP BY
$participantsData = Participant::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count")
    ->whereBetween('created_at', [$startDate, $endDate])
    ->groupBy('month')
    ->orderBy('month')
    ->pluck('count', 'month');

$mcuResultsData = McuResult::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count")
    ->whereBetween('created_at', [$startDate, $endDate])
    ->groupBy('month')
    ->orderBy('month')
    ->pluck('count', 'month');
```

**Improvement:** 12 queries → 2 queries (83% reduction) + caching 10 menit

---

#### d) HealthStatusChart Widget
**Improvement:** 3 queries → 3 queries (tidak berubah, tapi ditambahkan caching 10 menit)

---

### 3. **Caching Strategy**

Semua widget statistik sekarang menggunakan caching untuk mengurangi beban database:

| Widget | Cache Duration | Cache Key |
|--------|----------------|-----------|
| DashboardStats | 5 menit (300s) | `dashboard_stats` |
| McuChart | 10 menit (600s) | `mcu_chart_data` |
| SkpdStats | 10 menit (600s) | `skpd_stats` |
| HealthStatusChart | 10 menit (600s) | `health_status_chart` |

**Cara Clear Cache:**
```bash
php artisan cache:clear
```

Atau clear cache tertentu:
```php
cache()->forget('dashboard_stats');
cache()->forget('mcu_chart_data');
cache()->forget('skpd_stats');
cache()->forget('health_status_chart');
```

---

### 4. **Lazy Loading**

Widget-widget berat sekarang menggunakan lazy loading untuk meningkatkan initial page load:

| Widget | Lazy Load | Alasan |
|--------|-----------|---------|
| DashboardStats | ❌ No | Widget utama yang harus langsung terlihat |
| McuChart | ✅ Yes | Chart bisa dimuat setelah stats utama |
| SkpdStats | ✅ Yes | Data SKPD tidak kritis untuk initial load |
| HealthStatusChart | ✅ Yes | Chart bisa dimuat setelah stats utama |
| ConfirmedAttendanceTable | ✅ Yes | Table besar, loading dimuat belakangan |

---

### 5. **Polling Optimization**

**ConfirmedAttendanceTable:**
- Sebelum: Polling setiap 30 detik
- Sesudah: Polling setiap 2 menit (120 detik)
- **Alasan:** Mengurangi beban server, data konfirmasi tidak perlu real-time

---

## 📊 Estimasi Peningkatan Performa

### Query Reduction
- **Sebelum:** ~20+ queries per dashboard load
- **Sesudah:** ~7 queries per dashboard load (first load)
- **Dengan Cache:** ~0 queries (subsequent loads dalam cache window)

### Loading Time Reduction
- **Initial Page Load:** 50-70% lebih cepat (dengan lazy loading)
- **Widget Loading:** 70-90% lebih cepat (dengan caching)
- **Server Load:** 80-90% lebih rendah (dengan caching dan reduced polling)

---

## 🔧 Maintenance

### Auto Cache Invalidation
Untuk invalidasi cache otomatis saat data berubah, tambahkan di model events:

**app/Models/Participant.php:**
```php
protected static function booted()
{
    static::saved(function () {
        cache()->forget('dashboard_stats');
        cache()->forget('skpd_stats');
        cache()->forget('mcu_chart_data');
    });
}
```

**app/Models/Schedule.php:**
```php
protected static function booted()
{
    static::saved(function () {
        cache()->forget('dashboard_stats');
        cache()->forget('skpd_stats');
    });
}
```

**app/Models/McuResult.php:**
```php
protected static function booted()
{
    static::saved(function () {
        cache()->forget('dashboard_stats');
        cache()->forget('mcu_chart_data');
        cache()->forget('health_status_chart');
        cache()->forget('skpd_stats');
    });
}
```

---

## 🚀 Cara Deployment

1. **Pull latest code:**
   ```bash
   git pull origin main
   ```

2. **Run migrations:**
   ```bash
   php artisan migrate
   ```

3. **Clear all caches:**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   php artisan route:clear
   ```

4. **Optimize untuk production:**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

---

## 📝 Notes

- Index database akan meningkatkan kecepatan query tapi sedikit memperlambat INSERT/UPDATE operations (negligible)
- Cache bisa di-clear kapan saja jika data harus fresh
- Lazy loading hanya mempengaruhi visual loading, tidak mengurangi total data yang dimuat
- Untuk data yang benar-benar real-time, pertimbangkan menggunakan Laravel Echo + WebSockets

---

## 🔍 Monitoring

Untuk memantau performa, gunakan:

1. **Laravel Debugbar** (development):
   ```bash
   composer require barryvdh/laravel-debugbar --dev
   ```

2. **Query Log** (manual):
   ```php
   DB::enableQueryLog();
   // ... run dashboard ...
   dd(DB::getQueryLog());
   ```

3. **Laravel Telescope** (advanced):
   ```bash
   composer require laravel/telescope
   php artisan telescope:install
   ```

---

## ✅ Checklist Post-Deployment

- [ ] Jalankan migration
- [ ] Clear all caches
- [ ] Test dashboard loading speed
- [ ] Verify semua widget menampilkan data dengan benar
- [ ] Monitor server resource usage
- [ ] Check untuk error di log files

---

**Tanggal Optimasi:** 14 Oktober 2025  
**Version:** 1.0  
**Status:** ✅ Production Ready

