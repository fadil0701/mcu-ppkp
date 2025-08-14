<?php

namespace App\Filament\Widgets;

use App\Models\Participant;
use App\Models\Schedule;
use App\Models\McuResult;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends BaseWidget
{
    protected function getStats(): array
    {
        $totalParticipants = Participant::count();
        $scheduledParticipants = Schedule::where('status', 'Terjadwal')->count();
        $completedMcu = McuResult::count();
        $pendingMcu = Schedule::where('status', 'Terjadwal')->where('tanggal_pemeriksaan', '>=', now()->toDateString())->count();

        return [
            Stat::make('Total Peserta', $totalParticipants)
                ->description('Semua peserta terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Peserta Terjadwal', $scheduledParticipants)
                ->description('Peserta yang sudah dijadwalkan')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('warning'),

            Stat::make('MCU Selesai', $completedMcu)
                ->description('Peserta yang sudah selesai MCU')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('MCU Pending', $pendingMcu)
                ->description('Peserta yang menunggu MCU')
                ->descriptionIcon('heroicon-m-clock')
                ->color('info'),
        ];
    }
}
