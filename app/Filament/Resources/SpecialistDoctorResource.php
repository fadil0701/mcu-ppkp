<?php

namespace App\Filament\Resources;

use App\Models\SpecialistDoctor;
use App\Filament\Resources\SpecialistDoctorResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;


class SpecialistDoctorResource extends Resource
{
    protected static ?string $model = SpecialistDoctor::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Dokter Spesialis';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->label('Nama Dokter')->required()->maxLength(255),
            Forms\Components\TextInput::make('specialty')->label('Spesialisasi')->maxLength(255),
            Forms\Components\Textarea::make('description')->label('Deskripsi')->rows(3),
            Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('specialty')->label('Spesialisasi')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('description')->label('Deskripsi')->limit(40)->toggleable(),
                Tables\Columns\IconColumn::make('is_active')->boolean()->label('Aktif'),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->label('Diubah')->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSpecialistDoctors::route('/'),
            'create' => Pages\CreateSpecialistDoctor::route('/create'),
            'edit' => Pages\EditSpecialistDoctor::route('/{record}/edit'),
        ];
    }
}
