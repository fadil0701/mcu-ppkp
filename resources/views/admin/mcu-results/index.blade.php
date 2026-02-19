@extends('layouts.app')

@section('title', 'Hasil MCU')

@section('content')
<x-common.page-breadcrumb pageTitle="Hasil MCU" />

@if(session('success'))
    <div class="mb-4 rounded-lg border border-success-200 bg-success-50 p-4 text-theme-sm text-success-800 dark:border-success-800 dark:bg-success-500/10 dark:text-success-400">{{ session('success') }}</div>
@endif

<x-common.component-card title="Daftar Hasil MCU">
    <form method="GET" class="mb-4 flex flex-wrap items-center gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / NIK peserta..." class="rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 w-64">
        <select name="status_kesehatan" class="rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800">
            <option value="">Semua Status Kesehatan</option>
            <option value="Sehat" {{ request('status_kesehatan') === 'Sehat' ? 'selected' : '' }}>Sehat</option>
            <option value="Kurang Sehat" {{ request('status_kesehatan') === 'Kurang Sehat' ? 'selected' : '' }}>Kurang Sehat</option>
            <option value="Tidak Sehat" {{ request('status_kesehatan') === 'Tidak Sehat' ? 'selected' : '' }}>Tidak Sehat</option>
        </select>
        <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-theme-sm font-medium text-white hover:bg-brand-600">Cari</button>
        <a href="{{ route('admin.mcu-results.create') }}" class="rounded-lg border border-brand-500 px-4 py-2 text-theme-sm font-medium text-brand-500 hover:bg-brand-50 dark:hover:bg-brand-500/10">Tambah Hasil MCU</a>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-theme-sm">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-800">
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Tanggal</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Peserta</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Diagnosis</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Status Kesehatan</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Publikasi</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($results as $r)
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <td class="py-3">{{ $r->tanggal_pemeriksaan?->format('d/m/Y') }}</td>
                        <td class="py-3 font-medium text-gray-800 dark:text-white/90">{{ $r->participant?->nama_lengkap ?? $r->participant_id }}</td>
                        <td class="py-3 max-w-xs truncate" title="{{ $r->diagnosis }}">{{ Str::limit($r->diagnosis, 40) ?: '-' }}</td>
                        <td class="py-3">
                            <span class="inline-flex rounded-full px-2.5 py-0.5 text-theme-xs font-medium
                                {{ $r->status_kesehatan === 'Sehat' ? 'bg-success-100 text-success-700 dark:bg-success-500/20' : ($r->status_kesehatan === 'Tidak Sehat' ? 'bg-error-100 text-error-700 dark:bg-error-500/20' : 'bg-warning-100 text-warning-700 dark:bg-warning-500/20') }}">{{ $r->status_kesehatan }}</span>
                        </td>
                        <td class="py-3">{{ $r->is_published ? 'Ya' : 'Tidak' }}</td>
                        <td class="py-3">
                            <div class="flex flex-wrap items-center gap-2">
                                <x-admin.action-badge type="edit" :href="route('admin.mcu-results.edit', $r)" />
                                <x-admin.action-badge type="delete" :href="route('admin.mcu-results.destroy', $r)" confirm="Yakin hapus hasil MCU ini?" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="py-6 text-center text-gray-500">Belum ada hasil MCU.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $results->links() }}</div>
</x-common.component-card>
@endsection
