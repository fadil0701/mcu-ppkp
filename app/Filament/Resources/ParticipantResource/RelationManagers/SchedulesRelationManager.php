<?php

namespace App\Filament\Resources\ParticipantResource\RelationManagers;

use App\Models\Schedule;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class SchedulesRelationManager extends RelationManager
{
	protected static string $relationship = 'schedules';

	public function table(Table $table): Table
	{
		return $table
			->columns([
				Tables\Columns\TextColumn::make('tanggal_pemeriksaan')->label('Tanggal')->date('d/m/Y')->sortable(),
				Tables\Columns\TextColumn::make('jam_pemeriksaan')->label('Jam')->time('H:i')->sortable(),
				Tables\Columns\TextColumn::make('lokasi_pemeriksaan')->label('Lokasi')->limit(30),
				Tables\Columns\BadgeColumn::make('status')->label('Status')->colors([
					'warning' => 'Terjadwal',
					'success' => 'Selesai',
					'danger' => 'Batal',
				]),
				Tables\Columns\TextColumn::make('created_at')->label('Dibuat')->dateTime('d/m/Y H:i')->toggleable(isToggledHiddenByDefault: true),
			])
			->headerActions([])
			->actions([])
			->bulkActions([]);
	}
}

