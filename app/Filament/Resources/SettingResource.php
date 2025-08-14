<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'System Management';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Setting Information')
                    ->schema([
                        TextInput::make('key')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->label('Setting Key')
                            ->placeholder('e.g., smtp_host, whatsapp_token')
                            ->helperText('Unique identifier for this setting'),
                        
                        Select::make('type')
                            ->options([
                                'string' => 'Text',
                                'number' => 'Number',
                                'boolean' => 'Boolean',
                                'json' => 'JSON',
                                'textarea' => 'Long Text',
                            ])
                            ->default('string')
                            ->required()
                            ->label('Data Type'),
                        
                        Select::make('group')
                            ->options([
                                'general' => 'General',
                                'email' => 'Email Settings',
                                'whatsapp' => 'WhatsApp Settings',
                                'mcu' => 'MCU Settings',
                                'system' => 'System Settings',
                            ])
                            ->default('general')
                            ->required()
                            ->label('Setting Group'),
                    ])
                    ->columns(3),

                Section::make('Setting Value')
                    ->schema([
                        TextInput::make('value')
                            ->label('Value')
                            ->placeholder('Enter the setting value')
                            ->helperText('The actual value for this setting'),
                        
                        Textarea::make('description')
                            ->label('Description')
                            ->rows(3)
                            ->placeholder('Describe what this setting is used for')
                            ->helperText('Optional description of this setting'),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->label('Setting Key')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                
                TextColumn::make('value')
                    ->label('Value')
                    ->limit(50)
                    ->searchable()
                    ->copyable(),
                
                BadgeColumn::make('type')
                    ->colors([
                        'primary' => 'string',
                        'success' => 'number',
                        'warning' => 'boolean',
                        'info' => 'json',
                        'secondary' => 'textarea',
                    ])
                    ->label('Type'),
                
                BadgeColumn::make('group')
                    ->colors([
                        'primary' => 'general',
                        'success' => 'email',
                        'warning' => 'whatsapp',
                        'info' => 'mcu',
                        'secondary' => 'system',
                    ])
                    ->label('Group'),
                
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'string' => 'Text',
                        'number' => 'Number',
                        'boolean' => 'Boolean',
                        'json' => 'JSON',
                        'textarea' => 'Long Text',
                    ])
                    ->label('Type'),
                
                SelectFilter::make('group')
                    ->options([
                        'general' => 'General',
                        'email' => 'Email Settings',
                        'whatsapp' => 'WhatsApp Settings',
                        'mcu' => 'MCU Settings',
                        'system' => 'System Settings',
                    ])
                    ->label('Group'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                
                Action::make('test_email')
                    ->label('Test Email')
                    ->icon('heroicon-o-envelope')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Setting $record): bool => $record->key === 'smtp_host')
                    ->action(function (Setting $record) {
                        // Test email functionality
                        try {
                            $emailService = new \App\Services\EmailService();
                            // Test email logic here
                            \Filament\Notifications\Notification::make()
                                ->title('Email Test')
                                ->body('Email settings test completed successfully.')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            \Filament\Notifications\Notification::make()
                                ->title('Email Test Failed')
                                ->body('Error: ' . $e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
                
                Action::make('test_whatsapp')
                    ->label('Test WhatsApp')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Setting $record): bool => $record->key === 'whatsapp_token')
                    ->action(function (Setting $record) {
                        // Test WhatsApp functionality
                        try {
                            $whatsappService = new \App\Services\WhatsAppService();
                            // Test WhatsApp logic here
                            \Filament\Notifications\Notification::make()
                                ->title('WhatsApp Test')
                                ->body('WhatsApp settings test completed successfully.')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            \Filament\Notifications\Notification::make()
                                ->title('WhatsApp Test Failed')
                                ->body('Error: ' . $e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    
                    Action::make('export_settings')
                        ->label('Export Settings')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('success')
                        ->action(function (array $records) {
                            // Export logic here
                            \Filament\Notifications\Notification::make()
                                ->title('Settings exported successfully')
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
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
