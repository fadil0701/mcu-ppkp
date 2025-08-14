<?php

namespace App\Filament\Resources\ScheduleResource\Pages;

use App\Filament\Resources\ScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\Schedule;

class EditSchedule extends EditRecord
{
	protected static string $resource = ScheduleResource::class;

	protected function getHeaderActions(): array
	{
		return [
			Actions\DeleteAction::make(),
		];
	}

	protected function mutateFormDataBeforeSave(array $data): array
	{
		if (empty($data['queue_number']) && !empty($data['tanggal_pemeriksaan'])) {
			$max = Schedule::whereDate('tanggal_pemeriksaan', $data['tanggal_pemeriksaan'])->where('id', '!=', $this->record->id)->max('queue_number');
			$data['queue_number'] = (int) $max + 1;
		}
		return $data;
	}
}
