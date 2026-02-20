<?php

namespace Tests\Performance;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Services\QueryOptimizationService;

class DashboardPerformanceTest extends TestCase
{
    public function test_dashboard_query_count()
    {
        Cache::flush();
        DB::enableQueryLog();

        QueryOptimizationService::getDashboardStats();
        QueryOptimizationService::getSkpdStats(5);
        QueryOptimizationService::getChartData(6);
        QueryOptimizationService::getHealthStatusDistribution();

        $queries = DB::getQueryLog();
        $queryCount = count($queries);

        echo "\n=== DASHBOARD PERFORMANCE TEST ===\n";
        echo "Total Queries (without cache): {$queryCount}\n";
        echo "Expected: ~7-10 queries\n\n";

        $this->assertLessThan(15, $queryCount,
            "Query count should be less than 15 (actual: {$queryCount})"
        );
    }

    public function test_dashboard_with_cache()
    {
        QueryOptimizationService::getDashboardStats();

        DB::enableQueryLog();
        QueryOptimizationService::getDashboardStats();
        $queries = DB::getQueryLog();
        $queryCount = count($queries);

        echo "\n=== CACHE EFFECTIVENESS TEST ===\n";
        echo "Queries with cache: {$queryCount}\n";
        echo "Expected: 0 queries (cached)\n\n";

        $this->assertEquals(0, $queryCount,
            "Cached queries should be 0 (actual: {$queryCount})"
        );
    }

    public function test_query_execution_time()
    {
        Cache::flush();
        $start = microtime(true);

        QueryOptimizationService::getDashboardStats();

        $executionTime = (microtime(true) - $start) * 1000;

        echo "\n=== EXECUTION TIME TEST ===\n";
        echo "getDashboardStats execution: " . round($executionTime, 2) . "ms\n";
        echo "Expected: < 500ms\n\n";

        $this->assertLessThan(500, $executionTime,
            "Execution time should be less than 500ms (actual: " . round($executionTime, 2) . "ms)"
        );
    }
}
