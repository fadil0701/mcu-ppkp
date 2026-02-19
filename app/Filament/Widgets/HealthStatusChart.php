<?php

namespace App\Filament\Widgets;

use App\Models\McuResult;
use App\Services\QueryOptimizationService;
use Filament\Widgets\ChartWidget;

class HealthStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Distribusi Status Kesehatan';
    
    // Lazy load to improve initial page load
    protected static bool $isLazy = true;

    protected function getData(): array
    {
        // Use optimized query service
        $healthStats = QueryOptimizationService::getHealthStatusDistribution();
        
        $counts = [];
        foreach ($healthStats as $stat) {
            $counts[$stat->status_kesehatan] = $stat->count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Status Kesehatan',
                    'data' => array_values($counts),
                    'backgroundColor' => ['#86efac', '#fde68a', '#fca5a5'],
                ],
            ],
            'labels' => array_keys($counts),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
        ];
    }

    protected function getMaxHeight(): string
    {
        return '280px';
    }

    public function getColumnSpan(): int|array
    {
        return [
            'sm' => 2,
            'lg' => 3,
            'xl' => 2,
        ];
    }
}


