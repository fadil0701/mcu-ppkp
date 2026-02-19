@extends('layouts.app')

@section('title', 'Dashboard MCU PPKP DKI Jakarta')

@section('content')
<x-common.page-breadcrumb pageTitle="Dashboard" />

<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <p class="text-theme-sm text-gray-500 dark:text-gray-400">Selamat datang, {{ Auth::user()->name }}</p>
    <small class="text-theme-xs text-gray-500 dark:text-gray-400">Terakhir diperbarui: {{ now()->format('d/m/Y H:i') }}</small>
</div>

<!-- KPI Cards -->
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4 mb-6">
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center gap-3">
            <span class="flex h-12 w-12 items-center justify-center rounded-lg bg-brand-50 dark:bg-brand-500/10">
                <svg class="h-6 w-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </span>
            <div>
                <p class="text-2xl font-semibold text-gray-800 dark:text-white/90">{{ $stats->total_participants ?? 0 }}</p>
                <p class="text-theme-sm text-gray-500 dark:text-gray-400">Total Peserta</p>
            </div>
        </div>
    </div>
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center gap-3">
            <span class="flex h-12 w-12 items-center justify-center rounded-lg bg-success-50 dark:bg-success-500/10">
                <svg class="h-6 w-6 text-success-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </span>
            <div>
                <p class="text-2xl font-semibold text-gray-800 dark:text-white/90">{{ $stats->scheduled_participants ?? 0 }}</p>
                <p class="text-theme-sm text-gray-500 dark:text-gray-400">Peserta Terjadwal</p>
            </div>
        </div>
    </div>
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center gap-3">
            <span class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-light-50 dark:bg-blue-light-500/10">
                <svg class="h-6 w-6 text-blue-light-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </span>
            <div>
                <p class="text-2xl font-semibold text-gray-800 dark:text-white/90">{{ $stats->completed_mcu ?? 0 }}</p>
                <p class="text-theme-sm text-gray-500 dark:text-gray-400">MCU Selesai</p>
            </div>
        </div>
    </div>
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center gap-3">
            <span class="flex h-12 w-12 items-center justify-center rounded-lg bg-warning-50 dark:bg-warning-500/10">
                <svg class="h-6 w-6 text-warning-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </span>
            <div>
                <p class="text-2xl font-semibold text-gray-800 dark:text-white/90">{{ $stats->pending_mcu ?? 0 }}</p>
                <p class="text-theme-sm text-gray-500 dark:text-gray-400">MCU Pending</p>
            </div>
        </div>
    </div>
</div>

<div class="grid gap-6 xl:grid-cols-3 mb-6">
    <!-- Chart MCU 6 Bulan -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] xl:col-span-2">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90 mb-4">Statistik MCU (6 Bulan)</h3>
        <div class="h-80">
            <canvas id="mcuChart"></canvas>
        </div>
    </div>
    <!-- Status Kesehatan -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90 mb-4">Status Kesehatan</h3>
        <div class="h-80">
            <canvas id="healthChart"></canvas>
        </div>
    </div>
</div>

<!-- Top SKPD -->
<x-common.component-card title="Statistik per SKPD (Top 5)" class="mb-6">
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-5">
        @forelse($topSkpds as $skpd)
        <div class="rounded-lg border border-gray-200 p-3 dark:border-gray-800">
            <p class="truncate text-theme-sm font-medium text-gray-800 dark:text-white/90" title="{{ $skpd->skpd }}">{{ $skpd->skpd }}</p>
            <p class="text-xl font-semibold text-brand-500">{{ $skpd->total_participants }}</p>
            <p class="text-theme-xs text-gray-500 dark:text-gray-400">Terjadwal: {{ $skpd->scheduled_count }} | Selesai: {{ $skpd->completed_count }}</p>
        </div>
        @empty
        <p class="col-span-full text-theme-sm text-gray-500 dark:text-gray-400">Belum ada data SKPD.</p>
        @endforelse
    </div>
</x-common.component-card>

<!-- Konfirmasi Hadir Hari Ini -->
<x-common.component-card title="Konfirmasi Hadir - Siap Diselesaikan (Hari Ini)" class="mb-6">
    @if($confirmedToday->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full text-theme-sm">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-800">
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Peserta</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">NIK</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Tanggal</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Jam</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Lokasi</th>
                    <th class="pb-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($confirmedToday as $s)
                <tr class="border-b border-gray-100 dark:border-gray-800">
                    <td class="py-3 text-gray-800 dark:text-white/90">{{ $s->participant->nama_lengkap ?? $s->nama_lengkap }}</td>
                    <td class="py-3 text-gray-600 dark:text-gray-400">{{ $s->nik_ktp }}</td>
                    <td class="py-3">{{ $s->tanggal_pemeriksaan?->format('d/m/Y') }}</td>
                    <td class="py-3">{{ $s->jam_pemeriksaan?->format('H:i') }}</td>
                    <td class="py-3 max-w-[200px] truncate" title="{{ $s->lokasi_pemeriksaan }}">{{ Str::limit($s->lokasi_pemeriksaan, 35) }}</td>
                    <td class="py-3">
                        <a href="{{ route('admin.schedules.edit', $s) }}" class="text-brand-500 hover:underline text-theme-sm">Tandai Selesai di Admin</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p class="text-theme-sm text-gray-500 dark:text-gray-400">Tidak ada peserta yang sudah konfirmasi hadir hari ini.</p>
    @endif
</x-common.component-card>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function() {
    const chartLabels = @json($chartLabels);
    const participantsData = @json($participantsByMonth);
    const mcuResultsData = @json($mcuResultsByMonth);

    new Chart(document.getElementById('mcuChart'), {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [
                { label: 'Peserta Baru', data: participantsData, borderColor: '#465fff', backgroundColor: 'rgba(70,95,255,0.2)', fill: true, tension: 0.35 },
                { label: 'Hasil MCU', data: mcuResultsData, borderColor: '#12b76a', backgroundColor: 'rgba(18,183,106,0.2)', fill: true, tension: 0.35 }
            ]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } },
            scales: { x: { grid: { display: false } }, y: { beginAtZero: true } }
        }
    });

    const healthStats = @json($healthStats);
    const healthLabels = healthStats.map(s => s.status_kesehatan || 'Lainnya');
    const healthCounts = healthStats.map(s => s.count);
    const healthColors = ['#12b76a', '#f79009', '#f04438', '#0ba5ec'];

    new Chart(document.getElementById('healthChart'), {
        type: 'doughnut',
        data: {
            labels: healthLabels,
            datasets: [{ data: healthCounts, backgroundColor: healthColors.slice(0, healthLabels.length) }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });
})();
</script>
@endpush
@endsection
