<?php

namespace App\Filament\Widgets;

use Filament\Widgets\LineChartWidget;
use App\Models\Schedule;

class DailyQueueChart extends LineChartWidget
{
	protected static ?string $heading = 'Grafik Antrian Hari Ini (per Jam)';

	protected static ?string $pollingInterval = '30s';

	protected function getData(): array
	{
		$today = now()->toDateString();
		$hours = range(0, 23);
		$labels = array_map(fn($h) => sprintf('%02d:00', $h), $hours);

        $counts = function (string $status) use ($today, $hours) {
			$map = array_fill_keys($hours, 0);
			Schedule::whereDate('tanggal_pemeriksaan', $today)
				->when($status !== 'ALL', fn($q) => $q->where('status', $status))
				->get()
				->each(function ($s) use (&$map) {
					$h = (int) optional($s->jam_pemeriksaan)->format('H');
					$map[$h]++;
				});
			return array_values($map);
		};

		return [
			'labels' => $labels,
			'datasets' => [
                [
                    'label' => 'Antrian (Aktif)',
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.2)',
                    'data' => $counts('Terjadwal'),
                ],
				[
					'label' => 'Selesai',
					'borderColor' => '#10b981',
					'backgroundColor' => 'rgba(16, 185, 129, 0.2)',
					'data' => $counts('Selesai'),
				],
				[
					'label' => 'Batal',
					'borderColor' => '#ef4444',
					'backgroundColor' => 'rgba(239, 68, 68, 0.2)',
					'data' => $counts('Batal'),
				],
				[
					'label' => 'Ditolak',
					'borderColor' => '#6b7280',
					'backgroundColor' => 'rgba(107, 114, 128, 0.2)',
					'data' => $counts('Ditolak'),
				],
			],
		];
	}
}
