<?php

namespace App\Filament\Widgets;

use App\Models\Participant;
use App\Models\Schedule;
use App\Models\McuResult;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SkpdStats extends BaseWidget
{
    // Lazy load to improve initial page load
    protected static bool $isLazy = true;
    
    protected function getStats(): array
    {
        // Cache for 10 minutes
        $topSkpds = cache()->remember('skpd_stats', 600, function () {
            return Participant::selectRaw('
                    participants.skpd,
                    COUNT(DISTINCT participants.id) as total,
                    COUNT(DISTINCT schedules.id) as scheduled_count,
                    COUNT(DISTINCT mcu_results.id) as completed_count
                ')
                ->leftJoin('schedules', 'participants.id', '=', 'schedules.participant_id')
                ->leftJoin('mcu_results', 'participants.id', '=', 'mcu_results.participant_id')
                ->groupBy('participants.skpd')
                ->orderByDesc('total')
                ->limit(5)
                ->get();
        });

        $stats = [];
        
        foreach ($topSkpds as $skpd) {
            $stats[] = Stat::make($skpd->skpd, $skpd->total)
                ->description("Scheduled: {$skpd->scheduled_count} | Completed: {$skpd->completed_count}")
                ->descriptionIcon('heroicon-m-building-office')
                ->color('info');
        }

        return $stats;
    }
}
