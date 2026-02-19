<?php

namespace App\Filament\Widgets;

use App\Models\Participant;
use App\Models\McuResult;
use App\Services\QueryOptimizationService;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class McuChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik MCU';
    
    // Lazy load to improve initial page load
    protected static bool $isLazy = true;

    protected function getData(): array
    {
        // Use optimized query service
        $chartData = QueryOptimizationService::getChartData(6);

        $participantsData = $chartData['participantsData'];
        $mcuResultsData = $chartData['mcuResultsData'];

        // Generate months and map data
        $months = collect();
        $participants = [];
        $mcuResults = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthKey = $date->format('Y-m');
            $monthLabel = $date->format('M Y');
            
            $months->push($monthLabel);
            $participants[] = $participantsData->get($monthKey, 0);
            $mcuResults[] = $mcuResultsData->get($monthKey, 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Peserta Baru',
                    'data' => $participants,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.25)',
                    'fill' => true,
                    'tension' => 0.35,
                    'pointRadius' => 2,
                    'borderWidth' => 2,
                ],
                [
                    'label' => 'Hasil MCU',
                    'data' => $mcuResults,
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.25)',
                    'fill' => true,
                    'tension' => 0.35,
                    'pointRadius' => 2,
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $months->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'interaction' => [
                'mode' => 'index',
                'intersect' => false,
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
                'tooltip' => [
                    'enabled' => true,
                ],
            ],
            'scales' => [
                'x' => [
                    'ticks' => [
                        'maxTicksLimit' => 6,
                    ],
                    'grid' => [ 'display' => false ],
                ],
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [ 'precision' => 0 ],
                    'grid' => [ 'color' => 'rgba(148,163,184,0.15)' ],
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
            'xl' => 3,
        ];
    }
}
