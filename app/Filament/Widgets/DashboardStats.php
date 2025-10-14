<?php

namespace App\Filament\Widgets;

use App\Models\Participant;
use App\Models\Schedule;
use App\Models\McuResult;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class DashboardStats extends BaseWidget
{
    // Lazy load to improve initial page load
    protected static bool $isLazy = false; // Keep this one eager since it's important
    
    protected function getStats(): array
    {
        // Cache for 5 minutes to reduce database load
        $data = cache()->remember('dashboard_stats', 300, function () {
            $stats = DB::select("
                SELECT 
                    (SELECT COUNT(*) FROM participants) as total_participants,
                    (SELECT COUNT(*) FROM schedules WHERE status = 'Terjadwal') as scheduled_participants,
                    (SELECT COUNT(*) FROM mcu_results) as completed_mcu,
                    (SELECT COUNT(*) FROM schedules WHERE status = 'Terjadwal' AND tanggal_pemeriksaan >= CURDATE()) as pending_mcu
            ");
            return $stats[0];
        });

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
