<?php

namespace Tests\Performance;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Filament\Widgets\DashboardStats;
use App\Filament\Widgets\McuChart;
use App\Filament\Widgets\SkpdStats;
use App\Filament\Widgets\HealthStatusChart;

class DashboardPerformanceTest extends TestCase
{
    public function test_dashboard_query_count()
    {
        // Clear cache to measure real query count
        Cache::flush();
        
        DB::enableQueryLog();
        
        // Simulate dashboard loading
        $dashboardStats = new DashboardStats();
        $mcuChart = new McuChart();
        $skpdStats = new SkpdStats();
        $healthChart = new HealthStatusChart();
        
        // Get data from widgets (using reflection to access protected methods)
        $this->invokeMethod($dashboardStats, 'getStats');
        $this->invokeMethod($mcuChart, 'getData');
        $this->invokeMethod($skpdStats, 'getStats');
        $this->invokeMethod($healthChart, 'getData');
        
        $queries = DB::getQueryLog();
        $queryCount = count($queries);
        
        echo "\n";
        echo "=== DASHBOARD PERFORMANCE TEST ===\n";
        echo "Total Queries (without cache): {$queryCount}\n";
        echo "Expected: ~7-10 queries\n";
        echo "\n";
        
        // Should be significantly less than before (was ~20+)
        $this->assertLessThan(15, $queryCount, 
            "Query count should be less than 15 (actual: {$queryCount})"
        );
    }
    
    public function test_dashboard_with_cache()
    {
        // First load (populate cache)
        $dashboardStats = new DashboardStats();
        $this->invokeMethod($dashboardStats, 'getStats');
        
        // Second load (should use cache)
        DB::enableQueryLog();
        
        $dashboardStats2 = new DashboardStats();
        $this->invokeMethod($dashboardStats2, 'getStats');
        
        $queries = DB::getQueryLog();
        $queryCount = count($queries);
        
        echo "\n";
        echo "=== CACHE EFFECTIVENESS TEST ===\n";
        echo "Queries with cache: {$queryCount}\n";
        echo "Expected: 0 queries (cached)\n";
        echo "\n";
        
        // Should be 0 because data is cached
        $this->assertEquals(0, $queryCount, 
            "Cached queries should be 0 (actual: {$queryCount})"
        );
    }
    
    public function test_query_execution_time()
    {
        Cache::flush();
        
        $start = microtime(true);
        
        $dashboardStats = new DashboardStats();
        $this->invokeMethod($dashboardStats, 'getStats');
        
        $executionTime = (microtime(true) - $start) * 1000; // Convert to ms
        
        echo "\n";
        echo "=== EXECUTION TIME TEST ===\n";
        echo "DashboardStats execution: " . round($executionTime, 2) . "ms\n";
        echo "Expected: < 100ms\n";
        echo "\n";
        
        // Should be fast (less than 100ms)
        $this->assertLessThan(100, $executionTime,
            "Execution time should be less than 100ms (actual: " . round($executionTime, 2) . "ms)"
        );
    }
    
    /**
     * Helper method to invoke protected methods
     */
    protected function invokeMethod(&$object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        
        return $method->invokeArgs($object, $parameters);
    }
}

