<?php

namespace App\Filament\Resources\ParticipantResource\RelationManagers;

use App\Models\McuResult;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class McuResultsRelationManager extends RelationManager
{
	protected static string $relationship = 'mcuResults';

	public function table(Table $table): Table
	{
		return $table
			->columns([
				Tables\Columns\TextColumn::make('tanggal_pemeriksaan')->label('Tanggal')->date('d/m/Y')->sortable(),
				Tables\Columns\TextColumn::make('diagnosis')->label('Diagnosis')->limit(30)->toggleable(),
				Tables\Columns\BadgeColumn::make('status_kesehatan')->label('Status')->colors([
					'success' => 'Sehat',
					'warning' => 'Kurang Sehat',
					'danger' => 'Tidak Sehat',
				]),
				Tables\Columns\IconColumn::make('hasFile')
					->label('File')
					->boolean()
					->state(fn (McuResult $record) => $record->hasFile()),
			])
			->headerActions([])
			->actions([])
			->bulkActions([]);
	}
}

