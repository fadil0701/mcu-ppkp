<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScheduleResource\Pages;
use App\Models\Schedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'MCU Management';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Participant Information')
                    ->schema([
                        Select::make('participant_id')
                            ->relationship('participant', 'nama_lengkap')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Participant')
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $participant = \App\Models\Participant::find($state);
                                    if ($participant) {
                                        $set('nik_ktp', $participant->nik_ktp);
                                        $set('nrk_pegawai', $participant->nrk_pegawai);
                                        $set('nama_lengkap', $participant->nama_lengkap);
                                        $set('tanggal_lahir', $participant->tanggal_lahir);
                                        $set('jenis_kelamin', $participant->jenis_kelamin);
                                        $set('skpd', $participant->skpd);
                                        $set('ukpd', $participant->ukpd);
                                        $set('no_telp', $participant->no_telp);
                                        $set('email', $participant->email);
                                    }
                                }
                            }),
                    ])
                    ->columns(2),

                Section::make('Schedule Details')
                    ->schema([
                        DatePicker::make('tanggal_pemeriksaan')
                            ->required()
                            ->label('Examination Date')
                            ->minDate(now()->startOfDay()),
                        
                        TimePicker::make('jam_pemeriksaan')
                            ->required()
                            ->label('Examination Time')
                            ->seconds(false),
                        
                        TextInput::make('lokasi_pemeriksaan')
                            ->required()
                            ->label('Examination Location')
                            ->placeholder('Enter examination location'),
                        
                        Select::make('status')
                            ->options([
                                'Terjadwal' => 'Scheduled',
                                'Selesai' => 'Completed',
                                'Batal' => 'Cancelled',
                                'Ditolak' => 'Rejected',
                            ])
                            ->default('Terjadwal')
                            ->required()
                            ->label('Status'),

                        TextInput::make('queue_number')
                            ->label('Queue #')
                            ->numeric()
                            ->helperText('Dibiarkan kosong untuk auto-number berdasarkan tanggal.')
                            ->hint('Auto-number'),
                    ])
                    ->columns(2),

                Section::make('Participant Data')
                    ->schema([
                        TextInput::make('nik_ktp')
                            ->label('NIK KTP')
                            ->disabled()
                            ->dehydrated(),
                        
                        TextInput::make('nrk_pegawai')
                            ->label('NRK Pegawai')
                            ->disabled()
                            ->dehydrated(),
                        
                        TextInput::make('nama_lengkap')
                            ->label('Full Name')
                            ->disabled()
                            ->dehydrated(),
                        
                        DatePicker::make('tanggal_lahir')
                            ->label('Date of Birth')
                            ->disabled()
                            ->dehydrated(),
                        
                        Select::make('jenis_kelamin')
                            ->options([
                                'L' => 'Male',
                                'P' => 'Female',
                            ])
                            ->label('Gender')
                            ->disabled()
                            ->dehydrated(),
                        
                        TextInput::make('skpd')
                            ->label('SKPD')
                            ->disabled()
                            ->dehydrated(),
                        
                        TextInput::make('ukpd')
                            ->label('UKPD')
                            ->disabled()
                            ->dehydrated(),
                        
                        TextInput::make('no_telp')
                            ->label('Phone Number')
                            ->disabled()
                            ->dehydrated(),
                        
                        TextInput::make('email')
                            ->label('Email')
                            ->disabled()
                            ->dehydrated(),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Additional Information')
                    ->schema([
                        Textarea::make('catatan')
                            ->label('Notes')
                            ->placeholder('Add any additional notes')
                            ->rows(3),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('participant.nama_lengkap')
                    ->label('Participant Name')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('nik_ktp')
                    ->label('NIK KTP')
                    ->searchable(),
                
                TextColumn::make('tanggal_pemeriksaan')
                    ->label('Examination Date')
                    ->date()
                    ->sortable(),
                
                TextColumn::make('jam_pemeriksaan')
                    ->label('Time')
                    ->time('H:i')
                    ->sortable(),
                
                TextColumn::make('lokasi_pemeriksaan')
                    ->label('Location')
                    ->limit(30),
                TextColumn::make('queue_number')
                    ->label('No. Antrian')
                    ->badge()
                    ->sortable(),
                
                BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'Terjadwal',
                        'success' => 'Selesai',
                        'danger' => 'Batal',
                        'gray' => 'Ditolak',
                    ])
                    ->label('Status'),
                
                TextColumn::make('skpd')
                    ->label('SKPD')
                    ->searchable(),
                
                IconColumn::make('email_sent')
                    ->boolean()
                    ->label('Email')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                
                IconColumn::make('whatsapp_sent')
                    ->boolean()
                    ->label('WhatsApp')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'Terjadwal' => 'Scheduled',
                        'Selesai' => 'Completed',
                        'Batal' => 'Cancelled',
                        'Ditolak' => 'Rejected',
                    ])
                    ->label('Status'),
                
                SelectFilter::make('skpd')
                    ->relationship('participant', 'skpd')
                    ->label('SKPD'),
                
                Filter::make('tanggal_pemeriksaan')
                    ->form([
                        DatePicker::make('from')
                            ->label('From Date'),
                        DatePicker::make('until')
                            ->label('Until Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tanggal_pemeriksaan', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tanggal_pemeriksaan', '<=', $date),
                            );
                    })
                    ->label('Examination Date Range'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                
                Action::make('send_invitation')
                    ->label('Send Invitation')
                    ->icon('heroicon-o-envelope')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (Schedule $record) {
                        // Send email invitation
                        try {
                            $emailService = new \App\Services\EmailService();
                            $emailService->sendMcuInvitation($record);
                            
                            $record->update([
                                'email_sent' => true,
                                'email_sent_at' => now(),
                            ]);
                            
                            \Filament\Notifications\Notification::make()
                                ->title('Invitation sent successfully')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            \Filament\Notifications\Notification::make()
                                ->title('Failed to send invitation')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    })
                    ->visible(fn (Schedule $record): bool => !$record->email_sent),
                
                Action::make('send_whatsapp')
                    ->label('Send WhatsApp')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (Schedule $record) {
                        // Send WhatsApp invitation
                        try {
                            $whatsappService = new \App\Services\WhatsAppService();
                            $whatsappService->sendMcuInvitation($record);
                            
                            $record->update([
                                'whatsapp_sent' => true,
                                'whatsapp_sent_at' => now(),
                            ]);
                            
                            \Filament\Notifications\Notification::make()
                                ->title('WhatsApp sent successfully')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            \Filament\Notifications\Notification::make()
                                ->title('Failed to send WhatsApp')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    })
                    ->visible(fn (Schedule $record): bool => !$record->whatsapp_sent),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    
                    Action::make('send_bulk_invitations')
                        ->label('Send Bulk Invitations')
                        ->icon('heroicon-o-envelope')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function (array $records) {
                            $emailService = new \App\Services\EmailService();
                            $whatsappService = new \App\Services\WhatsAppService();
                            $successCount = 0;
                            $errorCount = 0;
                            
                            foreach ($records as $record) {
                                try {
                                    // Send email
                                    $emailService->sendMcuInvitation($record);
                                    $record->update([
                                        'email_sent' => true,
                                        'email_sent_at' => now(),
                                    ]);
                                    
                                    // Send WhatsApp
                                    $whatsappService->sendMcuInvitation($record);
                                    $record->update([
                                        'whatsapp_sent' => true,
                                        'whatsapp_sent_at' => now(),
                                    ]);
                                    
                                    $successCount++;
                                } catch (\Exception $e) {
                                    $errorCount++;
                                }
                            }
                            
                            \Filament\Notifications\Notification::make()
                                ->title("Bulk invitations sent")
                                ->body("Success: {$successCount}, Failed: {$errorCount}")
                                ->success()
                                ->send();
                        }),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSchedules::route('/'),
            'create' => Pages\CreateSchedule::route('/create'),
            'edit' => Pages\EditSchedule::route('/{record}/edit'),
            'reschedule' => Pages\RescheduleRequests::route('/reschedule-requests'),
        ];
    }
}
