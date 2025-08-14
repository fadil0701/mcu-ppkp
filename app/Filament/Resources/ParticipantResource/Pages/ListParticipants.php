<?php

namespace App\Filament\Resources\ParticipantResource\Pages;

use App\Filament\Resources\ParticipantResource;
use App\Imports\ParticipantsImport;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class ListParticipants extends ListRecords
{
    protected static string $resource = ParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('download_template')
                ->label('Download Template')
                ->icon('heroicon-o-arrow-down-tray')
                ->url(route('participants.template'))
                ->openUrlInNewTab(),
            Action::make('import_participants')
                ->label('Import Peserta')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('success')
                ->form([
                    \Filament\Forms\Components\FileUpload::make('file')
                        ->label('File (XLSX/CSV)')
                        ->acceptedFileTypes([
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // xlsx
                            'application/vnd.ms-excel', // xls
                            'text/csv',
                        ])
                        ->required()
                        ->directory('imports')
                        ->preserveFilenames(),
                ])
                ->action(function (array $data) {
                    $value = $data['file'] ?? null;

                    if (!$value) {
                        \Filament\Notifications\Notification::make()
                            ->title('Tidak ada file yang diunggah')
                            ->danger()
                            ->send();
                        return;
                    }

                    $fullPath = null;
                    $extension = null;

                    if ($value instanceof UploadedFile) {
                        $extension = strtolower($value->getClientOriginalExtension());
                        $stored = $value->storeAs('imports', 'participants_' . now()->format('Ymd_His') . '.' . $extension, 'public');
                        $fullPath = Storage::disk('public')->path($stored);
                    } elseif (is_string($value)) {
                        // Value is the stored path relative to the disk
                        $extension = strtolower(pathinfo($value, PATHINFO_EXTENSION));
                        $fullPath = Storage::disk('public')->path($value);
                    }

                    $allowed = ['xlsx', 'xls', 'csv'];
                    if (!$extension || !in_array($extension, $allowed, true)) {
                        \Filament\Notifications\Notification::make()
                            ->title('Format file tidak didukung')
                            ->body('Gunakan file berformat XLSX, XLS, atau CSV.')
                            ->danger()
                            ->send();
                        return;
                    }

                    try {
                        Excel::import(new ParticipantsImport, $fullPath);
                    } catch (\Throwable $e) {
                        \Filament\Notifications\Notification::make()
                            ->title('Import gagal')
                            ->body('Periksa format kolom/isi file. Pesan: ' . $e->getMessage())
                            ->danger()
                            ->send();
                        return;
                    }

                    \Filament\Notifications\Notification::make()
                        ->title('Import berhasil')
                        ->success()
                        ->send();
                }),
        ];
    }
}
