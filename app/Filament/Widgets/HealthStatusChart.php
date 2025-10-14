<?php

namespace App\Filament\Widgets;

use App\Models\McuResult;
use Filament\Widgets\ChartWidget;

class HealthStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Distribusi Status Kesehatan';
    
    // Lazy load to improve initial page load
    protected static bool $isLazy = true;

    protected function getData(): array
    {
        // Cache for 10 minutes
        $counts = cache()->remember('health_status_chart', 600, function () {
            return [
                'Sehat' => McuResult::where('status_kesehatan', 'Sehat')->count(),
                'Kurang Sehat' => McuResult::where('status_kesehatan', 'Kurang Sehat')->count(),
                'Tidak Sehat' => McuResult::where('status_kesehatan', 'Tidak Sehat')->count(),
            ];
        });

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


