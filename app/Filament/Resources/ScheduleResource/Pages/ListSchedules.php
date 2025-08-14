<?php

namespace App\Filament\Resources\ScheduleResource\Pages;

use App\Filament\Resources\ScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;

class ListSchedules extends ListRecords
{
	protected static string $resource = ScheduleResource::class;

	protected function getHeaderActions(): array
	{
		return [
			Actions\CreateAction::make(),
		];
	}

	protected function getTableFilters(): array
	{
		return [
			Tables\Filters\Filter::make('reschedule_requested')
				->label('Reschedule Requested')
				->query(fn($q) => $q->where('reschedule_requested', true)),
		];
	}
}
