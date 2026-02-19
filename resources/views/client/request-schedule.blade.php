@extends('layouts.app')

@section('title', 'Pendaftaran Ulang MCU')

@section('content')
<x-common.page-breadcrumb pageTitle="Pendaftaran Ulang MCU" />

@if (session('success'))
    <div class="mb-4 rounded-lg border border-success-200 bg-success-50 p-4 text-theme-sm text-success-800 dark:border-success-800 dark:bg-success-500/10 dark:text-success-400">{{ session('success') }}</div>
@endif
@if ($errors->any())
    <div class="mb-4 rounded-lg border border-error-200 bg-error-50 p-4 text-theme-sm text-error-800 dark:border-error-800 dark:bg-error-500/10 dark:text-error-400">
        <ul class="list-inside list-disc">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(!$eligible)
    <div class="mb-4 rounded-lg border border-warning-200 bg-warning-50 p-4 text-theme-sm text-warning-800 dark:border-warning-800 dark:bg-warning-500/10 dark:text-warning-400">
        {{ $reason }}
    </div>
@endif

<div class="grid gap-6 lg:grid-cols-3">
    <div class="lg:col-span-2">
        <x-common.component-card title="Form Pengajuan Jadwal">
            <form method="POST" action="{{ route('client.schedule.request.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Pemeriksaan</label>
                    <input type="date" name="tanggal_pemeriksaan" value="{{ old('tanggal_pemeriksaan') }}"
                        class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90"
                        {{ $eligible ? '' : 'disabled' }} required>
                </div>
                <div>
                    <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Jam Pemeriksaan</label>
                    <input type="time" name="jam_pemeriksaan" value="{{ old('jam_pemeriksaan') }}"
                        class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90"
                        {{ $eligible ? '' : 'disabled' }} required>
                </div>
                <div>
                    <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Lokasi Pemeriksaan</label>
                    <input type="hidden" name="lokasi_pemeriksaan" value="{{ config('mcu.default_location') }}">
                    <p class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-theme-sm text-gray-700 dark:border-gray-800 dark:bg-gray-800 dark:text-gray-300">{{ config('mcu.default_location') }}</p>
                </div>
                <div>
                    <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Catatan (opsional)</label>
                    <textarea name="catatan" rows="3" {{ $eligible ? '' : 'disabled' }}
                        class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">{{ old('catatan') }}</textarea>
                </div>
                <button type="submit" class="w-full rounded-lg bg-brand-500 px-4 py-2.5 text-theme-sm font-medium text-white hover:bg-brand-600 disabled:opacity-50" {{ $eligible ? '' : 'disabled' }}>
                    Ajukan Jadwal
                </button>
            </form>
        </x-common.component-card>
    </div>
    <div>
        <x-common.component-card title="Status Kelayakan">
            <ul class="space-y-3 text-theme-sm">
                <li class="flex items-center gap-2 text-gray-800 dark:text-white/90">{{ $participant->nama_lengkap }}</li>
                <li class="flex items-center gap-2 text-gray-600 dark:text-gray-400">NIK: {{ $participant->nik_ktp }}</li>
                <li class="flex items-center gap-2 text-gray-600 dark:text-gray-400">{{ $participant->skpd }}</li>
                <li class="flex items-center gap-2 text-gray-600 dark:text-gray-400">Terakhir MCU: {{ $participant->tanggal_mcu_terakhir_formatted }}</li>
                <li class="flex items-center gap-2">
                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-theme-xs font-medium {{ $eligible ? 'bg-success-100 text-success-700 dark:bg-success-500/20 dark:text-success-400' : 'bg-warning-100 text-warning-700 dark:bg-warning-500/20 dark:text-warning-400' }}">
                        Kelayakan: {{ $eligible ? 'Memenuhi syarat' : 'Belum memenuhi' }}
                    </span>
                </li>
            </ul>
        </x-common.component-card>
    </div>
</div>
@endsection
