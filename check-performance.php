<?php

/**
 * Dashboard Performance Check Script
 * 
 * Run: php check-performance.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║        DASHBOARD PERFORMANCE CHECK - MCU PPKP              ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n";
echo "\n";

// 1. Check Database Indexes
echo "1️⃣  CHECKING DATABASE INDEXES...\n";
echo str_repeat("─", 60) . "\n";

$tables = ['participants', 'schedules', 'mcu_results'];
foreach ($tables as $table) {
    $indexes = DB::select("SHOW INDEX FROM {$table}");
    $indexCount = count($indexes);
    echo "   ✓ {$table}: {$indexCount} indexes\n";
}

echo "\n";

// 2. Check Query Performance
echo "2️⃣  MEASURING QUERY PERFORMANCE...\n";
echo str_repeat("─", 60) . "\n";

Cache::flush();

// Test 1: DashboardStats Query
$start = microtime(true);
DB::enableQueryLog();

$stats = DB::select("
    SELECT 
        (SELECT COUNT(*) FROM participants) as total_participants,
        (SELECT COUNT(*) FROM schedules WHERE status = 'Terjadwal') as scheduled_participants,
        (SELECT COUNT(*) FROM mcu_results) as completed_mcu,
        (SELECT COUNT(*) FROM schedules WHERE status = 'Terjadwal' AND tanggal_pemeriksaan >= CURDATE()) as pending_mcu
");

$queries1 = DB::getQueryLog();
$time1 = (microtime(true) - $start) * 1000;

echo "   ✓ DashboardStats: " . round($time1, 2) . "ms (1 query)\n";

// Test 2: SKPD Stats Query
DB::flushQueryLog();
$start = microtime(true);

$skpdStats = DB::select("
    SELECT 
        participants.skpd,
        COUNT(DISTINCT participants.id) as total,
        COUNT(DISTINCT schedules.id) as scheduled_count,
        COUNT(DISTINCT mcu_results.id) as completed_count
    FROM participants
    LEFT JOIN schedules ON participants.id = schedules.participant_id
    LEFT JOIN mcu_results ON participants.id = mcu_results.participant_id
    GROUP BY participants.skpd
    ORDER BY total DESC
    LIMIT 5
");

$queries2 = DB::getQueryLog();
$time2 = (microtime(true) - $start) * 1000;

echo "   ✓ SkpdStats: " . round($time2, 2) . "ms (1 query)\n";

// Test 3: Chart Data Query
DB::flushQueryLog();
$start = microtime(true);

$chartData = DB::select("
    SELECT DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count
    FROM participants
    WHERE created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
    GROUP BY month
    ORDER BY month
");

$queries3 = DB::getQueryLog();
$time3 = (microtime(true) - $start) * 1000;

echo "   ✓ McuChart: " . round($time3, 2) . "ms (1 query)\n";

$totalTime = $time1 + $time2 + $time3;
echo "\n   📊 Total Query Time: " . round($totalTime, 2) . "ms\n";

echo "\n";

// 3. Check Cache Performance
echo "3️⃣  TESTING CACHE PERFORMANCE...\n";
echo str_repeat("─", 60) . "\n";

// First load (no cache)
Cache::forget('test_performance');
$start = microtime(true);
$data = Cache::remember('test_performance', 60, function() {
    return DB::select("SELECT COUNT(*) as count FROM participants")[0];
});
$time1 = (microtime(true) - $start) * 1000;

// Second load (with cache)
$start = microtime(true);
$data = Cache::get('test_performance');
$time2 = (microtime(true) - $start) * 1000;

$improvement = round((($time1 - $time2) / $time1) * 100, 1);

echo "   ✓ First load (no cache): " . round($time1, 3) . "ms\n";
echo "   ✓ Second load (cached): " . round($time2, 3) . "ms\n";
echo "   📈 Speed improvement: {$improvement}%\n";

echo "\n";

// 4. Database Statistics
echo "4️⃣  DATABASE STATISTICS...\n";
echo str_repeat("─", 60) . "\n";

$participantCount = DB::table('participants')->count();
$scheduleCount = DB::table('schedules')->count();
$mcuResultCount = DB::table('mcu_results')->count();

echo "   • Participants: " . number_format($participantCount) . "\n";
echo "   • Schedules: " . number_format($scheduleCount) . "\n";
echo "   • MCU Results: " . number_format($mcuResultCount) . "\n";

echo "\n";

// 5. Performance Summary
echo "5️⃣  PERFORMANCE SUMMARY...\n";
echo str_repeat("─", 60) . "\n";

$avgQueryTime = round($totalTime / 3, 2);

if ($avgQueryTime < 50) {
    $status = "🟢 EXCELLENT";
    $recommendation = "Dashboard performance is optimal!";
} elseif ($avgQueryTime < 100) {
    $status = "🟡 GOOD";
    $recommendation = "Performance is good, consider more caching.";
} else {
    $status = "🔴 NEEDS OPTIMIZATION";
    $recommendation = "Consider adding more indexes or optimizing queries.";
}

echo "   Status: {$status}\n";
echo "   Average Query Time: {$avgQueryTime}ms\n";
echo "   Recommendation: {$recommendation}\n";

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║                  PERFORMANCE CHECK COMPLETE                ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n";
echo "\n";

echo "💡 Tips:\n";
echo "   • Clear cache: php artisan dashboard:clear-cache\n";
echo "   • View query log: Add DB::enableQueryLog() in your code\n";
echo "   • Monitor in production: Use Laravel Telescope\n";
echo "\n";

