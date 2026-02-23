@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')
<x-common.page-breadcrumb pageTitle="Pengaturan" />

@if(session('success'))
    <div class="mb-4 rounded-lg border border-success-200 bg-success-50 p-4 text-theme-sm text-success-800 dark:border-success-800 dark:bg-success-500/10 dark:text-success-400">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="mb-4 rounded-lg border border-error-200 bg-error-50 p-4 text-theme-sm text-error-800 dark:border-error-800 dark:bg-error-500/10 dark:text-error-400">{{ session('error') }}</div>
@endif

<x-common.component-card title="Daftar Setting">
    <form method="GET" class="mb-4 flex flex-wrap items-center gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari key..." class="rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90 w-56">
        <select name="group" class="rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
            <option value="">Semua Group</option>
            <option value="general" {{ request('group') === 'general' ? 'selected' : '' }}>General</option>
            <option value="smtp" {{ request('group') === 'smtp' ? 'selected' : '' }}>SMTP</option>
            <option value="email_template" {{ request('group') === 'email_template' ? 'selected' : '' }}>Email Template</option>
            <option value="whatsapp" {{ request('group') === 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
            <option value="whatsapp_template" {{ request('group') === 'whatsapp_template' ? 'selected' : '' }}>WhatsApp Template</option>
            <option value="mcu" {{ request('group') === 'mcu' ? 'selected' : '' }}>MCU</option>
            <option value="system" {{ request('group') === 'system' ? 'selected' : '' }}>System</option>
        </select>
        <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-theme-sm font-medium text-white hover:bg-brand-600">Cari</button>
        <a href="{{ route('admin.settings.create') }}" class="rounded-lg border border-brand-500 px-4 py-2 text-theme-sm font-medium text-brand-500 hover:bg-brand-50 dark:hover:bg-brand-500/10">Tambah Setting</a>
    </form>
    <div class="overflow-x-auto">
        <table class="w-full text-theme-sm">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-800">
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Key</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Group</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Nilai</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($settings as $s)
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <td class="py-3 font-medium text-gray-800 dark:text-white/90">{{ $s->key }}</td>
                        <td class="py-3">{{ $s->group }}</td>
                        <td class="py-3 max-w-xs truncate">{{ $s->is_encrypted ? '(terenkripsi)' : Str::limit($s->value, 50) }}</td>
                        <td class="py-3">
                            @if(!$s->is_encrypted)
                                <a href="{{ route('admin.settings.edit', $s) }}" class="text-brand-500 hover:underline">Edit</a>
                            @else
                                <span class="text-gray-500">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="py-6 text-center text-gray-500">Belum ada setting.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $settings->links() }}</div>
</x-common.component-card>
@endsection
