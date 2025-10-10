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
		$counts = Schedule::selectRaw("status, COUNT(*) as aggregate")
			->whereDate('tanggal_pemeriksaan', $today)
			->groupBy('status')
			->pluck('aggregate', 'status');

		$terjadwal = (int) ($counts['Terjadwal'] ?? 0);
		$selesai = (int) ($counts['Selesai'] ?? 0);
		$ditolak = (int) ($counts['Ditolak'] ?? 0);
		$batal = (int) ($counts['Batal'] ?? 0);

		return [
			// Total antrian = hanya yang masih Terjadwal (belum selesai / batal / ditolak)
			'total' => $terjadwal,
			'terjadwal' => $terjadwal,
			'selesai' => $selesai,
			'ditolak' => $ditolak,
			'batal' => $batal,
		];
	}
}
