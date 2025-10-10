<?php

namespace App\Filament\Resources\ScheduleResource\Pages;

use App\Filament\Resources\ScheduleResource;
use App\Models\Schedule;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;

class RescheduleRequests extends ListRecords
{
	protected static string $resource = ScheduleResource::class;

	protected static ?string $title = 'Permintaan Reschedule';

	protected function getHeaderActions(): array
	{
		return [];
	}

	protected function getTableQuery(): Builder
	{
		return parent::getTableQuery()->where('reschedule_requested', true);
	}

	protected function getTableActions(): array
	{
		return [
			Action::make('approve')
				->label('Setujui Reschedule')
				->icon('heroicon-o-check-circle')
				->color('success')
				->requiresConfirmation()
				->action(function (Schedule $record) {
					// Apply requested date/time
					$record->tanggal_pemeriksaan = $record->reschedule_new_date ?? $record->tanggal_pemeriksaan;
					$record->jam_pemeriksaan = $record->reschedule_new_time ?? $record->jam_pemeriksaan;
					// Reassign queue number for new date
					$max = Schedule::whereDate('tanggal_pemeriksaan', $record->tanggal_pemeriksaan)->where('id', '!=', $record->id)->max('queue_number');
					$record->queue_number = ((int) $max) + 1;
					// Clear reschedule flags
					$record->reschedule_requested = false;
					$record->reschedule_new_date = null;
					$record->reschedule_new_time = null;
					$record->reschedule_reason = null;
					$record->reschedule_requested_at = null;
					$record->save();
				})
				->visible(fn (Schedule $record): bool => (bool) $record->reschedule_requested),

			Action::make('reject')
				->label('Tolak Reschedule')
				->icon('heroicon-o-x-circle')
				->color('danger')
				->requiresConfirmation()
				->form([
					Forms\Components\Textarea::make('note')->label('Catatan (opsional)')->rows(3),
				])
				->action(function (Schedule $record, array $data) {
					// Clear reschedule flags only
					$record->update([
						'reschedule_requested' => false,
						'reschedule_new_date' => null,
						'reschedule_new_time' => null,
						'reschedule_reason' => null,
						'reschedule_requested_at' => null,
					]);
				})
				->visible(fn (Schedule $record): bool => (bool) $record->reschedule_requested),
		];
	}
}
