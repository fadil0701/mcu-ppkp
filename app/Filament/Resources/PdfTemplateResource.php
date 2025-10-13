<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PdfTemplateResource\Pages;
use App\Filament\Resources\PdfTemplateResource\RelationManagers;
use App\Models\PdfTemplate;
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
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Components\FileUpload;
use App\Filament\Forms\Components\WysiwygEditor;
use App\Filament\Forms\Components\GoogleDocsEditor;
use App\Filament\Forms\Components\WordLikeEditor;
use App\Filament\Forms\Components\CKEditor5;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class PdfTemplateResource extends Resource
{
    protected static ?string $model = PdfTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }

    protected static ?string $navigationLabel = 'PDF Templates';

    protected static ?string $modelLabel = 'PDF Template';

    protected static ?string $pluralModelLabel = 'PDF Templates';

    protected static ?string $navigationGroup = 'Email Management';

    protected static ?int $navigationSort = 2;
    
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
                                'mcu_letter' => 'MCU Letter',
                                'reminder_letter' => 'Reminder Letter',
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

                Section::make('Document Content')
                    ->schema([
                        TextInput::make('title')
                            ->label('Document Title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        CKEditor5::make('combined_html')
                            ->label('Template Content')
                            ->enableVariables(true)
                            ->enableImages(true)
                            ->enableTables(true)
                            ->showPreview(true)
                            ->columnSpanFull()
                            ->helperText('Professional CKEditor 5 template editor. Write your template directly and use {{variable.name}} for dynamic content.')
                    ]),

                Section::make('Document Settings')
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

                Section::make('Template Variables')
                    ->schema([
                        ViewField::make('available_variables')
                            ->label('Available Variables')
                            ->view('filament.forms.components.pdf-template-variables')
                            ->columnSpanFull(),
                    ]),

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
                        'primary' => 'mcu_letter',
                        'success' => 'reminder_letter',
                        'secondary' => 'custom',
                    ]),

                TextColumn::make('title')
                    ->label('Title')
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
                        'mcu_letter' => 'MCU Letter',
                        'reminder_letter' => 'Reminder Letter',
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
                    ->action(function (PdfTemplate $record) {
                        $record->setAsDefault();
                    })
                    ->visible(fn (PdfTemplate $record): bool => !$record->is_default),

                Tables\Actions\Action::make('preview')
                    ->label('Preview')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalContent(function (PdfTemplate $record) {
                        return new HtmlString(
                            '<div class="p-4">' .
                            '<h3 class="text-lg font-semibold mb-2">' . $record->title . '</h3>' .
                            '<div class="border rounded p-4 max-h-96 overflow-y-auto">' . 
                            ($record->header_html ?: '') . 
                            ($record->body_html ?: '') . 
                            ($record->footer_html ?: '') . 
                            '</div>' .
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
            'index' => Pages\ListPdfTemplates::route('/'),
            'create' => Pages\CreatePdfTemplate::route('/create'),
            'edit' => Pages\EditPdfTemplate::route('/{record}/edit'),
        ];
    }
}
