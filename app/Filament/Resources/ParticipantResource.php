<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParticipantResource\Pages;
use App\Filament\Resources\ParticipantResource\RelationManagers;
use App\Models\Participant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ParticipantResource extends Resource
{
    protected static ?string $model = Participant::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Data Peserta';
    protected static ?string $modelLabel = 'Peserta';
    protected static ?string $pluralModelLabel = 'Peserta';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pribadi')
                    ->schema([
                        Forms\Components\TextInput::make('nik_ktp')
                            ->label('NIK KTP')
                            ->required()
                            ->length(16)
                            ->unique(ignoreRecord: true)
                            ->numeric(),
                        Forms\Components\TextInput::make('nrk_pegawai')
                            ->label('NRK Pegawai')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('nama_lengkap')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('tempat_lahir')
                            ->label('Tempat Lahir')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('tanggal_lahir')
                            ->label('Tanggal Lahir')
                            ->required()
                            ->maxDate(now()),
                        Forms\Components\Select::make('jenis_kelamin')
                            ->label('Jenis Kelamin')
                            ->options([
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan',
                            ])
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Informasi Instansi')
                    ->schema([
                        Forms\Components\TextInput::make('skpd')
                            ->label('SKPD')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('ukpd')
                            ->label('UKPD')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('status_pegawai')
                            ->label('Status Pegawai')
                            ->options([
                                'CPNS' => 'CPNS',
                                'PNS' => 'PNS',
                                'PPPK' => 'PPPK',
                            ])
                            ->required(),
                    ])->columns(3),

                Forms\Components\Section::make('Kontak')
                    ->schema([
                        Forms\Components\TextInput::make('no_telp')
                            ->label('No. Telepon')
                            ->tel()
                            ->required()
                            ->maxLength(20),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('Status MCU')
                    ->schema([
                        Forms\Components\Select::make('status_mcu')
                            ->label('Status MCU')
                            ->options([
                                'Belum MCU' => 'Belum MCU',
                                'Sudah MCU' => 'Sudah MCU',
                                'Ditolak' => 'Ditolak',
                            ])
                            ->default('Belum MCU')
                            ->required(),
                        Forms\Components\DatePicker::make('tanggal_mcu_terakhir')
                            ->label('Tanggal MCU Terakhir')
                            ->maxDate(now()),
                        Forms\Components\Textarea::make('catatan')
                            ->label('Catatan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nik_ktp')
                    ->label('NIK KTP')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nrk_pegawai')
                    ->label('NRK Pegawai')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('no_telp')
                    ->label('No. Telepon')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status_pegawai')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'PNS' => 'success',
                        'CPNS' => 'warning',
                        'PPPK' => 'info',
                        default => 'secondary',
                    }),
                Tables\Columns\TextColumn::make('skpd')
                    ->label('SKPD')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('umur')
                    ->label('Umur')
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->label('JK')
                    ->formatStateUsing(fn (string $state): string => $state === 'L' ? 'L' : 'P')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'L' ? 'blue' : 'pink'),
                Tables\Columns\BadgeColumn::make('status_mcu')
                    ->label('Status MCU')
                    ->colors([
                        'warning' => 'Belum MCU',
                        'success' => 'Sudah MCU',
                        'danger' => 'Ditolak',
                    ]),
                Tables\Columns\TextColumn::make('tanggal_mcu_terakhir')
                    ->label('MCU Terakhir')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Terdaftar')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
				Tables\Columns\TextColumn::make('schedules_count')
					->counts('schedules')
					->label('Jadwal')
					->badge()
					->sortable(),
				Tables\Columns\TextColumn::make('mcu_results_count')
					->counts('mcuResults')
					->label('Riwayat MCU')
					->badge()
					->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_pegawai')
                    ->label('Status Pegawai')
                    ->options([
                        'CPNS' => 'CPNS',
                        'PNS' => 'PNS',
                        'PPPK' => 'PPPK',
                    ]),
                Tables\Filters\SelectFilter::make('status_mcu')
                    ->label('Status MCU')
                    ->options([
                        'Belum MCU' => 'Belum MCU',
                        'Sudah MCU' => 'Sudah MCU',
                        'Ditolak' => 'Ditolak',
                    ]),
                Tables\Filters\SelectFilter::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('schedule')
                    ->label('Jadwalkan')
                    ->icon('heroicon-o-calendar')
                    ->color('success')
                    ->visible(fn (Participant $record): bool => $record->canScheduleMcu())
                    ->url(fn (Participant $record): string => route('filament.admin.resources.schedules.create', ['participant_id' => $record->id])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\SchedulesRelationManager::class,
            RelationManagers\McuResultsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListParticipants::route('/'),
            'create' => Pages\CreateParticipant::route('/create'),
            'view' => Pages\ViewParticipant::route('/{record}'),
            'edit' => Pages\EditParticipant::route('/{record}/edit'),
        ];
    }
}
