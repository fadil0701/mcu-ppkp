<?php

namespace App\Filament\Widgets;

use App\Models\Participant;
use App\Models\Schedule;
use App\Models\McuResult;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SkpdStats extends BaseWidget
{
    protected function getStats(): array
    {
        $topSkpds = Participant::selectRaw('skpd, COUNT(*) as total')
            ->groupBy('skpd')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $stats = [];
        
        foreach ($topSkpds as $skpd) {
            $scheduledCount = Schedule::whereHas('participant', function ($query) use ($skpd) {
                $query->where('skpd', $skpd->skpd);
            })->count();
            
            $completedCount = McuResult::whereHas('participant', function ($query) use ($skpd) {
                $query->where('skpd', $skpd->skpd);
            })->count();
            
            $stats[] = Stat::make($skpd->skpd, $skpd->total)
                ->description("Scheduled: {$scheduledCount} | Completed: {$completedCount}")
                ->descriptionIcon('heroicon-m-building-office')
                ->color('info');
        }

        return $stats;
    }
}
