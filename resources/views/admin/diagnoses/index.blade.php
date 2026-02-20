@extends('layouts.app')

@section('title', 'Master Diagnosis')

@section('content')
<x-common.page-breadcrumb pageTitle="Master Diagnosis" />

@if(session('success'))
    <div class="mb-4 rounded-lg border border-success-200 bg-success-50 p-4 text-theme-sm text-success-800 dark:border-success-800 dark:bg-success-500/10 dark:text-success-400">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="mb-4 rounded-lg border border-error-200 bg-error-50 p-4 text-theme-sm text-error-800 dark:border-error-800 dark:bg-error-500/10 dark:text-error-400">{{ session('error') }}</div>
@endif

<x-common.component-card title="Daftar Diagnosis">
    <div class="mb-4 flex flex-wrap items-center gap-2">
        <form method="GET" class="inline-flex flex-wrap items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode / nama..." class="rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90 w-64">
            <select name="is_active" class="rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
                <option value="">Semua Status</option>
                <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
            <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-theme-sm font-medium text-white hover:bg-brand-600">Cari</button>
        </form>
        <a href="{{ route('admin.diagnoses.template') }}" class="inline-flex items-center gap-2 rounded-lg border border-gray-200 px-4 py-2 text-theme-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-300 dark:hover:bg-white/5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
            Template Import
        </a>
        <form action="{{ route('admin.diagnoses.import') }}" method="POST" enctype="multipart/form-data" class="inline-flex items-center gap-2">
            @csrf
            <input type="file" name="file" accept=".xlsx,.xls,.csv" required class="rounded-lg border border-gray-200 px-2 py-1.5 text-theme-sm file:mr-2 file:rounded file:border-0 file:bg-brand-50 file:px-3 file:py-1 file:text-theme-sm file:font-medium file:text-brand-700 dark:border-gray-700 dark:file:bg-brand-500/10 dark:file:text-brand-400">
            <button type="submit" class="rounded-lg bg-success-500 px-4 py-2 text-theme-sm font-medium text-white hover:bg-success-600">Import Diagnosis</button>
        </form>
        <a href="{{ route('admin.diagnoses.create') }}" class="rounded-lg border border-brand-500 px-4 py-2 text-theme-sm font-medium text-brand-500 hover:bg-brand-50 dark:hover:bg-brand-500/10">Tambah Diagnosis</a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-theme-sm">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-800">
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Kode</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Nama</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Deskripsi</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Aktif</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($diagnoses as $d)
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <td class="py-3">{{ $d->code ?? '-' }}</td>
                        <td class="py-3 font-medium text-gray-800 dark:text-white/90">{{ $d->name }}</td>
                        <td class="py-3 max-w-xs truncate">{{ Str::limit($d->description, 40) }}</td>
                        <td class="py-3">{{ $d->is_active ? 'Ya' : 'Tidak' }}</td>
                        <td class="py-3">
                            <div class="flex flex-wrap items-center gap-1.5">
                                <x-admin.action-badge type="edit" :href="route('admin.diagnoses.edit', $d)" />
                                <x-admin.action-badge type="delete" :href="route('admin.diagnoses.destroy', $d)" confirm="Yakin hapus diagnosis ini?" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-6 text-center text-gray-500">Belum ada data diagnosis.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $diagnoses->links() }}</div>
</x-common.component-card>
@endsection
