@extends('layouts.app')

@section('title', 'Email Templates')

@section('content')
<x-common.page-breadcrumb pageTitle="Email Templates" />

@if(session('success'))
    <div class="mb-4 rounded-lg border border-success-200 bg-success-50 p-4 text-theme-sm text-success-800 dark:border-success-800 dark:bg-success-500/10 dark:text-success-400">{{ session('success') }}</div>
@endif

<x-common.component-card title="Daftar Email Template">
    <form method="GET" class="mb-4 flex flex-wrap items-center gap-2">
        <select name="type" class="rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
            <option value="">Semua Tipe</option>
            <option value="mcu_invitation" {{ request('type') === 'mcu_invitation' ? 'selected' : '' }}>MCU Invitation</option>
            <option value="reminder" {{ request('type') === 'reminder' ? 'selected' : '' }}>Reminder</option>
            <option value="notification" {{ request('type') === 'notification' ? 'selected' : '' }}>Notification</option>
            <option value="mcu_result" {{ request('type') === 'mcu_result' ? 'selected' : '' }}>Hasil MCU</option>
            <option value="custom" {{ request('type') === 'custom' ? 'selected' : '' }}>Custom</option>
        </select>
        <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-theme-sm font-medium text-white hover:bg-brand-600">Filter</button>
        <a href="{{ route('admin.email-templates.create') }}" class="rounded-lg border border-brand-500 px-4 py-2 text-theme-sm font-medium text-brand-500 hover:bg-brand-50 dark:hover:bg-brand-500/10">Tambah Template</a>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-theme-sm">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-800">
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Nama</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Tipe</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Subject</th>
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
                        <td class="py-3 max-w-xs truncate">{{ Str::limit($t->subject, 40) }}</td>
                        <td class="py-3">{{ $t->is_active ? 'Ya' : 'Tidak' }}</td>
                        <td class="py-3">{{ $t->is_default ? 'Ya' : 'Tidak' }}</td>
                        <td class="py-3">
                            <div class="flex flex-wrap items-center gap-2">
                                <x-admin.action-badge type="edit" :href="route('admin.email-templates.edit', $t)" />
                                <x-admin.action-badge type="delete" :href="route('admin.email-templates.destroy', $t)" confirm="Yakin hapus template ini?" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="py-6 text-center text-gray-500">Belum ada email template.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $templates->links() }}</div>
</x-common.component-card>
@endsection
