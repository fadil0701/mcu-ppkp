@extends('layouts.app')

@section('title', 'WhatsApp Template Undangan')

@section('content')
<x-common.page-breadcrumb pageTitle="WhatsApp Template Undangan" />

@if(session('success'))
    <div class="mb-4 rounded-lg border border-success-200 bg-success-50 p-4 text-theme-sm text-success-800 dark:border-success-800 dark:bg-success-500/10 dark:text-success-400">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="mb-4 rounded-lg border border-error-200 bg-error-50 p-4 text-theme-sm text-error-800 dark:border-error-800 dark:bg-error-500/10 dark:text-error-400">{{ session('error') }}</div>
@endif

<x-common.component-card title="Template Undangan MCU">
    <p class="mb-2 text-theme-sm text-gray-600 dark:text-gray-400">Variabel yang tersedia: <code class="rounded bg-gray-100 px-1 dark:bg-gray-800">{nama_lengkap}, {nik_ktp}, {nrk_pegawai}, {tanggal_pemeriksaan}, {jam_pemeriksaan}, {lokasi_pemeriksaan}, {queue_number}, {skpd}, {ukpd}, {no_telp}, {email}</code></p>

    <form method="POST" action="{{ route('admin.whatsapp-templates.update') }}" class="space-y-4">
        @csrf
        <div>
            <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Template Undangan WhatsApp <span class="text-error-500">*</span></label>
            <textarea name="invitation_template" rows="12" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90" placeholder="Contoh: Halo {nama_lengkap}, Anda diundang...">{{ old('invitation_template', $invitation_template) }}</textarea>
            @error('invitation_template')<p class="mt-1 text-theme-xs text-error-500">{{ $message }}</p>@enderror
        </div>
        <div class="flex gap-2">
            <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-theme-sm font-medium text-white hover:bg-brand-600">Simpan Template</button>
            <a href="{{ route('admin.settings.index') }}" class="rounded-lg border border-gray-200 px-4 py-2 text-theme-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-300 dark:hover:bg-white/5">Kembali ke Pengaturan</a>
        </div>
    </form>

    <form method="POST" action="{{ route('admin.whatsapp-templates.reset') }}" class="mt-4 inline" onsubmit="return confirm('Reset template ke default?');">
        @csrf
        <button type="submit" class="rounded-lg border border-gray-300 px-4 py-2 text-theme-sm font-medium text-gray-600 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-400 dark:hover:bg-gray-800">Reset ke Default</button>
    </form>
</x-common.component-card>
@endsection
