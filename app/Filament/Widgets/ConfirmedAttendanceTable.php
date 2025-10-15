<?php

namespace App\Filament\Widgets;

use App\Models\Schedule;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;

class ConfirmedAttendanceTable extends BaseWidget
{
    protected static ?string $heading = 'Konfirmasi Hadir - Siap Diselesaikan (Hari Ini)';

    // Increased polling interval to reduce server load
    protected static ?string $pollingInterval = '2m';

    protected int|string|array $columnSpan = 'full';
    
    // Lazy load this widget
    protected static bool $isLazy = true;

    protected function getTableQuery(): Builder
    {
        return Schedule::query()
            ->with('participant')
            ->whereDate('tanggal_pemeriksaan', now()->toDateString())
            ->where('status', 'Terjadwal')
            ->where('participant_confirmed', true)
            ->latest('jam_pemeriksaan');
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('participant.nama_lengkap')->label('Peserta')->searchable(),
            TextColumn::make('nik_ktp')->label('NIK')->toggleable(),
            TextColumn::make('tanggal_pemeriksaan')->label('Tanggal')->date('d/m/Y')->sortable(),
            TextColumn::make('jam_pemeriksaan')->label('Jam')->time('H:i')->sortable(),
            TextColumn::make('lokasi_pemeriksaan')->label('Lokasi')->limit(30),
            TextColumn::make('participant_confirmed_at')->label('Dikonfirmasi')->dateTime('d/m/Y H:i')->toggleable(isToggledHiddenByDefault: true),
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
                ->action(function (Schedule $record) {
                    $record->update([
                        'status' => 'Selesai',
                        'participant_confirmed' => false,
                        'participant_confirmed_at' => null,
                    ]);
                    
                    // Get current user name
                    $uploadedBy = \Illuminate\Support\Facades\Auth::user()?->name ?? 'system';
                    
                    // Ensure an MCU Result stub exists for this completed schedule
                    \App\Models\McuResult::firstOrCreate(
                        [
                            'schedule_id' => $record->id,
                        ],
                        [
                            'participant_id' => $record->participant_id,
                            'tanggal_pemeriksaan' => $record->tanggal_pemeriksaan,
                            'status_kesehatan' => 'Sehat',
                            'hasil_pemeriksaan' => '',
                            'uploaded_by' => $uploadedBy,
                            'is_published' => false, // Not visible to participant until results are inputted
                        ]
                    );
                }),
        ];
    }
}


