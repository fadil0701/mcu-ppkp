@extends('layouts.app')

@section('title', 'Dashboard MCU PPKP DKI Jakarta')

@section('content')
<x-common.page-breadcrumb pageTitle="Dashboard" />

@if(session('success'))
    <div class="mb-4 rounded-lg border border-success-200 bg-success-50 p-4 text-theme-sm text-success-800 dark:border-success-800 dark:bg-success-500/10 dark:text-success-400">{{ session('success') }}</div>
@endif

<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <p class="text-theme-sm text-gray-500 dark:text-gray-400">Selamat datang, {{ Auth::user()->name }}</p>
    <small class="text-theme-xs text-gray-500 dark:text-gray-400">Terakhir diperbarui: {{ now()->format('d/m/Y H:i') }}</small>
</div>

<!-- KPI Cards Utama -->
<div class="grid grid-cols-2 gap-3 min-w-0 sm:gap-4 lg:grid-cols-4 mb-6">
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

<!-- Statistik Hari Ini (Konfirmasi & Reschedule) -->
<div class="grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-2 mb-6">
    <a href="#antrian-hari-ini" class="rounded-2xl border border-gray-200 bg-white p-4 transition hover:border-brand-300 dark:border-gray-800 dark:bg-white/[0.03] dark:hover:border-brand-500/50 sm:p-5">
        <div class="flex items-center gap-3">
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-success-50 dark:bg-success-500/10 sm:h-12 sm:w-12">
                <svg class="h-5 w-5 text-success-500 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </span>
            <div class="min-w-0">
                <p class="text-xl font-semibold text-gray-800 dark:text-white/90 sm:text-2xl">{{ $confirmedTodayCount ?? 0 }}</p>
                <p class="truncate text-theme-sm text-gray-500 dark:text-gray-400">Konfirmasi Hadir (Hari Ini)</p>
            </div>
        </div>
    </a>
    @php $canReschedule = Auth::user()->hasRole('super_admin'); @endphp
    <a href="{{ $canReschedule ? route('admin.reschedule-center.index') : '#' }}" class="rounded-2xl border border-gray-200 bg-white p-4 transition sm:p-5 {{ $canReschedule ? 'hover:border-brand-300 dark:hover:border-brand-500/50' : 'cursor-default opacity-90' }} dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center gap-3">
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-warning-50 dark:bg-warning-500/10 sm:h-12 sm:w-12">
                <svg class="h-5 w-5 text-warning-500 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </span>
            <div class="min-w-0">
                <p class="text-xl font-semibold text-gray-800 dark:text-white/90 sm:text-2xl">{{ $pendingRescheduleToday ?? 0 }}</p>
                <p class="truncate text-theme-sm text-gray-500 dark:text-gray-400">{{ $canReschedule ? 'Permintaan Reschedule →' : 'Permintaan Reschedule (Hari Ini)' }}</p>
            </div>
        </div>
    </a>
</div>

<!-- Charts -->
<div class="grid gap-4 min-w-0 sm:gap-6 xl:grid-cols-3 mb-6">
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

<!-- Grafik Antrian Hari Ini (per Jam) -->
<div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03] mb-6 sm:p-5">
    <h3 class="text-base font-medium text-gray-800 dark:text-white/90 mb-4">Grafik Antrian Hari Ini (per Jam)</h3>
    <div class="h-64">
        <canvas id="dailyQueueChart"></canvas>
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

