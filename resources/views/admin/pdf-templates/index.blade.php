@extends('layouts.app')

@section('title', 'PDF Templates')

@section('content')
<x-common.page-breadcrumb pageTitle="PDF Templates" />

@if(session('success'))
    <div class="mb-4 rounded-lg border border-success-200 bg-success-50 p-4 text-theme-sm text-success-800 dark:border-success-800 dark:bg-success-500/10 dark:text-success-400">{{ session('success') }}</div>
@endif

<x-common.component-card title="Daftar PDF Template">
    <form method="GET" class="mb-4 flex flex-wrap items-center gap-2">
        <select name="type" class="rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
            <option value="">Semua Tipe</option>
            <option value="mcu_letter" {{ request('type') === 'mcu_letter' ? 'selected' : '' }}>MCU Letter</option>
            <option value="reminder_letter" {{ request('type') === 'reminder_letter' ? 'selected' : '' }}>Reminder Letter</option>
            <option value="custom" {{ request('type') === 'custom' ? 'selected' : '' }}>Custom</option>
        </select>
        <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-theme-sm font-medium text-white hover:bg-brand-600">Filter</button>
        <a href="{{ route('admin.pdf-templates.create') }}" class="rounded-lg border border-brand-500 px-4 py-2 text-theme-sm font-medium text-brand-500 hover:bg-brand-50 dark:hover:bg-brand-500/10">Tambah Template</a>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-theme-sm">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-800">
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Nama</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Tipe</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Title</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Aktif</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Default</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($templates as $t)
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <td class="py-3 font-medium text-gray-800 dark:text-white/90">{{ $t->name }}</td>
                        <td class="py-3">{{ $t->type }}</td>
                        <td class="py-3 max-w-xs truncate">{{ Str::limit($t->title, 40) }}</td>
                        <td class="py-3">{{ $t->is_active ? 'Ya' : 'Tidak' }}</td>
                        <td class="py-3">{{ $t->is_default ? 'Ya' : 'Tidak' }}</td>
                        <td class="py-3">
                            <div class="flex flex-wrap items-center gap-2">
                                <x-admin.action-badge type="edit" :href="route('admin.pdf-templates.edit', $t)" />
                                <x-admin.action-badge type="delete" :href="route('admin.pdf-templates.destroy', $t)" confirm="Yakin hapus template ini?" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="py-6 text-center text-gray-500">Belum ada PDF template.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $templates->links() }}</div>
</x-common.component-card>
@endsection
