@extends('layouts.app')

@section('title', 'Tambah Setting')

@section('content')
<x-common.page-breadcrumb pageTitle="Tambah Setting" />

<x-common.component-card title="Form Setting Baru">
    <form method="POST" action="{{ route('admin.settings.store') }}" class="space-y-4">
        @csrf
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Key *</label>
                <input type="text" name="key" value="{{ old('key') }}" required placeholder="contoh: smtp_host" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
                @error('key')<p class="mt-1 text-theme-xs text-error-500">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Tipe *</label>
                <select name="type" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
                    <option value="string" {{ old('type') === 'string' ? 'selected' : '' }}>Text</option>
                    <option value="number" {{ old('type') === 'number' ? 'selected' : '' }}>Number</option>
                    <option value="boolean" {{ old('type') === 'boolean' ? 'selected' : '' }}>Boolean</option>
                    <option value="json" {{ old('type') === 'json' ? 'selected' : '' }}>JSON</option>
                    <option value="textarea" {{ old('type') === 'textarea' ? 'selected' : '' }}>Long Text</option>
                </select>
                @error('type')<p class="mt-1 text-theme-xs text-error-500">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Grup *</label>
                <select name="group" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
                    <option value="general" {{ old('group') === 'general' ? 'selected' : '' }}>General</option>
                    <option value="email" {{ old('group') === 'email' ? 'selected' : '' }}>Email Settings</option>
                    <option value="whatsapp" {{ old('group') === 'whatsapp' ? 'selected' : '' }}>WhatsApp Settings</option>
                    <option value="mcu" {{ old('group') === 'mcu' ? 'selected' : '' }}>MCU Settings</option>
                    <option value="system" {{ old('group') === 'system' ? 'selected' : '' }}>System Settings</option>
                </select>
                @error('group')<p class="mt-1 text-theme-xs text-error-500">{{ $message }}</p>@enderror
            </div>
        </div>
        <div>
            <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Nilai</label>
            <input type="text" name="value" value="{{ old('value') }}" placeholder="Masukkan nilai" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
            @error('value')<p class="mt-1 text-theme-xs text-error-500">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi (opsional)</label>
            <textarea name="description" rows="2" placeholder="Deskripsi singkat setting ini" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">{{ old('description') }}</textarea>
            @error('description')<p class="mt-1 text-theme-xs text-error-500">{{ $message }}</p>@enderror
        </div>
        <div class="flex gap-2 pt-4">
            <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-theme-sm font-medium text-white hover:bg-brand-600">Simpan</button>
            <a href="{{ route('admin.settings.index') }}" class="rounded-lg border border-gray-200 px-4 py-2 text-theme-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-300 dark:hover:bg-white/5">Batal</a>
        </div>
    </form>
</x-common.component-card>
@endsection
