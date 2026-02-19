<?php

namespace App\Filament\Pages;

use App\Models\Participant;
use App\Models\Schedule;
use App\Models\McuResult;
use App\Models\User;
use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\DashboardStats;
use App\Filament\Widgets\McuChart;
use App\Filament\Widgets\SkpdStats;
use App\Filament\Widgets\HealthStatusChart;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    public function getTitle(): string
    {
        return 'Dashboard MCU PPKP DKI Jakarta';
    }

    public function getWidgets(): array
    {
        return [
            // Critical widgets loaded first (non-lazy)
            DashboardStats::class,
            
            // All other widgets are lazy loaded for better performance
            McuChart::class,
            HealthStatusChart::class,
            SkpdStats::class,
            \App\Filament\Widgets\ConfirmedAttendanceTable::class,
            \App\Filament\Widgets\SystemHealthWidget::class,
        ];
    }

    public function getColumns(): int|array
    {
        return [
            'sm' => 1,
            'md' => 2,
            'lg' => 3,
            'xl' => 6,
        ];
    }
}
