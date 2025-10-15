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
use App\Imports\DiagnosesImport;
use Illuminate\Support\Facades\Log;

class DiagnosisResource extends Resource
{
	protected static ?string $model = Diagnosis::class;

	protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
	protected static ?string $navigationGroup = 'Master Data';
	protected static ?int $navigationSort = 1;

	public static function canAccess(): bool
	{
		return auth()->user()?->hasRole('super_admin') ?? false;
	}

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
			->filters([
				Tables\Filters\TernaryFilter::make('is_active')
					->label('Status Aktif')
					->placeholder('Semua')
					->trueLabel('Aktif')
					->falseLabel('Tidak Aktif'),
			])
			->actions([
				Tables\Actions\EditAction::make(),
				Tables\Actions\DeleteAction::make(),
			])
			->bulkActions([
				Tables\Actions\BulkActionGroup::make([
					Tables\Actions\DeleteBulkAction::make(),
					
					Tables\Actions\BulkAction::make('activate_selected')
						->label('Aktifkan yang Dipilih')
						->icon('heroicon-o-check-circle')
						->color('success')
						->action(function ($records) {
							$records->each->update(['is_active' => true]);
							\Filament\Notifications\Notification::make()
								->title('Berhasil mengaktifkan diagnosis yang dipilih')
								->success()
								->send();
						}),
						
					Tables\Actions\BulkAction::make('deactivate_selected')
						->label('Nonaktifkan yang Dipilih')
						->icon('heroicon-o-x-circle')
						->color('warning')
						->action(function ($records) {
							$records->each->update(['is_active' => false]);
							\Filament\Notifications\Notification::make()
								->title('Berhasil menonaktifkan diagnosis yang dipilih')
								->success()
								->send();
						}),
				]),
			])
			->headerActions([
				Action::make('import_diagnosis')
					->label('Import Diagnosis')
					->icon('heroicon-o-arrow-up-tray')
					->color('success')
					->form([
						Forms\Components\FileUpload::make('file')
							->label('File (CSV/Excel)')
							->acceptedFileTypes([
								'text/csv',
								'text/plain',
								'application/vnd.ms-excel',
								'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
							])
							->required()
							->directory('imports')
							->preserveFilenames()
							->helperText('Format: CSV atau Excel. Kolom: name, code, description, is_active'),
					])
					->action(function (array $data) {
						$value = $data['file'] ?? null;
						
						if (!$value) {
							\Filament\Notifications\Notification::make()
								->title('Tidak ada file')
								->danger()
								->send();
							return;
						}

						// Get file path
						$fullPath = null;
						if ($value instanceof UploadedFile) {
							$stored = $value->storeAs('imports', 'diagnoses_' . now()->format('Ymd_His') . '.' . $value->getClientOriginalExtension(), 'public');
							$fullPath = Storage::disk('public')->path($stored);
						} elseif (is_string($value)) {
							$fullPath = Storage::disk('public')->path($value);
						}

						if (!$fullPath || !file_exists($fullPath)) {
							\Filament\Notifications\Notification::make()
								->title('File tidak ditemukan')
								->danger()
								->send();
							return;
						}

						try {
							// Increase execution time limit for large imports
							set_time_limit(300); // 5 minutes
							ini_set('memory_limit', '512M');

							// Show loading notification
							\Filament\Notifications\Notification::make()
								->title('Memproses import...')
								->body('Mohon tunggu, sedang memproses data diagnosis. Proses ini mungkin memakan waktu beberapa menit.')
								->info()
								->persistent()
								->send();

							// Import using optimized class
							$import = new DiagnosesImport();
							Excel::import($import, $fullPath);

							// Get import statistics
							$stats = $import->getImportStats();

							// Show success notification with details
							\Filament\Notifications\Notification::make()
								->title('Import berhasil!')
								->body(sprintf(
									'Imported: %d | Updated: %d | Skipped: %d | Errors: %d',
									$stats['imported'],
									$stats['updated'],
									$stats['skipped'],
									count($stats['errors'])
								))
								->success()
								->send();

							// Log import completion
							Log::info('Diagnosis import completed', $stats);

							// Clean up uploaded file
							if (file_exists($fullPath)) {
								unlink($fullPath);
							}

						} catch (\Throwable $e) {
							Log::error('Diagnosis import failed: ' . $e->getMessage(), [
								'exception' => $e,
								'file_path' => $fullPath ?? 'unknown'
							]);
							
							\Filament\Notifications\Notification::make()
								->title('Import gagal')
								->body('Terjadi kesalahan: ' . $e->getMessage())
								->danger()
								->send();

							// Clean up uploaded file on error
							if (isset($fullPath) && file_exists($fullPath)) {
								unlink($fullPath);
							}
						}
					}),
			])
			->defaultSort('name')
			->paginated([10, 25, 50, 100])
			->poll('30s'); // Refresh every 30 seconds for long imports
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

