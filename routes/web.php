<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

// Redirect root to client dashboard
Route::get('/', function () {
    return redirect('/client/dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Client routes
Route::prefix('client')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [ClientController::class, 'dashboard'])->name('client.dashboard');
    Route::get('/profile', [ClientController::class, 'profile'])->name('client.profile');
    Route::get('/schedules', [ClientController::class, 'schedules'])->name('client.schedules');
    Route::get('/results', [ClientController::class, 'results'])->name('client.results');
    Route::get('/results/{result}/download', [ClientController::class, 'downloadResult'])->name('client.results.download');
    Route::get('/results/{result}/download-all', [ClientController::class, 'downloadAllResult'])->name('client.results.downloadAll');

    // Permintaan jadwal MCU ulang oleh peserta
    Route::get('/schedule/request', [ClientController::class, 'requestScheduleForm'])->name('client.schedule.request');
    Route::post('/schedule/request', [ClientController::class, 'storeScheduleRequest'])->name('client.schedule.request.store');

    // Konfirmasi & Reschedule oleh peserta
    Route::post('/schedule/{id}/confirm', [ClientController::class, 'confirmAttendance'])->name('client.schedule.confirm');
    Route::post('/schedule/{id}/reschedule', [ClientController::class, 'requestReschedule'])->name('client.schedule.reschedule');
    Route::post('/schedule/{id}/cancel', [ClientController::class, 'cancelSchedule'])->name('client.schedule.cancel');
});

// Reports download (Filament Admin)
Route::middleware(['auth'])->get('/admin/reports/download/{type}', [\App\Filament\Pages\Reports::class, 'download'])->name('filament.admin.pages.reports.download');

// Participants template download (Excel)
Route::middleware(['auth'])->get('/participants/template', function () {
    $headers = [
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    ];
    $columns = [
        ['nik_ktp', 'nrk_pegawai', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'skpd', 'ukpd', 'no_telp', 'email', 'status_pegawai', 'status_mcu', 'tanggal_mcu_terakhir', 'catatan'],
        ['3173XXXXXXXXXXXX', 'NRK123456', 'Budi Santoso', 'Jakarta', '1990-01-15', 'L', 'Dinas Kesehatan', 'UPT 1', '081234567890', 'budi@example.com', 'PNS', 'Belum MCU', '', ''],
    ];

    // Generate XLSX on the fly using PhpSpreadsheet via Maatwebsite Excel minimal writer
    $tmp = tempnam(sys_get_temp_dir(), 'tpl_') . '.xlsx';
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    foreach ($columns as $rowIndex => $row) {
        foreach ($row as $colIndex => $value) {
            $sheet->setCellValueByColumnAndRow($colIndex + 1, $rowIndex + 1, $value);
        }
    }
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save($tmp);
    return response()->download($tmp, 'participants_template.xlsx', $headers)->deleteFileAfterSend(true);
})->name('participants.template');

// Download semua file hasil MCU (ZIP)
Route::middleware(['auth'])->get('/admin/mcu-results/{record}/download-all', [\App\Http\Controllers\McuResultDownloadController::class, 'downloadAll'])->name('admin.mcu-results.downloadAll');

// Aktivasi akun peserta (belum punya akun login)
Route::middleware('guest')->group(function () {
    Route::get('/peserta/aktivasi-akun', [\App\Http\Controllers\PesertaActivationController::class, 'showVerificationForm'])->name('peserta.aktivasi');
    Route::post('/peserta/aktivasi-akun', [\App\Http\Controllers\PesertaActivationController::class, 'verifyParticipant']);
    Route::get('/peserta/aktivasi-akun/register', [\App\Http\Controllers\PesertaActivationController::class, 'showRegisterForm'])->name('peserta.aktivasi.register');
    Route::post('/peserta/aktivasi-akun/register', [\App\Http\Controllers\PesertaActivationController::class, 'registerAccount']);
});

require __DIR__.'/auth.php';