<!-- Antrian MCU Hari Ini -->
<x-common.component-card id="antrian-hari-ini" title="Antrian MCU Hari Ini" class="mb-6 scroll-mt-4">
    @if($todayQueue->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full text-theme-sm">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-800">
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Peserta</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">NIK</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Jam</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Lokasi</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">No.</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Status</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($todayQueue as $s)
                <tr class="border-b border-gray-100 dark:border-gray-800">
                    <td class="py-3 text-gray-800 dark:text-white/90">{{ $s->participant->nama_lengkap ?? $s->nama_lengkap }}</td>
                    <td class="py-3 text-gray-600 dark:text-gray-400">{{ $s->nik_ktp }}</td>
                    <td class="py-3">{{ $s->jam_pemeriksaan ? \Carbon\Carbon::parse($s->jam_pemeriksaan)->format('H:i') : '-' }}</td>
                    <td class="py-3 max-w-[180px] truncate" title="{{ $s->lokasi_pemeriksaan }}">{{ Str::limit($s->lokasi_pemeriksaan, 25) }}</td>
                    <td class="py-3">{{ $s->queue_number ?? '-' }}</td>
                    <td class="py-3">
                        <span class="inline-flex rounded-full px-2 py-0.5 text-theme-xs font-medium {{ $s->status === 'Terjadwal' ? 'bg-warning-100 text-warning-700 dark:bg-warning-500/20' : ($s->status === 'Selesai' ? 'bg-success-100 text-success-700 dark:bg-success-500/20' : ($s->status === 'Batal' ? 'bg-error-100 text-error-700 dark:bg-error-500/20' : 'bg-gray-100 text-gray-700 dark:bg-gray-500/20')) }}">{{ $s->status }}</span>
                    </td>
                    <td class="py-3">
                        <div class="flex flex-wrap items-center gap-1">
                            @if($s->status !== 'Selesai')
                            <form method="POST" action="{{ route('admin.schedules.quick-status', $s) }}" class="inline" onsubmit="return confirm('Tandai selesai?');">
                                @csrf
                                <input type="hidden" name="status" value="Selesai">
                                <button type="submit" title="Selesai" class="inline-flex items-center justify-center rounded p-1.5 text-success-600 hover:bg-success-50 dark:hover:bg-success-500/10">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </button>
                            </form>
                            @endif
                            @if($s->status !== 'Ditolak')
                            <form method="POST" action="{{ route('admin.schedules.quick-status', $s) }}" class="inline" onsubmit="return confirm('Tolak jadwal ini?');">
                                @csrf
                                <input type="hidden" name="status" value="Ditolak">
                                <button type="submit" title="Tolak" class="inline-flex items-center justify-center rounded p-1.5 text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg>
                                </button>
                            </form>
                            @endif
                            @if($s->status !== 'Batal')
                            <form method="POST" action="{{ route('admin.schedules.quick-status', $s) }}" class="inline" onsubmit="return confirm('Batalkan jadwal ini?');">
                                @csrf
                                <input type="hidden" name="status" value="Batal">
                                <button type="submit" title="Batal" class="inline-flex items-center justify-center rounded p-1.5 text-error-500 hover:bg-error-50 dark:hover:bg-error-500/10">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </form>
                            @endif
                            <a href="{{ route('admin.schedules.edit', $s) }}" title="Edit" class="inline-flex items-center justify-center rounded p-1.5 text-brand-500 hover:bg-brand-50 dark:hover:bg-brand-500/10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" /></svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p class="text-theme-sm text-gray-500 dark:text-gray-400">Tidak ada antrian hari ini.</p>
    @endif
    <div class="mt-3">
        <a href="{{ route('admin.schedules.index', ['date' => now()->format('Y-m-d')]) }}" class="text-theme-sm text-brand-500 hover:underline">Lihat semua jadwal hari ini →</a>
    </div>
</x-common.component-card>

<!-- Konfirmasi Hadir - Siap Diselesaikan -->
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
            responsive: true,
            maintainAspectRatio: false,
            layout: { padding: { top: 8, right: 12, bottom: 20, left: 8 } },
            plugins: { legend: { position: 'bottom' } },
            scales: { x: { grid: { display: false }, ticks: { maxRotation: 45, minRotation: 0 } }, y: { beginAtZero: true } }
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
            responsive: true,
            maintainAspectRatio: false,
            layout: { padding: { top: 8, right: 8, bottom: 8, left: 8 } },
            plugins: { legend: { position: 'bottom' } }
        }
    });

    @php
        $dailyQueueDataJs = $dailyQueueData ?? ['labels' => [], 'terjadwal' => [], 'selesai' => [], 'batal' => [], 'ditolak' => []];
    @endphp
    const dailyQueueData = @json($dailyQueueDataJs);
    if (dailyQueueData.labels && dailyQueueData.labels.length) {
        new Chart(document.getElementById('dailyQueueChart'), {
            type: 'line',
            data: {
                labels: dailyQueueData.labels,
                datasets: [
                    { label: 'Antrian (Aktif)', data: dailyQueueData.terjadwal || [], borderColor: '#f59e0b', backgroundColor: 'rgba(245,158,11,0.2)', fill: true, tension: 0.35 },
                    { label: 'Selesai', data: dailyQueueData.selesai || [], borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,0.2)', fill: true, tension: 0.35 },
                    { label: 'Batal', data: dailyQueueData.batal || [], borderColor: '#ef4444', backgroundColor: 'rgba(239,68,68,0.2)', fill: true, tension: 0.35 },
                    { label: 'Ditolak', data: dailyQueueData.ditolak || [], borderColor: '#6b7280', backgroundColor: 'rgba(107,114,128,0.2)', fill: true, tension: 0.35 }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: { padding: { top: 8, right: 12, bottom: 20, left: 8 } },
                plugins: { legend: { position: 'bottom' } },
                scales: { x: { grid: { display: false }, ticks: { maxRotation: 45, minRotation: 0 } }, y: { beginAtZero: true } }
            }
        });
    }
})();
</script>
@endpush
@endsection
