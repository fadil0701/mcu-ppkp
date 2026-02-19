@extends('layouts.app')

@section('title', 'Dashboard MCU - PPKP DKI Jakarta')

@section('content')
<x-common.page-breadcrumb pageTitle="Dashboard" />

<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-xl font-semibold text-gray-800 dark:text-white/90">Selamat Datang, {{ Auth::user()->name }}!</h1>
        <p class="text-theme-sm text-gray-500 dark:text-gray-400">Dashboard monitoring MCU PPKP DKI Jakarta</p>
    </div>
    <small class="text-theme-xs text-gray-500 dark:text-gray-400">Terakhir diperbarui: {{ now()->format('d/m/Y H:i') }}</small>
</div>

@php
    $myTodayQueues = $schedules->filter(fn($s) => $s->tanggal_pemeriksaan && $s->tanggal_pemeriksaan->isToday() && $s->status === 'Terjadwal' && !is_null($s->queue_number))->sortBy('queue_number');
    $myQueueNumber = optional($myTodayQueues->first())->queue_number;
@endphp

<!-- KPI Cards -->
<div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7 mb-6">
    <div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
        <p class="text-2xl font-semibold text-gray-800 dark:text-white/90">{{ $participant ? '1' : '0' }}</p>
        <p class="text-theme-sm text-gray-500 dark:text-gray-400">Status Pendaftaran</p>
    </div>
    <div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
        <p class="text-2xl font-semibold text-gray-800 dark:text-white/90">{{ $schedules->count() }}</p>
        <p class="text-theme-sm text-gray-500 dark:text-gray-400">Jadwal MCU</p>
    </div>
    <div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
        <p class="text-2xl font-semibold text-gray-800 dark:text-white/90">{{ $mcuResults->count() }}</p>
        <p class="text-theme-sm text-gray-500 dark:text-gray-400">Hasil MCU</p>
    </div>
    <div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
        <p class="text-xl font-semibold text-gray-800 dark:text-white/90">
            @if($participant && $participant->tanggal_mcu_terakhir)
                {{ \Carbon\Carbon::parse($participant->tanggal_mcu_terakhir)->diffForHumans() }}
            @else
                Belum MCU
            @endif
        </p>
        <p class="text-theme-sm text-gray-500 dark:text-gray-400">MCU Terakhir</p>
    </div>
    <div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
        <p class="text-2xl font-semibold text-gray-800 dark:text-white/90">{{ $todayQueueTotal ?? 0 }}</p>
        <p class="text-theme-sm text-gray-500 dark:text-gray-400">Antrian Hari Ini</p>
    </div>
    <div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
        <p class="text-2xl font-semibold text-gray-800 dark:text-white/90">{{ $schedules->where('status', 'Ditolak')->count() }}</p>
        <p class="text-theme-sm text-gray-500 dark:text-gray-400">Jadwal Ditolak</p>
    </div>
    <div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
        <p class="text-2xl font-semibold text-gray-800 dark:text-white/90">{{ $myQueueNumber ?? '-' }}</p>
        <p class="text-theme-sm text-gray-500 dark:text-gray-400">No. Antrian Saya</p>
    </div>
</div>

<div class="grid gap-6 lg:grid-cols-2 mb-6">
    <!-- Status Profile -->
    <x-common.component-card title="Status Profile">
        @if($participant)
            <div class="flex items-center gap-4 mb-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-brand-100 text-xl font-semibold text-brand-600 dark:bg-brand-500/20 dark:text-brand-400">
                    {{ strtoupper(substr($participant->nama_lengkap, 0, 1)) }}
                </div>
                <div>
                    <p class="font-medium text-gray-800 dark:text-white/90">{{ $participant->nama_lengkap }}</p>
                    <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ $participant->skpd }}</p>
                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-theme-xs font-medium bg-success-100 text-success-700 dark:bg-success-500/20 dark:text-success-400">{{ $participant->status_mcu }}</span>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3 text-theme-sm">
                <div><span class="text-gray-500 dark:text-gray-400">NIK KTP</span><p class="font-medium text-gray-800 dark:text-white/90">{{ $participant->nik_ktp }}</p></div>
                <div><span class="text-gray-500 dark:text-gray-400">Status Pegawai</span><p class="font-medium text-gray-800 dark:text-white/90">{{ $participant->status_pegawai }}</p></div>
                <div><span class="text-gray-500 dark:text-gray-400">Umur</span><p class="font-medium text-gray-800 dark:text-white/90">{{ $participant->umur }} tahun</p></div>
                <div><span class="text-gray-500 dark:text-gray-400">Jenis Kelamin</span><p class="font-medium text-gray-800 dark:text-white/90">{{ $participant->jenis_kelamin_text }}</p></div>
            </div>
            <a href="{{ route('client.profile') }}" class="mt-4 inline-flex w-full justify-center rounded-lg bg-brand-500 px-4 py-2.5 text-theme-sm font-medium text-white hover:bg-brand-600">Lihat Profile Lengkap</a>
        @else
            <div class="py-6 text-center">
                <p class="text-theme-sm text-gray-500 dark:text-gray-400 mb-3">Data Profile Belum Lengkap. Silakan lengkapi data profile Anda untuk dapat mengakses fitur MCU.</p>
                <a href="{{ route('client.profile') }}" class="inline-flex rounded-lg bg-brand-500 px-4 py-2.5 text-theme-sm font-medium text-white hover:bg-brand-600">Lengkapi Profile</a>
            </div>
        @endif
    </x-common.component-card>

    <!-- Aksi Cepat -->
    <x-common.component-card title="Aksi Cepat">
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">
            <a href="{{ route('client.schedules') }}" class="flex flex-col items-center justify-center rounded-lg border border-gray-200 py-4 text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-300 dark:hover:bg-white/5">
                <svg class="mb-2 h-8 w-8 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span class="text-theme-sm">Jadwal MCU</span>
            </a>
            <a href="{{ route('client.results') }}" class="flex flex-col items-center justify-center rounded-lg border border-gray-200 py-4 text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-300 dark:hover:bg-white/5">
                <svg class="mb-2 h-8 w-8 text-success-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span class="text-theme-sm">Hasil MCU</span>
            </a>
            <a href="{{ route('client.schedule.request') }}" class="flex flex-col items-center justify-center rounded-lg border border-gray-200 py-4 text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-300 dark:hover:bg-white/5">
                <svg class="mb-2 h-8 w-8 text-warning-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                <span class="text-theme-sm">Daftar Ulang MCU</span>
            </a>
            <a href="{{ route('client.profile') }}" class="flex flex-col items-center justify-center rounded-lg border border-gray-200 py-4 text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-300 dark:hover:bg-white/5">
                <svg class="mb-2 h-8 w-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span class="text-theme-sm">Profile</span>
            </a>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex flex-col items-center justify-center rounded-lg border border-gray-200 py-4 text-gray-700 hover:bg-error-50 hover:border-error-200 dark:border-gray-800 dark:hover:bg-error-500/10">
                <svg class="mb-2 h-8 w-8 text-error-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                <span class="text-theme-sm">Keluar</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </div>
    </x-common.component-card>
