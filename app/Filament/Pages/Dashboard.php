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
            DashboardStats::class,
            McuChart::class,
            HealthStatusChart::class,
            SkpdStats::class,
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
