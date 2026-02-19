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
        // Use optimized query service
        $topSkpds = \App\Services\QueryOptimizationService::getSkpdStats(5);

        $stats = [];
        
        foreach ($topSkpds as $skpd) {
            $stats[] = Stat::make($skpd->skpd, $skpd->total_participants)
                ->description("Scheduled: {$skpd->scheduled_count} | Completed: {$skpd->completed_count}")
                ->descriptionIcon('heroicon-m-building-office')
                ->color('info');
        }

        return $stats;
    }
}
