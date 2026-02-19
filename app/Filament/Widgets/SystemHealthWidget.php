<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SystemHealthWidget extends Widget
{
    protected static string $view = 'filament.widgets.system-health';
    
    protected static ?string $heading = 'System Health Monitor';
    
    protected int|string|array $columnSpan = 'full';
    
    // Refresh every 10 minutes - system health doesn't change frequently
    protected static ?string $pollingInterval = '10m';

    public function getViewData(): array
    {
        return [
            'database_status' => $this->checkDatabaseStatus(),
            'cache_status' => $this->checkCacheStatus(),
            'storage_status' => $this->checkStorageStatus(),
            'queue_status' => $this->checkQueueStatus(),
            'memory_usage' => $this->getMemoryUsage(),
            'disk_usage' => $this->getDiskUsage(),
            'last_errors' => $this->getLastErrors(),
        ];
    }

    private function checkDatabaseStatus(): array
    {
        try {
            $start = microtime(true);
            DB::select('SELECT 1');
            $responseTime = round((microtime(true) - $start) * 1000, 2);
            
            return [
                'status' => 'healthy',
                'response_time' => $responseTime . 'ms',
                'message' => 'Database connection successful'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'response_time' => null,
                'message' => 'Database connection failed: ' . $e->getMessage()
            ];
        }
    }

    private function checkCacheStatus(): array
    {
        try {
            $testKey = 'health_check_' . time();
            Cache::put($testKey, 'test', 60);
            $retrieved = Cache::get($testKey);
            Cache::forget($testKey);
            
            if ($retrieved === 'test') {
                return [
                    'status' => 'healthy',
                    'message' => 'Cache system working properly'
                ];
            } else {
                return [
                    'status' => 'warning',
                    'message' => 'Cache system not working properly'
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Cache system error: ' . $e->getMessage()
            ];
        }
    }

    private function checkStorageStatus(): array
    {
        try {
            $testFile = 'health_check_' . time() . '.txt';
            $testContent = 'Health check test';
            
            Storage::disk('public')->put($testFile, $testContent);
            $retrieved = Storage::disk('public')->get($testFile);
            Storage::disk('public')->delete($testFile);
            
            if ($retrieved === $testContent) {
                return [
                    'status' => 'healthy',
                    'message' => 'Storage system working properly'
                ];
            } else {
                return [
                    'status' => 'warning',
                    'message' => 'Storage system not working properly'
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Storage system error: ' . $e->getMessage()
            ];
        }
    }

    private function checkQueueStatus(): array
    {
        try {
            // Check if queue is configured
            $queueDriver = config('queue.default');
            
            if ($queueDriver === 'sync') {
                return [
                    'status' => 'warning',
                    'message' => 'Queue running in sync mode (not recommended for production)'
                ];
            }
            
            // Try to get queue size (if supported)
            $queueSize = 0;
            if (method_exists(app('queue'), 'size')) {
                $queueSize = app('queue')->size();
            }
            
            return [
                'status' => 'healthy',
                'message' => "Queue driver: {$queueDriver}, Pending jobs: {$queueSize}"
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Queue system error: ' . $e->getMessage()
            ];
        }
    }

    private function getMemoryUsage(): array
    {
        $memoryUsage = memory_get_usage(true);
        $memoryLimit = ini_get('memory_limit');
        
        // Convert memory limit to bytes
        $memoryLimitBytes = $this->convertToBytes($memoryLimit);
        $usagePercentage = round(($memoryUsage / $memoryLimitBytes) * 100, 2);
        
        $status = 'healthy';
        if ($usagePercentage > 80) {
            $status = 'warning';
        }
        if ($usagePercentage > 95) {
            $status = 'error';
        }
        
        return [
            'status' => $status,
            'usage' => $this->formatBytes($memoryUsage),
            'limit' => $memoryLimit,
            'percentage' => $usagePercentage
        ];
    }

    private function getDiskUsage(): array
    {
        $diskUsage = disk_free_space(storage_path());
        $diskTotal = disk_total_space(storage_path());
        $usagePercentage = round((($diskTotal - $diskUsage) / $diskTotal) * 100, 2);
        
        $status = 'healthy';
        if ($usagePercentage > 80) {
            $status = 'warning';
        }
        if ($usagePercentage > 95) {
            $status = 'error';
        }
        
        return [
            'status' => $status,
            'free' => $this->formatBytes($diskUsage),
            'total' => $this->formatBytes($diskTotal),
            'percentage' => $usagePercentage
        ];
    }

    private function getLastErrors(): array
    {
        try {
            $logFile = storage_path('logs/laravel.log');
            if (!file_exists($logFile)) {
                return [];
            }
            
            $lines = file($logFile);
            $errorLines = array_filter($lines, function($line) {
                return strpos($line, 'ERROR') !== false || strpos($line, 'CRITICAL') !== false;
            });
            
            // Get last 5 errors
            $lastErrors = array_slice($errorLines, -5);
            
            return array_map(function($line) {
                return trim($line);
            }, $lastErrors);
        } catch (\Exception $e) {
            return ['Error reading log file: ' . $e->getMessage()];
        }
    }

    private function convertToBytes(string $value): int
    {
        $value = trim($value);
        $last = strtolower($value[strlen($value) - 1]);
        $value = (int) $value;
        
        switch ($last) {
            case 'g':
                $value *= 1024;
            case 'm':
                $value *= 1024;
            case 'k':
                $value *= 1024;
        }
        
        return $value;
    }

    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= (1 << (10 * $pow));
        
        return round($bytes, 2) . ' ' . $units[$pow];
    }
}
