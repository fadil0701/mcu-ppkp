<?php

namespace App\Filament\Widgets;

use App\Models\Schedule;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class TodayQueueTable extends BaseWidget
{
	protected static ?string $heading = 'Antrian MCU Hari Ini';

    protected static ?string $pollingInterval = '2m'; // Reduce polling frequency

	protected int|string|array $columnSpan = 'full';

	protected function getTableQuery(): Builder
	{
        return Schedule::query()
            ->with(['participant:id,nama_lengkap,nik_ktp']) // Only load needed fields
            ->whereDate('tanggal_pemeriksaan', now()->toDateString())
            ->latest('jam_pemeriksaan')
            ->limit(50); // Limit results for better performance
	}

	protected function getTableColumns(): array
	{
		return [
			TextColumn::make('participant.nama_lengkap')->label('Peserta')->searchable(),
			TextColumn::make('nik_ktp')->label('NIK')->toggleable(),
			TextColumn::make('jam_pemeriksaan')->label('Jam')->time('H:i')->sortable(),
			TextColumn::make('lokasi_pemeriksaan')->label('Lokasi')->limit(30),
            TextColumn::make('queue_number')->label('No.')->badge()->sortable(),
			BadgeColumn::make('status')->colors([
				'warning' => 'Terjadwal',
				'success' => 'Selesai',
				'danger' => 'Batal',
				'gray' => 'Ditolak',
			])->label('Status'),
		];
	}

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\Action::make('set_done')
                ->label('Tandai Selesai')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn (Schedule $record): bool => $record->status !== 'Selesai')
                ->action(function (Schedule $record) {
                    $record->update(['status' => 'Selesai']);
                }),

            Tables\Actions\Action::make('reject')
                ->label('Tolak')
                ->icon('heroicon-o-x-circle')
                ->color('gray')
                ->requiresConfirmation()
                ->visible(fn (Schedule $record): bool => $record->status !== 'Ditolak')
                ->action(function (Schedule $record) {
                    $record->update(['status' => 'Ditolak']);
                }),

            Tables\Actions\Action::make('cancel')
                ->label('Batalkan')
                ->icon('heroicon-o-no-symbol')
                ->color('danger')
                ->requiresConfirmation()
                ->visible(fn (Schedule $record): bool => $record->status !== 'Batal')
                ->action(function (Schedule $record) {
                    $record->update(['status' => 'Batal']);
                }),
        ];
    }

    protected function getTableBulkActions(): array
    {
        return [
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\BulkAction::make('bulk_done')
                    ->label('Tandai Selesai (Bulk)')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (array $records) {
                        foreach ($records as $record) {
                            if ($record instanceof Schedule) {
                                $record->update(['status' => 'Selesai']);
                            }
                        }
                    }),
                Tables\Actions\BulkAction::make('bulk_reject')
                    ->label('Tolak (Bulk)')
                    ->icon('heroicon-o-x-circle')
                    ->color('gray')
                    ->requiresConfirmation()
                    ->action(function (array $records) {
                        foreach ($records as $record) {
                            if ($record instanceof Schedule) {
                                $record->update(['status' => 'Ditolak']);
                            }
                        }
                    }),
                Tables\Actions\BulkAction::make('bulk_cancel')
                    ->label('Batalkan (Bulk)')
                    ->icon('heroicon-o-no-symbol')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (array $records) {
                        foreach ($records as $record) {
                            if ($record instanceof Schedule) {
                                $record->update(['status' => 'Batal']);
                            }
                        }
                    }),
            ]),
        ];
    }
}
