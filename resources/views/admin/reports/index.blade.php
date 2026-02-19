@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<x-common.page-breadcrumb pageTitle="Laporan" />

<x-common.component-card title="Download Laporan Excel">
    <p class="mb-4 text-theme-sm text-gray-500 dark:text-gray-400">Pilih filter (opsional) lalu klik tombol download.</p>
    <form method="GET" class="mb-6 flex flex-wrap items-end gap-4">
        <div>
            <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Mulai</label>
            <input type="date" name="start_date" value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}" class="rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
        </div>
        <div>
            <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Selesai</label>
            <input type="date" name="end_date" value="{{ request('end_date', now()->format('Y-m-d')) }}" class="rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
        </div>
        <div>
            <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">SKPD</label>
            <select name="skpd" class="rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90 w-48">
                <option value="">Semua SKPD</option>
                @foreach($skpds as $k => $v)
                    <option value="{{ $k }}" {{ request('skpd') === $k ? 'selected' : '' }}>{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Status Pegawai</label>
            <select name="status_pegawai" class="rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
                <option value="">Semua</option>
                <option value="PNS" {{ request('status_pegawai') === 'PNS' ? 'selected' : '' }}>PNS</option>
                <option value="CPNS" {{ request('status_pegawai') === 'CPNS' ? 'selected' : '' }}>CPNS</option>
                <option value="PPPK" {{ request('status_pegawai') === 'PPPK' ? 'selected' : '' }}>PPPK</option>
            </select>
        </div>
    </form>

    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
        @php
            $query = request()->query();
            $queryStr = http_build_query($query);
        @endphp
        <a href="{{ route('admin.reports.download', ['type' => 'participants'] + $query) }}" class="flex items-center gap-3 rounded-lg border border-gray-200 bg-white p-4 hover:bg-gray-50 dark:border-gray-800 dark:bg-white/[0.03] dark:hover:bg-white/5">
            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand-100 text-brand-600 dark:bg-brand-500/20 dark:text-brand-400">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </span>
            <span class="font-medium text-gray-800 dark:text-white/90">Download Peserta</span>
        </a>
        <a href="{{ route('admin.reports.download', ['type' => 'schedules'] + $query) }}" class="flex items-center gap-3 rounded-lg border border-gray-200 bg-white p-4 hover:bg-gray-50 dark:border-gray-800 dark:bg-white/[0.03] dark:hover:bg-white/5">
            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-success-100 text-success-600 dark:bg-success-500/20 dark:text-success-400">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </span>
            <span class="font-medium text-gray-800 dark:text-white/90">Download Jadwal</span>
        </a>
        <a href="{{ route('admin.reports.download', ['type' => 'mcu'] + $query) }}" class="flex items-center gap-3 rounded-lg border border-gray-200 bg-white p-4 hover:bg-gray-50 dark:border-gray-800 dark:bg-white/[0.03] dark:hover:bg-white/5">
            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-light-100 text-blue-light-600 dark:bg-blue-light-500/20 dark:text-blue-light-400">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </span>
            <span class="font-medium text-gray-800 dark:text-white/90">Download Hasil MCU</span>
        </a>
        <a href="{{ route('admin.reports.download', ['type' => 'diagnoses'] + $query) }}" class="flex items-center gap-3 rounded-lg border border-gray-200 bg-white p-4 hover:bg-gray-50 dark:border-gray-800 dark:bg-white/[0.03] dark:hover:bg-white/5">
            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-warning-100 text-warning-600 dark:bg-warning-500/20 dark:text-warning-400">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </span>
            <span class="font-medium text-gray-800 dark:text-white/90">Download Diagnosis</span>
        </a>
    </div>
</x-common.component-card>
@endsection
