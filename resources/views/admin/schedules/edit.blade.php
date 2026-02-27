@extends('layouts.app')

@section('title', 'Edit Jadwal MCU')

@section('content')
<x-common.page-breadcrumb pageTitle="Edit Jadwal MCU" />

@if(session('success'))
    <div class="mb-4 rounded-lg border border-success-200 bg-success-50 p-4 text-theme-sm text-success-800 dark:border-success-800 dark:bg-success-500/10 dark:text-success-400">{{ session('success') }}</div>
@endif

<x-common.component-card title="Form Jadwal MCU">
    <form method="POST" action="{{ route('admin.schedules.update', $schedule) }}" class="space-y-4">
        @csrf
        <input type="hidden" name="_method" value="PUT">
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
                    :value="old('participant_id', $schedule->participant_id)"
                    :required="true"
                />
            </div>
            <div>
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Pemeriksaan *</label>
                <input type="date" name="tanggal_pemeriksaan" value="{{ old('tanggal_pemeriksaan', $schedule->tanggal_pemeriksaan?->format('Y-m-d')) }}" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
            </div>
            <div>
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Jam Pemeriksaan *</label>
                <input type="time" name="jam_pemeriksaan" value="{{ old('jam_pemeriksaan', $schedule->jam_pemeriksaan?->format('H:i')) }}" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
            </div>
            <div class="sm:col-span-2">
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Lokasi Pemeriksaan *</label>
                <input type="text" name="lokasi_pemeriksaan" value="{{ old('lokasi_pemeriksaan', $schedule->lokasi_pemeriksaan ?? config('mcu.default_location')) }}" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
                @error('lokasi_pemeriksaan')<p class="mt-1 text-theme-xs text-error-500">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Status *</label>
                <select name="status" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
                    <option value="Terjadwal" {{ old('status', $schedule->status) === 'Terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                    <option value="Selesai" {{ old('status', $schedule->status) === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Batal" {{ old('status', $schedule->status) === 'Batal' ? 'selected' : '' }}>Batal</option>
                    <option value="Ditolak" {{ old('status', $schedule->status) === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div>
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">No. Antrian</label>
                <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-gray-300">
                    @if(in_array($schedule->status, ['Terjadwal', 'Selesai']) && $schedule->queue_number)
                        {{ $schedule->queue_number }} <span class="ml-1 text-theme-xs text-gray-500">(otomatis per tanggal &amp; lokasi)</span>
                    @else
                        <span class="text-gray-500">Otomatis diisi saat disimpan</span>
                    @endif
                </div>
            </div>
            <div class="sm:col-span-2">
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Catatan</label>
                <textarea name="catatan" rows="2" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">{{ old('catatan', $schedule->catatan) }}</textarea>
            </div>
        </div>
        <div class="flex gap-2 pt-4">
            <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-theme-sm font-medium text-white hover:bg-brand-600">Simpan</button>
            <a href="{{ route('admin.schedules.index') }}" class="rounded-lg border border-gray-200 px-4 py-2 text-theme-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-300 dark:hover:bg-white/5">Batal</a>
        </div>
    </form>
</x-common.component-card>
@endsection
