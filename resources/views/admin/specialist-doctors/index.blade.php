@extends('layouts.app')

@section('title', 'Dokter Spesialis')

@section('content')
<x-common.page-breadcrumb pageTitle="Dokter Spesialis" />

@if(session('success'))
    <div class="mb-4 rounded-lg border border-success-200 bg-success-50 p-4 text-theme-sm text-success-800 dark:border-success-800 dark:bg-success-500/10 dark:text-success-400">{{ session('success') }}</div>
@endif

<x-common.component-card title="Daftar Dokter Spesialis">
    <form method="GET" class="mb-4 flex flex-wrap items-center gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / spesialisasi..." class="rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90 w-64">
        <select name="is_active" class="rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
            <option value="">Semua Status</option>
            <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Tidak Aktif</option>
        </select>
        <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-theme-sm font-medium text-white hover:bg-brand-600">Cari</button>
        <a href="{{ route('admin.specialist-doctors.create') }}" class="rounded-lg border border-brand-500 px-4 py-2 text-theme-sm font-medium text-brand-500 hover:bg-brand-50 dark:hover:bg-brand-500/10">Tambah Dokter</a>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-theme-sm">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-800">
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Nama</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Spesialisasi</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Deskripsi</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Aktif</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($doctors as $doc)
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <td class="py-3 font-medium text-gray-800 dark:text-white/90">{{ $doc->name }}</td>
                        <td class="py-3">{{ $doc->specialty ?? '-' }}</td>
                        <td class="py-3 max-w-xs truncate">{{ Str::limit($doc->description, 40) }}</td>
                        <td class="py-3">{{ $doc->is_active ? 'Ya' : 'Tidak' }}</td>
                        <td class="py-3">
                            <div class="flex flex-wrap items-center gap-1.5">
                                <x-admin.action-badge type="edit" :href="route('admin.specialist-doctors.edit', $doc)" />
                                <x-admin.action-badge type="delete" :href="route('admin.specialist-doctors.destroy', $doc)" confirm="Yakin hapus data ini?" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-6 text-center text-gray-500">Belum ada data dokter spesialis.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $doctors->links() }}</div>
</x-common.component-card>
@endsection
