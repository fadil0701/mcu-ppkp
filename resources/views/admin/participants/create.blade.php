@extends('layouts.app')

@section('title', 'Tambah Peserta')

@section('content')
<x-common.page-breadcrumb pageTitle="Tambah Peserta" />

<x-common.component-card title="Form Peserta">
    <form method="POST" action="{{ route('admin.participants.store') }}" class="space-y-4">
        @csrf
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">NIK KTP *</label>
                <input type="text" name="nik_ktp" value="{{ old('nik_ktp') }}" maxlength="16" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
                @error('nik_ktp')<p class="mt-1 text-theme-xs text-error-500">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">NRK Pegawai *</label>
                <input type="text" name="nrk_pegawai" value="{{ old('nrk_pegawai') }}" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
                @error('nrk_pegawai')<p class="mt-1 text-theme-xs text-error-500">{{ $message }}</p>@enderror
            </div>
            <div class="sm:col-span-2">
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Nama Lengkap *</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
                @error('nama_lengkap')<p class="mt-1 text-theme-xs text-error-500">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Tempat Lahir *</label>
                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
                @error('tempat_lahir')<p class="mt-1 text-theme-xs text-error-500">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Lahir *</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
                @error('tanggal_lahir')<p class="mt-1 text-theme-xs text-error-500">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Jenis Kelamin *</label>
                <select name="jenis_kelamin" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
                    <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div>
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">SKPD *</label>
                <input type="text" name="skpd" value="{{ old('skpd') }}" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
                @error('skpd')<p class="mt-1 text-theme-xs text-error-500">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">UKPD *</label>
                <input type="text" name="ukpd" value="{{ old('ukpd') }}" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
                @error('ukpd')<p class="mt-1 text-theme-xs text-error-500">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Status Pegawai *</label>
                <select name="status_pegawai" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
                    <option value="PNS" {{ old('status_pegawai') === 'PNS' ? 'selected' : '' }}>PNS</option>
                    <option value="CPNS" {{ old('status_pegawai') === 'CPNS' ? 'selected' : '' }}>CPNS</option>
                    <option value="PPPK" {{ old('status_pegawai') === 'PPPK' ? 'selected' : '' }}>PPPK</option>
                </select>
            </div>
            <div>
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">No. Telepon *</label>
                <input type="text" name="no_telp" value="{{ old('no_telp') }}" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
                @error('no_telp')<p class="mt-1 text-theme-xs text-error-500">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
                @error('email')<p class="mt-1 text-theme-xs text-error-500">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Status MCU</label>
                <select name="status_mcu" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
                    <option value="Belum MCU" {{ old('status_mcu', 'Belum MCU') === 'Belum MCU' ? 'selected' : '' }}>Belum MCU</option>
                    <option value="Sudah MCU" {{ old('status_mcu') === 'Sudah MCU' ? 'selected' : '' }}>Sudah MCU</option>
                    <option value="Ditolak" {{ old('status_mcu') === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div>
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Tanggal MCU Terakhir</label>
                <input type="date" name="tanggal_mcu_terakhir" value="{{ old('tanggal_mcu_terakhir') }}" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
            </div>
            <div class="sm:col-span-2">
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Catatan</label>
                <textarea name="catatan" rows="3" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">{{ old('catatan') }}</textarea>
            </div>
        </div>
        <div class="flex gap-2 pt-4">
            <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-theme-sm font-medium text-white hover:bg-brand-600">Simpan</button>
            <a href="{{ route('admin.participants.index') }}" class="rounded-lg border border-gray-200 px-4 py-2 text-theme-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-300 dark:hover:bg-white/5">Batal</a>
        </div>
    </form>
</x-common.component-card>
@endsection
