<?php

namespace App\Filament\Resources;

use App\Filament\Resources\McuResultResource\Pages;
use App\Models\McuResult;
use App\Models\Diagnosis;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Get;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Schedule;
use App\Models\SpecialistDoctor;

class McuResultResource extends Resource
{
	protected static ?string $model = McuResult::class;

	protected static ?string $navigationIcon = 'heroicon-o-document-text';
	protected static ?string $navigationLabel = 'Hasil MCU';

	protected static ?string $navigationGroup = 'Data Management';

	protected static ?int $navigationSort = 3;

	public static function form(Form $form): Form
	{
		return $form
			->schema([
				Section::make('Participant & Schedule Information')
					->schema([
						Select::make('participant_id')
							->relationship('participant', 'nama_lengkap')
							->searchable()
							->preload()
							->required()
							->label('Participant')
							->getSearchResultsUsing(function (string $search) {
								return \App\Models\Participant::query()
									->where('nik_ktp', 'like', "%$search%")
									->orWhere('nama_lengkap', 'like', "%$search%")
									->orWhere('nrk_pegawai', 'like', "%$search%")
									->orWhere('no_telp', 'like', "%$search%")
									->limit(50)
									->pluck('nama_lengkap', 'id');
							})
							->afterStateUpdated(function ($state, callable $set) {
								if ($state) {
									$participant = \App\Models\Participant::find($state);
									if ($participant) {
										$set('tanggal_pemeriksaan', $participant->tanggal_mcu_terakhir ?? now());
									}
								}
							}),
						
						Select::make('schedule_id')
							->label('Schedule')
							->searchable()
							->preload()
							->required()
							->options(function (Get $get) {
								$participantId = $get('participant_id');
								if (blank($participantId)) {
									return [];
								}
								return Schedule::query()
									->where('participant_id', $participantId)
									->where('status', 'Selesai')
									->orderByDesc('tanggal_pemeriksaan')
									->pluck('id', 'id');
							})
							->disabled(fn (Get $get) => blank($get('participant_id')))
							->placeholder('Pilih jadwal (wajib)'),
					])
					->columns(2),

				Section::make('Examination Results')
					->schema([
						DatePicker::make('tanggal_pemeriksaan')
							->required()
							->label('Examination Date')
							->maxDate(now()),
						
                        Select::make('diagnosis_list')
                            ->label('Diagnosis')
                            ->multiple()
                            ->searchable()
                            ->placeholder('Cari berdasarkan nama atau kode diagnosis...')
                            ->getSearchResultsUsing(function (string $search): array {
                                return Diagnosis::query()
                                    ->where('is_active', true)
                                    ->where(function ($q) use ($search) {
                                        $q->where('name', 'like', "%$search%")
                                          ->orWhere('code', 'like', "%$search%");
                                    })
                                    ->orderBy('name')
                                    ->limit(50)
                                    ->get()
                                    ->mapWithKeys(function (Diagnosis $d) {
                                        $label = $d->code ? ($d->code . ' - ' . $d->name) : $d->name;
                                        // store value as name to match diagnosis_list (array of names)
                                        return [$d->name => $label];
                                    })
                                    ->toArray();
                            })
                            ->getOptionLabelsUsing(function (array $values): array {
                                if (empty($values)) return [];
                                return Diagnosis::query()
                                    ->whereIn('name', $values)
                                    ->get()
                                    ->mapWithKeys(function (Diagnosis $d) {
                                        $label = $d->code ? ($d->code . ' - ' . $d->name) : $d->name;
                                        return [$d->name => $label];
                                    })
                                    ->toArray();
                            })
                            ->helperText('Pilih satu atau lebih diagnosis dari master data (bisa cari pakai nama atau kode).'),
						
						Textarea::make('hasil_pemeriksaan')
							->required()
							->label('Examination Results')
							->rows(4)
							->placeholder('Enter detailed examination results'),
						
						Select::make('status_kesehatan')
							->options([
								'Sehat' => 'Healthy',
								'Kurang Sehat' => 'Less Healthy',
								'Tidak Sehat' => 'Unhealthy',
							])
							->required()
							->label('Health Status'),
						
						Textarea::make('rekomendasi')
							->label('Recommendations')
							->rows(3)
							->placeholder('Enter health recommendations'),
						// Select::make('specialist_doctor_id')
						// 	->label('Dokter Spesialis (Rekomendasi)')
						// 	->options(\App\Models\SpecialistDoctor::all()->pluck('name', 'id'))
						// 	->searchable()
						// 	->preload()
						// 	->placeholder('Pilih dokter spesialis jika perlu'),
												Select::make('specialist_doctor_ids')
													->label('Dokter Spesialis (Rekomendasi)')
													->multiple()
													->searchable()
													->options(function () {
														return SpecialistDoctor::query()
															->where('is_active', true)
															->orderBy('name')
															->pluck('name', 'id')
															->toArray();
													})
													->placeholder('Cari berdasarkan nama...')
													->helperText('Pilih satu atau lebih dokter spesialis sebagai rekomendasi.'),
					])
					->columns(2),

				Section::make('File Upload')
					->schema([
						FileUpload::make('file_hasil_files')
							->label('Result Files')
							->disk('public')
							->directory('mcu-results')
							->multiple()
							->preserveFilenames()
							->acceptedFileTypes([
								'application/pdf',
								'application/msword',
								'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
								'image/*',
							])
							->maxFiles(10)
							->maxSize(10240)
							->helperText('Unggah hingga 10 file: PDF, DOC, DOCX, atau gambar (maks 10MB per file)')
							->downloadable()
							->previewable(),
					])
					->collapsible(),
			]);
	}

