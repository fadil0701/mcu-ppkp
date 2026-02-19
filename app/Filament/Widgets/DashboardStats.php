<?php

namespace App\Filament\Widgets;

use App\Models\Participant;
use App\Models\Schedule;
use App\Models\McuResult;
use App\Services\QueryOptimizationService;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class DashboardStats extends BaseWidget
{
    // Lazy load to improve initial page load
    protected static bool $isLazy = false; // Keep this one eager since it's important
    
    protected function getStats(): array
    {
        // Use optimized query service
        $data = QueryOptimizationService::getDashboardStats();

        return [
            Stat::make('Total Peserta', $data->total_participants)
                ->description('Semua peserta terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Peserta Terjadwal', $data->scheduled_participants)
                ->description('Peserta yang sudah dijadwalkan')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('warning'),

            Stat::make('MCU Selesai', $data->completed_mcu)
                ->description('Peserta yang sudah selesai MCU')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('MCU Pending', $data->pending_mcu)
                ->description('Peserta yang menunggu MCU')
                ->descriptionIcon('heroicon-m-clock')
                ->color('info'),
        ];
    }
}
