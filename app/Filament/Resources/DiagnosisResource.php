<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DiagnosisResource\Pages;
use App\Models\Diagnosis;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;
use Filament\Tables\Actions\Action;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class DiagnosisResource extends Resource
{
	protected static ?string $model = Diagnosis::class;

	protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
	protected static ?string $navigationGroup = 'Master Data';
	protected static ?int $navigationSort = 1;

	public static function form(Form $form): Form
	{
		return $form
			->schema([
				Forms\Components\TextInput::make('code')->label('Kode')->maxLength(50),
				Forms\Components\TextInput::make('name')->label('Nama Diagnosis')->required()->maxLength(255),
				Forms\Components\Textarea::make('description')->label('Deskripsi')->rows(3),
				Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
			]);
	}

	public static function table(Table $table): Table
	{
		return $table
			->columns([
				Tables\Columns\TextColumn::make('code')->label('Kode')->searchable()->sortable(),
				Tables\Columns\TextColumn::make('name')->label('Nama')->searchable()->sortable(),
				Tables\Columns\TextColumn::make('description')->label('Deskripsi')->limit(40)->toggleable(),
				Tables\Columns\IconColumn::make('is_active')->boolean()->label('Aktif'),
				Tables\Columns\TextColumn::make('updated_at')->dateTime()->label('Diubah')->toggleable(isToggledHiddenByDefault: true),
			])
			->filters([])
			->actions([
				Tables\Actions\EditAction::make(),
				Tables\Actions\DeleteAction::make(),
			])
			->bulkActions([
				Tables\Actions\BulkActionGroup::make([
					Tables\Actions\DeleteBulkAction::make(),
				]),
			])
			->headerActions([
				Action::make('import_diagnosis')
					->label('Import Diagnosis')
					->icon('heroicon-o-arrow-up-tray')
					->color('success')
					->form([
						Forms\Components\FileUpload::make('file')
							->label('File (CSV)')
							->acceptedFileTypes(['text/csv','text/plain'])
							->required()
							->directory('imports')
							->preserveFilenames(),
					])
					->action(function (array $data) {
						$value = $data['file'] ?? null;
						if (!$value) {
							\Filament\Notifications\Notification::make()->title('Tidak ada file')->danger()->send();
							return;
						}
						$fullPath = is_string($value) ? Storage::disk('public')->path($value) : ($value instanceof UploadedFile ? $value->getRealPath() : null);
						if (!$fullPath || !file_exists($fullPath)) {
							\Filament\Notifications\Notification::make()->title('File tidak ditemukan')->danger()->send();
							return;
						}
						$rows = array_map('str_getcsv', file($fullPath));
						// Expect header: code,name,description,is_active
						$header = array_map('trim', array_shift($rows));
						foreach ($rows as $row) {
							$data = array_combine($header, $row);
							if (!$data) continue;
							Diagnosis::updateOrCreate(
								['name' => $data['name'] ?? null],
								[
									'code' => $data['code'] ?? null,
									'description' => $data['description'] ?? null,
									'is_active' => isset($data['is_active']) ? in_array(strtolower($data['is_active']), ['1','true','yes'], true) : true,
								]
							);
						}
						\Filament\Notifications\Notification::make()->title('Import selesai')->success()->send();
					}),
			]);
	}

	public static function getPages(): array
	{
		return [
			'index' => Pages\ListDiagnoses::route('/'),
			'create' => Pages\CreateDiagnosis::route('/create'),
			'edit' => Pages\EditDiagnosis::route('/{record}/edit'),
		];
	}
}