	public static function table(Table $table): Table
	{
		return $table
			->modifyQueryUsing(function (Builder $query) {
				$query->with(['participant', 'schedule']);
			})
			->columns([
				TextColumn::make('participant.nama_lengkap')
					->label('Participant Name')
					->searchable()
					->sortable(),
				
				TextColumn::make('participant.nik_ktp')
					->label('NIK KTP')
					->searchable(),
				
				TextColumn::make('tanggal_pemeriksaan')
					->label('Examination Date')
					->date()
					->sortable(),
				
				TextColumn::make('diagnosis_list')
					->label('Diagnosis')
					->formatStateUsing(fn ($state) => is_array($state) ? implode(', ', $state) : ($state ?: '-'))
					->searchable(),
				
				BadgeColumn::make('status_kesehatan')
					->colors([
						'success' => 'Sehat',
						'warning' => 'Kurang Sehat',
						'danger' => 'Tidak Sehat',
					])
					->label('Health Status'),
				
				TextColumn::make('participant.skpd')
					->label('SKPD')
					->searchable(),
				
				IconColumn::make('is_downloaded')
					->boolean()
					->label('Downloaded')
					->trueIcon('heroicon-o-check-circle')
					->falseIcon('heroicon-o-x-circle')
					->trueColor('success')
					->falseColor('danger'),
				
				TextColumn::make('uploaded_by')
					->label('Uploaded By')
					->searchable(),
				
				TextColumn::make('created_at')
					->label('Created')
					->dateTime()
					->sortable()
					->toggleable(isToggledHiddenByDefault: true),
			])
			->filters([
				SelectFilter::make('status_kesehatan')
					->options([
						'Sehat' => 'Healthy',
						'Kurang Sehat' => 'Less Healthy',
						'Tidak Sehat' => 'Unhealthy',
					])
					->label('Health Status'),
				
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
				
				Filter::make('is_downloaded')
					->form([
						Forms\Components\Toggle::make('is_downloaded')
							->label('Downloaded'),
					])
					->query(function (Builder $query, array $data): Builder {
						return $query->when(
							$data['is_downloaded'],
							fn (Builder $query, $isDownloaded): Builder => $query->where('is_downloaded', $isDownloaded),
						);
					})
					->label('Download Status'),
			])
			->actions([
				Tables\Actions\ViewAction::make(),
				Tables\Actions\EditAction::make(),
				Tables\Actions\DeleteAction::make(),
				
				Action::make('download_file')
					->label('Download File')
					->icon('heroicon-o-arrow-down-tray')
					->color('success')
					->url(fn (McuResult $record): string => $record->hasFile() ? $record->file_url : '#')
					->openUrlInNewTab()
					->visible(fn (McuResult $record): bool => (bool) $record->file_hasil),
				
				Action::make('download_all')
					->label('Download All')
					->icon('heroicon-o-archive-box-arrow-down')
					->color('primary')
					->url(fn (McuResult $record): string => route('admin.mcu-results.downloadAll', ['record' => $record->id]))
					->openUrlInNewTab()
					->visible(fn (McuResult $record): bool => (is_array($record->file_hasil_files) && count($record->file_hasil_files) > 0) || $record->file_hasil),
			])
			->bulkActions([
				Tables\Actions\BulkActionGroup::make([
					Tables\Actions\DeleteBulkAction::make(),
					
					Action::make('export_results')
						->label('Export Results')
						->icon('heroicon-o-arrow-down-tray')
						->color('success')
						->action(function (array $records) {
							// Export logic here
							\Filament\Notifications\Notification::make()
								->title('Export completed')
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
			'index' => Pages\ListMcuResults::route('/'),
			'create' => Pages\CreateMcuResult::route('/create'),
			'edit' => Pages\EditMcuResult::route('/{record}/edit'),
		];
	}
}
