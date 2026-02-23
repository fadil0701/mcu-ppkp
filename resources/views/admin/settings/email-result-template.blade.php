@extends('layouts.app')

@section('title', 'Template Email Hasil MCU')

@section('content')
<x-common.page-breadcrumb pageTitle="Template Email Hasil MCU" />

@if(session('success'))
    <div class="mb-4 rounded-lg border border-success-200 bg-success-50 p-4 text-theme-sm text-success-800 dark:border-success-800 dark:bg-success-500/10 dark:text-success-400">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="mb-4 rounded-lg border border-error-200 bg-error-50 p-4 text-theme-sm text-error-800 dark:border-error-800 dark:bg-error-500/10 dark:text-error-400">{{ session('error') }}</div>
@endif

<x-common.component-card title="Template Pengiriman Hasil MCU via Email">
    <p class="mb-4 text-theme-sm text-gray-600 dark:text-gray-400">
        Template ini digunakan sebagai fallback saat mengirim hasil MCU via email, jika belum ada template tipe "Hasil MCU" di <a href="{{ route('admin.email-templates.index', ['type' => 'mcu_result']) }}" class="text-brand-500 hover:underline">Email Templates</a>.
    </p>
    <p class="mb-4 text-theme-sm text-gray-600 dark:text-gray-400">
        Variabel: <code class="rounded bg-gray-100 px-1 dark:bg-gray-800">{participant_name}, {participant_email}, {participant_phone}, {tanggal_pemeriksaan}, {status_kesehatan}, {diagnosis}, {rekomendasi}, {hasil_url}, {app_name}</code>
    </p>

    <form method="POST" action="{{ route('admin.settings.update-email-result-template') }}" class="space-y-4">
        @csrf
        <div>
            <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Subject Email <span class="text-error-500">*</span></label>
            <input type="text" name="email_result_subject" value="{{ old('email_result_subject', $subject) }}" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90" placeholder="Hasil MCU Anda Tersedia">
            @error('email_result_subject')<p class="mt-1 text-theme-xs text-error-500">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Body Email (Plain Text) <span class="text-error-500">*</span></label>
            <textarea name="email_result_template" rows="12" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90" placeholder="Kepada {participant_name}, ...">{{ old('email_result_template', $body) }}</textarea>
            @error('email_result_template')<p class="mt-1 text-theme-xs text-error-500">{{ $message }}</p>@enderror
        </div>
        <div class="flex gap-2">
            <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-theme-sm font-medium text-white hover:bg-brand-600">Simpan Template</button>
            <a href="{{ route('admin.settings.index') }}" class="rounded-lg border border-gray-200 px-4 py-2 text-theme-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-300 dark:hover:bg-white/5">Kembali ke Pengaturan</a>
        </div>
    </form>
</x-common.component-card>
@endsection
