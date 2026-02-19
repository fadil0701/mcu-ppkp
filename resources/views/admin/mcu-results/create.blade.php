@extends('layouts.app')

@section('title', 'Tambah Hasil MCU')

@section('content')
<x-common.page-breadcrumb pageTitle="Tambah Hasil MCU" />

<x-common.component-card title="Form Hasil MCU">
    <form method="POST" action="{{ route('admin.mcu-results.store') }}" class="space-y-4">
        @csrf
        <div class="grid gap-4 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <x-form.searchable-select
                    name="participant_id"
                    label="Peserta *"
                    :options="$participants"
                    value-key="id"
                    label-key="nama_lengkap"
                    sublabel-key="nik_ktp"
                    placeholder="-- Pilih Peserta --"
                    :value="old('participant_id', $participantId ?? '')"
                    :required="true"
                />
            </div>
            <div>
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Pemeriksaan *</label>
                <input type="date" name="tanggal_pemeriksaan" value="{{ old('tanggal_pemeriksaan', now()->format('Y-m-d')) }}" max="{{ now()->format('Y-m-d') }}" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
            </div>
            <div>
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Status Kesehatan *</label>
                <select name="status_kesehatan" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
                    <option value="Sehat" {{ old('status_kesehatan') === 'Sehat' ? 'selected' : '' }}>Sehat</option>
                    <option value="Kurang Sehat" {{ old('status_kesehatan') === 'Kurang Sehat' ? 'selected' : '' }}>Kurang Sehat</option>
                    <option value="Tidak Sehat" {{ old('status_kesehatan') === 'Tidak Sehat' ? 'selected' : '' }}>Tidak Sehat</option>
                </select>
            </div>
            <div class="sm:col-span-2">
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Diagnosis</label>
                <input type="text" name="diagnosis" value="{{ old('diagnosis') }}" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
            </div>
            <div class="sm:col-span-2">
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Hasil Pemeriksaan</label>
                <textarea name="hasil_pemeriksaan" rows="3" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">{{ old('hasil_pemeriksaan') }}</textarea>
            </div>
            <div class="sm:col-span-2">
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Rekomendasi</label>
                <textarea name="rekomendasi" rows="2" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">{{ old('rekomendasi') }}</textarea>
            </div>
            <div>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }} class="rounded border-gray-300">
                    <span class="text-theme-sm text-gray-700 dark:text-gray-300">Publikasikan ke peserta</span>
                </label>
            </div>
        </div>
        <div class="flex gap-2 pt-4">
            <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-theme-sm font-medium text-white hover:bg-brand-600">Simpan</button>
            <a href="{{ route('admin.mcu-results.index') }}" class="rounded-lg border border-gray-200 px-4 py-2 text-theme-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-300 dark:hover:bg-white/5">Batal</a>
        </div>
    </form>
</x-common.component-card>
@endsection
