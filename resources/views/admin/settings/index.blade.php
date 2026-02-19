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
</x-common.component-card>
@endsection
