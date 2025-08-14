<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Schedule;

class ConfirmRescheduleStatsWidget extends Widget
{
	protected static string $view = 'filament.widgets.confirm-reschedule-stats';

	protected static ?string $pollingInterval = '15s';

	public function getViewData(): array
	{
		$today = now()->toDateString();
		return [
			'confirmedToday' => Schedule::whereDate('tanggal_pemeriksaan', $today)->where('participant_confirmed', true)->count(),
			'pendingRescheduleToday' => Schedule::whereDate('reschedule_requested_at', $today)->where('reschedule_requested', true)->count(),
		];
	}
}
