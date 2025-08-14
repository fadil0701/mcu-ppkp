<?php

namespace App\Filament\Widgets;

use App\Models\Participant;
use App\Models\McuResult;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class McuChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik MCU';

    protected function getData(): array
    {
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $months->push(Carbon::now()->subMonths($i)->format('M Y'));
        }

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

        return [
            'datasets' => [
                [
                    'label' => 'Peserta Baru',
                    'data' => $participantsData->toArray(),
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.25)',
                    'fill' => true,
                    'tension' => 0.35,
                    'pointRadius' => 2,
                    'borderWidth' => 2,
                ],
                [
                    'label' => 'Hasil MCU',
                    'data' => $mcuResultsData->toArray(),
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
