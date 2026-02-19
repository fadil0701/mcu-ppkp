@extends('layouts.app')

@section('title', 'Jadwal MCU')

@section('content')
<x-common.page-breadcrumb pageTitle="Jadwal MCU" />

@if(session('success'))
    <div class="mb-4 rounded-lg border border-success-200 bg-success-50 p-4 text-theme-sm text-success-800 dark:border-success-800 dark:bg-success-500/10 dark:text-success-400">{{ session('success') }}</div>
@endif

<x-common.component-card title="Daftar Jadwal MCU">
    <form method="GET" class="mb-4 flex flex-wrap items-center gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIK, lokasi..." class="rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 w-64">
        <input type="date" name="date" value="{{ request('date') }}" class="rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800">
        <select name="status" class="rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800">
            <option value="">Semua Status</option>
            <option value="Terjadwal" {{ request('status') === 'Terjadwal' ? 'selected' : '' }}>Terjadwal</option>
            <option value="Selesai" {{ request('status') === 'Selesai' ? 'selected' : '' }}>Selesai</option>
            <option value="Batal" {{ request('status') === 'Batal' ? 'selected' : '' }}>Batal</option>
            <option value="Ditolak" {{ request('status') === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
        </select>
        <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-theme-sm font-medium text-white hover:bg-brand-600">Cari</button>
        <a href="{{ route('admin.schedules.create') }}" class="rounded-lg border border-brand-500 px-4 py-2 text-theme-sm font-medium text-brand-500 hover:bg-brand-50 dark:hover:bg-brand-500/10">Tambah Jadwal</a>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-theme-sm">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-800">
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Tanggal / Jam</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Peserta</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Lokasi</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">No. Antrian</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Status</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schedules as $s)
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <td class="py-3">{{ $s->tanggal_pemeriksaan?->format('d/m/Y') }}<br>{{ $s->jam_pemeriksaan?->format('H:i') }}</td>
                        <td class="py-3 font-medium text-gray-800 dark:text-white/90">{{ $s->nama_lengkap ?? $s->participant?->nama_lengkap }}</td>
                        <td class="py-3 max-w-xs truncate" title="{{ $s->lokasi_pemeriksaan }}">{{ $s->lokasi_pemeriksaan }}</td>
                        <td class="py-3">{{ $s->queue_number ?? '-' }}</td>
                        <td class="py-3">
                            <span class="inline-flex rounded-full px-2.5 py-0.5 text-theme-xs font-medium
                                {{ $s->status === 'Selesai' ? 'bg-success-100 text-success-700 dark:bg-success-500/20' : ($s->status === 'Ditolak' || $s->status === 'Batal' ? 'bg-error-100 text-error-700 dark:bg-error-500/20' : 'bg-warning-100 text-warning-700 dark:bg-warning-500/20') }}">{{ $s->status }}</span>
                        </td>
                        <td class="py-3">
                            <div class="flex flex-wrap items-center gap-2">
                                <x-admin.action-badge type="edit" :href="route('admin.schedules.edit', $s)" />
                                <x-admin.action-badge type="delete" :href="route('admin.schedules.destroy', $s)" confirm="Yakin hapus jadwal ini?" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="py-6 text-center text-gray-500">Belum ada jadwal.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $schedules->links() }}</div>
</x-common.component-card>
@endsection
