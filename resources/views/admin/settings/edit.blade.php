@extends('layouts.app')

@section('title', 'Edit Setting')

@section('content')
<x-common.page-breadcrumb pageTitle="Edit Setting" />

<x-common.component-card :title="'Edit: ' . $setting->key">
    <form method="POST" action="{{ route('admin.settings.update', $setting) }}" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Nilai</label>
            @php
                $useTextarea = $setting->type === 'text' || $setting->type === 'textarea' || str_contains($setting->key, 'template');
            @endphp
            @if($useTextarea)
                <textarea name="value" rows="12" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90 font-mono text-theme-sm" placeholder="Masukkan nilai">{{ old('value', $value) }}</textarea>
            @else
                <input type="{{ $setting->type === 'number' ? 'number' : 'text' }}" name="value" value="{{ old('value', $value) }}" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
            @endif
            @error('value')<p class="mt-1 text-theme-xs text-error-500">{{ $message }}</p>@enderror
        </div>
        <div class="flex gap-2 pt-4">
            <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-theme-sm font-medium text-white hover:bg-brand-600">Simpan</button>
            <a href="{{ route('admin.settings.index') }}" class="rounded-lg border border-gray-200 px-4 py-2 text-theme-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-300 dark:hover:bg-white/5">Batal</a>
        </div>
    </form>
</x-common.component-card>
@endsection
