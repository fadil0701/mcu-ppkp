<?php

namespace App\Filament\Pages;

use App\Models\Schedule;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;

class RescheduleCenter extends Page implements Tables\Contracts\HasTable
{
	use Tables\Concerns\InteractsWithTable;

	protected static ?string $navigationIcon = 'heroicon-o-arrow-path';
	protected static ?string $navigationLabel = 'Permintaan Reschedule';
	protected static ?string $title = 'Permintaan Reschedule';
	protected static ?string $navigationGroup = 'MCU Management';
	protected static ?int $navigationSort = 3;
	protected static string $view = 'filament.pages.reschedule-center';

	public static function canAccess(): bool
	{
		return auth()->user()?->hasRole('super_admin') ?? false;
	}

	public function table(Table $table): Table
	{
		return $table
			->query(
				Schedule::query()->where('reschedule_requested', true)->latest('reschedule_requested_at')
			)
			->columns([
				TextColumn::make('participant.nama_lengkap')->label('Peserta')->searchable(),
				TextColumn::make('nik_ktp')->label('NIK')->toggleable(),
				TextColumn::make('tanggal_pemeriksaan')->label('Tgl Lama')->date('d/m/Y'),
				TextColumn::make('jam_pemeriksaan')->label('Jam Lama')->time('H:i'),
				TextColumn::make('reschedule_new_date')->label('Tgl Baru')->date('d/m/Y'),
				TextColumn::make('reschedule_new_time')->label('Jam Baru')->time('H:i'),
				TextColumn::make('reschedule_reason')->label('Alasan')->limit(40),
				BadgeColumn::make('status')->colors([
					'warning' => 'Terjadwal',
					'success' => 'Selesai',
					'danger' => 'Batal',
					'gray' => 'Ditolak',
				])->label('Status'),
			])
            ->filters([
                SelectFilter::make('skpd')
                    ->relationship('participant', 'skpd')
                    ->label('SKPD'),

                Filter::make('reschedule_requested_at')
                    ->form([
                        DatePicker::make('from')->label('Dari Tanggal'),
                        DatePicker::make('until')->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('reschedule_requested_at', '>=', $date),
                            )
                            ->when(
                                $data['until'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('reschedule_requested_at', '<=', $date),
                            );
                    })
                    ->label('Tanggal Permintaan'),
            ])
			->actions([
				Action::make('approve')
					->label('Setujui')
					->icon('heroicon-o-check-circle')
					->color('success')
					->requiresConfirmation()
					->action(function (Schedule $record) {
						$record->tanggal_pemeriksaan = $record->reschedule_new_date ?? $record->tanggal_pemeriksaan;
						$record->jam_pemeriksaan = $record->reschedule_new_time ?? $record->jam_pemeriksaan;
						$max = Schedule::whereDate('tanggal_pemeriksaan', $record->tanggal_pemeriksaan)->where('id', '!=', $record->id)->max('queue_number');
						$record->queue_number = ((int) $max) + 1;
						$record->reschedule_requested = false;
						$record->reschedule_new_date = null;
						$record->reschedule_new_time = null;
						$record->reschedule_reason = null;
						$record->reschedule_requested_at = null;
						$record->save();
					}),
				Action::make('reject')
					->label('Tolak')
					->icon('heroicon-o-x-circle')
					->color('danger')
					->requiresConfirmation()
					->action(function (Schedule $record) {
						$record->update([
							'reschedule_requested' => false,
							'reschedule_new_date' => null,
							'reschedule_new_time' => null,
							'reschedule_reason' => null,
							'reschedule_requested_at' => null,
						]);
					}),
			])
			->paginated([10, 25, 50]);
	}
}
