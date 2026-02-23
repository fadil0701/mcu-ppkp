<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\ParticipantController as AdminParticipantController;
use App\Http\Controllers\Admin\ScheduleController as AdminScheduleController;
use App\Http\Controllers\Admin\McuResultController as AdminMcuResultController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\DiagnosisController as AdminDiagnosisController;
use App\Http\Controllers\Admin\SpecialistDoctorController as AdminSpecialistDoctorController;
use App\Http\Controllers\Admin\RescheduleCenterController as AdminRescheduleCenterController;
use App\Http\Controllers\Admin\AdminNotificationsController as AdminNotificationsController;
use App\Http\Controllers\Admin\WhatsAppTemplatesController as AdminWhatsAppTemplatesController;
use App\Http\Controllers\Admin\EmailTemplateController as AdminEmailTemplateController;
use App\Http\Controllers\Admin\PdfTemplateController as AdminPdfTemplateController;
use App\Http\Controllers\McuResultDownloadController;
use Illuminate\Support\Facades\Route;

// Redirect root to welcome page
Route::view('/', 'welcome')->name('home');

Route::middleware('auth')->group(function () {
    // Satu dashboard untuk semua role (admin & peserta), tanpa Filament — didaftarkan paling awal
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Client routes (redirect lama /client/dashboard ke /dashboard)
Route::prefix('client')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', fn () => redirect()->route('dashboard'))->name('client.dashboard');
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

// Admin panel (Blade + TailAdmin) — pengganti Filament
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::post('participants/import', [AdminParticipantController::class, 'import'])->name('participants.import');
    Route::post('participants/bulk-delete', [AdminParticipantController::class, 'bulkDestroy'])->name('participants.bulk-destroy');
    Route::resource('participants', AdminParticipantController::class);
    Route::post('schedules/bulk-delete', [AdminScheduleController::class, 'bulkDestroy'])->name('schedules.bulk-destroy');
    Route::post('schedules/{schedule}/quick-status', [AdminScheduleController::class, 'quickStatus'])->name('schedules.quick-status');
    Route::post('schedules/{schedule}/send-email', [AdminScheduleController::class, 'sendEmail'])->name('schedules.send-email');
    Route::post('schedules/{schedule}/send-whatsapp', [AdminScheduleController::class, 'sendWhatsApp'])->name('schedules.send-whatsapp');
    Route::resource('schedules', AdminScheduleController::class);
    Route::post('mcu-results/{mcu_result}', [AdminMcuResultController::class, 'update'])->name('mcu-results.update-post');
    Route::post('mcu-results/{mcu_result}/send-email', [AdminMcuResultController::class, 'sendEmail'])->name('mcu-results.send-email');
    Route::post('mcu-results/{mcu_result}/send-whatsapp', [AdminMcuResultController::class, 'sendWhatsApp'])->name('mcu-results.send-whatsapp');
    Route::resource('mcu-results', AdminMcuResultController::class)->parameters(['mcu-results' => 'mcu_result']);
    Route::resource('users', AdminUserController::class);
    Route::get('diagnoses/template', [AdminDiagnosisController::class, 'downloadTemplate'])->name('diagnoses.template');
    Route::post('diagnoses/import', [AdminDiagnosisController::class, 'import'])->name('diagnoses.import');
    Route::resource('diagnoses', AdminDiagnosisController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('specialist-doctors', AdminSpecialistDoctorController::class)->parameters(['specialist-doctors' => 'specialist_doctor'])->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('email-templates', AdminEmailTemplateController::class)->parameters(['email-templates' => 'email_template'])->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('pdf-templates', AdminPdfTemplateController::class)->parameters(['pdf-templates' => 'pdf_template'])->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::get('settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::get('settings/email-result-template', [AdminSettingController::class, 'emailResultTemplate'])->name('settings.email-result-template');
    Route::post('settings/email-result-template', [AdminSettingController::class, 'updateEmailResultTemplate'])->name('settings.update-email-result-template');
    Route::get('settings/create', [AdminSettingController::class, 'create'])->name('settings.create');
    Route::post('settings', [AdminSettingController::class, 'store'])->name('settings.store');
    Route::get('settings/{setting}/edit', [AdminSettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings/{setting}', [AdminSettingController::class, 'update'])->name('settings.update');
    Route::patch('settings/{setting}', [AdminSettingController::class, 'update']);

    Route::get('reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('reports/download/{type}', [AdminReportController::class, 'download'])->name('reports.download');

    Route::get('reschedule-center', [AdminRescheduleCenterController::class, 'index'])->name('reschedule-center.index');
    Route::post('reschedule-center/{schedule}/approve', [AdminRescheduleCenterController::class, 'approve'])->name('reschedule-center.approve');
    Route::post('reschedule-center/{schedule}/reject', [AdminRescheduleCenterController::class, 'reject'])->name('reschedule-center.reject');

    Route::get('notifications', [AdminNotificationsController::class, 'index'])->name('notifications.index');
    Route::post('notifications/{id}/read', [AdminNotificationsController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('notifications/mark-all-read', [AdminNotificationsController::class, 'markAllAsRead'])->name('notifications.mark-all-read');

    Route::get('whatsapp-templates', [AdminWhatsAppTemplatesController::class, 'index'])->name('whatsapp-templates.index');
    Route::post('whatsapp-templates', [AdminWhatsAppTemplatesController::class, 'update'])->name('whatsapp-templates.update');
    Route::post('whatsapp-templates/result', [AdminWhatsAppTemplatesController::class, 'updateResult'])->name('whatsapp-templates.update-result');
    Route::post('whatsapp-templates/reset', [AdminWhatsAppTemplatesController::class, 'reset'])->name('whatsapp-templates.reset');
    Route::post('whatsapp-templates/reset-result', [AdminWhatsAppTemplatesController::class, 'resetResult'])->name('whatsapp-templates.reset-result');

    Route::get('mcu-results/{record}/download-all', [McuResultDownloadController::class, 'downloadAll'])->name('mcu-results.downloadAll');
});

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

// Aktivasi akun peserta (belum punya akun login)
Route::middleware('guest')->group(function () {
    Route::get('/peserta/aktivasi-akun', [\App\Http\Controllers\PesertaActivationController::class, 'showVerificationForm'])->name('peserta.aktivasi');
    Route::post('/peserta/aktivasi-akun', [\App\Http\Controllers\PesertaActivationController::class, 'verifyParticipant']);
    Route::get('/peserta/aktivasi-akun/register', [\App\Http\Controllers\PesertaActivationController::class, 'showRegisterForm'])->name('peserta.aktivasi.register');
    Route::post('/peserta/aktivasi-akun/register', [\App\Http\Controllers\PesertaActivationController::class, 'registerAccount']);
});

require __DIR__.'/auth.php';
