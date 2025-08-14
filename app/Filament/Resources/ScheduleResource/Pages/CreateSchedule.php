<?php

namespace App\Filament\Resources\ScheduleResource\Pages;

use App\Filament\Resources\ScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Schedule;

class CreateSchedule extends CreateRecord
{
	protected static string $resource = ScheduleResource::class;

	protected function mutateFormDataBeforeCreate(array $data): array
	{
		if (!empty($data['tanggal_pemeriksaan'])) {
			$max = Schedule::whereDate('tanggal_pemeriksaan', $data['tanggal_pemeriksaan'])->max('queue_number');
			$data['queue_number'] = (int) $max + 1;
		}
		return $data;
	}
}
