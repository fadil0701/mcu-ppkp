<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmailTemplateResource\Pages;
use App\Filament\Resources\EmailTemplateResource\RelationManagers;
use App\Models\EmailTemplate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\ViewField;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class EmailTemplateResource extends Resource
{
    protected static ?string $model = EmailTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }

    protected static ?string $navigationLabel = 'Email Templates';

    protected static ?string $modelLabel = 'Email Template';

    protected static ?string $pluralModelLabel = 'Email Templates';

    protected static ?string $navigationGroup = 'Email Management';

    protected static ?int $navigationSort = 1;
    
    // Hide from navigation
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Template Information')
                    ->schema([
                        TextInput::make('name')
                            ->label('Template Name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),

                        Select::make('type')
                            ->label('Template Type')
                            ->options([
                                'mcu_invitation' => 'MCU Invitation',
                                'reminder' => 'Reminder',
                                'notification' => 'Notification',
                                'custom' => 'Custom',
                            ])
                            ->required()
                            ->columnSpan(1),

                        Textarea::make('description')
                            ->label('Description')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Email Content')
                    ->schema([
                        TextInput::make('subject')
                            ->label('Email Subject')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Undangan MCU - {participant_name}')
                            ->columnSpanFull(),

                        RichEditor::make('body_html')
                            ->label('HTML Body')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'link',
                                'bulletList',
                                'orderedList',
                                'h2',
                                'h3',
                                'blockquote',
                            ])
                            ->columnSpanFull(),

                        Textarea::make('body_text')
                            ->label('Plain Text Body')
                            ->rows(8)
                            ->placeholder('Plain text version for email clients that don\'t support HTML')
                            ->columnSpanFull(),
                    ]),

                Section::make('Template Variables')
                    ->schema([
                        ViewField::make('available_variables')
                            ->label('Available Variables')
                            ->view('filament.forms.components.template-variables')
                            ->columnSpanFull(),
                    ]),

                Section::make('Settings')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->columnSpan(1),

                        Toggle::make('is_default')
                            ->label('Default Template')
                            ->columnSpan(1),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Template Name')
                    ->searchable()
                    ->sortable(),

                BadgeColumn::make('type')
                    ->label('Type')
                    ->colors([
                        'primary' => 'mcu_invitation',
                        'success' => 'reminder',
                        'warning' => 'notification',
                        'secondary' => 'custom',
                    ]),

                TextColumn::make('subject')
                    ->label('Subject')
                    ->searchable()
                    ->limit(50),

                BooleanColumn::make('is_active')
                    ->label('Active')
                    ->sortable(),

                BooleanColumn::make('is_default')
                    ->label('Default')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'mcu_invitation' => 'MCU Invitation',
                        'reminder' => 'Reminder',
                        'notification' => 'Notification',
                        'custom' => 'Custom',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status'),

                Tables\Filters\TernaryFilter::make('is_default')
                    ->label('Default Status'),
            ])
            ->actions([
                Tables\Actions\Action::make('set_default')
                    ->label('Set as Default')
                    ->icon('heroicon-o-star')
                    ->color('warning')
                    ->action(function (EmailTemplate $record) {
                        $record->setAsDefault();
                    })
                    ->visible(fn (EmailTemplate $record): bool => !$record->is_default),

                Tables\Actions\Action::make('preview')
                    ->label('Preview')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalContent(function (EmailTemplate $record) {
                        return new HtmlString(
                            '<div class="p-4">' .
                            '<h3 class="text-lg font-semibold mb-2">' . $record->subject . '</h3>' .
                            '<div class="border rounded p-4">' . ($record->body_html ?: $record->body_text) . '</div>' .
                            '</div>'
                        );
                    }),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('type')
            ->groups([
                Tables\Grouping\Group::make('type')
                    ->label('Template Type')
                    ->collapsible(),
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
            'index' => Pages\ListEmailTemplates::route('/'),
            'create' => Pages\CreateEmailTemplate::route('/create'),
            'edit' => Pages\EditEmailTemplate::route('/{record}/edit'),
        ];
    }
}
