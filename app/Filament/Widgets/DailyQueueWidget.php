<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Schedule;
use Illuminate\Support\Carbon;

class DailyQueueWidget extends Widget
{
	protected static string $view = 'filament.widgets.daily-queue';

	protected static ?string $pollingInterval = '15s';

	public function getViewData(): array
	{
		$today = now()->toDateString();
        return [
            // Total antrian = hanya yang masih Terjadwal (belum selesai / batal / ditolak)
            'total' => Schedule::whereDate('tanggal_pemeriksaan', $today)->where('status', 'Terjadwal')->count(),
            'terjadwal' => Schedule::whereDate('tanggal_pemeriksaan', $today)->where('status', 'Terjadwal')->count(),
			'selesai' => Schedule::whereDate('tanggal_pemeriksaan', $today)->where('status', 'Selesai')->count(),
			'ditolak' => Schedule::whereDate('tanggal_pemeriksaan', $today)->where('status', 'Ditolak')->count(),
			'batal' => Schedule::whereDate('tanggal_pemeriksaan', $today)->where('status', 'Batal')->count(),
		];
	}
}