</div>

<div class="grid gap-6 lg:grid-cols-2">
    <!-- Jadwal MCU Terdekat -->
    <x-common.component-card title="Jadwal MCU Terdekat">
        @if($schedules->count() > 0)
            @foreach($schedules->take(3) as $schedule)
                <div class="flex items-center gap-3 rounded-lg border border-gray-200 p-3 dark:border-gray-800 mb-3">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-brand-100 text-brand-600 dark:bg-brand-500/20 dark:text-brand-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="font-medium text-gray-800 dark:text-white/90">{{ $schedule->tanggal_pemeriksaan_formatted ?? $schedule->tanggal_pemeriksaan?->format('d/m/Y') }}</p>
                        <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ $schedule->jam_pemeriksaan_formatted ?? $schedule->jam_pemeriksaan?->format('H:i') }} - {{ Str::limit($schedule->lokasi_pemeriksaan, 40) }}</p>
                        <span class="inline-flex rounded-full px-2 py-0.5 text-theme-xs font-medium
                            @if(($schedule->status_color ?? '') === 'success') bg-success-100 text-success-700 dark:bg-success-500/20 dark:text-success-400
                            @elseif(($schedule->status_color ?? '') === 'warning') bg-warning-100 text-warning-700 dark:bg-warning-500/20 dark:text-warning-400
                            @else bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 @endif">{{ $schedule->status }}</span>
                    </div>
                </div>
            @endforeach
            <a href="{{ route('client.schedules') }}" class="mt-2 inline-flex w-full justify-center rounded-lg border border-brand-500 py-2.5 text-theme-sm font-medium text-brand-500 hover:bg-brand-50 dark:hover:bg-brand-500/10">Lihat Semua Jadwal</a>
        @else
            <div class="py-6 text-center text-theme-sm text-gray-500 dark:text-gray-400">
                <p>Belum Ada Jadwal MCU. Jadwal MCU akan muncul setelah Anda didaftarkan oleh administrator.</p>
            </div>
        @endif
    </x-common.component-card>

    <!-- Hasil MCU Terbaru -->
    <x-common.component-card title="Hasil MCU Terbaru">
        @if($mcuResults->count() > 0)
            @foreach($mcuResults->take(3) as $result)
                @php $dx = $result->diagnosis_text ?? null; @endphp
                <div class="flex items-center gap-3 rounded-lg border border-gray-200 p-3 dark:border-gray-800 mb-3">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-success-100 text-success-600 dark:bg-success-500/20 dark:text-success-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="font-medium text-gray-800 dark:text-white/90">{{ $result->tanggal_pemeriksaan_formatted ?? $result->tanggal_pemeriksaan?->format('d/m/Y') }}</p>
                        <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ $dx && $dx !== '-' ? Str::limit($dx, 40) : 'Tidak ada diagnosis' }}</p>
                        <span class="inline-flex rounded-full px-2 py-0.5 text-theme-xs font-medium bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">{{ $result->status_kesehatan }}</span>
                    </div>
                </div>
            @endforeach
            <a href="{{ route('client.results') }}" class="mt-2 inline-flex w-full justify-center rounded-lg border border-success-500 py-2.5 text-theme-sm font-medium text-success-600 hover:bg-success-50 dark:hover:bg-success-500/10">Lihat Semua Hasil</a>
        @else
            <div class="py-6 text-center text-theme-sm text-gray-500 dark:text-gray-400">
                <p>Belum Ada Hasil MCU. Hasil MCU akan muncul setelah pemeriksaan selesai dan diupload oleh administrator.</p>
            </div>
        @endif
    </x-common.component-card>
</div>
@endsection
