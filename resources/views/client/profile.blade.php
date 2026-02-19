@extends('layouts.app')

@section('title', 'Profile Saya')

@section('content')
<x-common.page-breadcrumb pageTitle="Profile Saya" />

<div class="grid gap-6 lg:grid-cols-3">
    <div class="lg:col-span-2">
        <x-common.component-card title="Data Peserta">
            @if($participant)
                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <h5 class="mb-4 text-base font-medium text-gray-800 dark:text-white/90">Informasi Pribadi</h5>
                        <dl class="space-y-2 text-theme-sm">
                            <div><dt class="inline font-medium text-gray-700 dark:text-gray-300">NIK KTP</dt><dd class="inline">: {{ $participant->nik_ktp }}</dd></div>
                            <div><dt class="inline font-medium text-gray-700 dark:text-gray-300">NRK Pegawai</dt><dd class="inline">: {{ $participant->nrk_pegawai }}</dd></div>
                            <div><dt class="inline font-medium text-gray-700 dark:text-gray-300">Nama Lengkap</dt><dd class="inline">: {{ $participant->nama_lengkap }}</dd></div>
                            <div><dt class="inline font-medium text-gray-700 dark:text-gray-300">Tempat Lahir</dt><dd class="inline">: {{ $participant->tempat_lahir }}</dd></div>
                            <div><dt class="inline font-medium text-gray-700 dark:text-gray-300">Tanggal Lahir</dt><dd class="inline">: {{ $participant->tanggal_lahir_formatted }}</dd></div>
                            <div><dt class="inline font-medium text-gray-700 dark:text-gray-300">Jenis Kelamin</dt><dd class="inline">: {{ $participant->jenis_kelamin_text }}</dd></div>
                            <div><dt class="inline font-medium text-gray-700 dark:text-gray-300">Umur</dt><dd class="inline">: {{ $participant->umur }} tahun</dd></div>
                        </dl>
                    </div>
                    <div>
                        <h5 class="mb-4 text-base font-medium text-gray-800 dark:text-white/90">Informasi Instansi</h5>
                        <dl class="space-y-2 text-theme-sm">
                            <div><dt class="inline font-medium text-gray-700 dark:text-gray-300">SKPD</dt><dd class="inline">: {{ $participant->skpd }}</dd></div>
                            <div><dt class="inline font-medium text-gray-700 dark:text-gray-300">UKPD</dt><dd class="inline">: {{ $participant->ukpd }}</dd></div>
                            <div><dt class="inline font-medium text-gray-700 dark:text-gray-300">Status Pegawai</dt><dd class="inline">: {{ $participant->status_pegawai }}</dd></div>
                            <div><dt class="inline font-medium text-gray-700 dark:text-gray-300">No. Telepon</dt><dd class="inline">: {{ $participant->no_telp }}</dd></div>
                            <div><dt class="inline font-medium text-gray-700 dark:text-gray-300">Email</dt><dd class="inline">: {{ $participant->email }}</dd></div>
                        </dl>
                    </div>
                </div>

                <div class="mt-6 border-t border-gray-200 pt-6 dark:border-gray-800">
                    <h5 class="mb-4 text-base font-medium text-gray-800 dark:text-white/90">Status MCU</h5>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 text-center dark:border-gray-800 dark:bg-gray-900/50">
                            <p class="text-theme-xs text-gray-500 dark:text-gray-400">Status MCU</p>
                            <span class="mt-1 inline-flex rounded-full px-2.5 py-0.5 text-theme-sm font-medium bg-success-100 text-success-700 dark:bg-success-500/20 dark:text-success-400">{{ $participant->status_mcu }}</span>
                        </div>
                        <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 text-center dark:border-gray-800 dark:bg-gray-900/50">
                            <p class="text-theme-xs text-gray-500 dark:text-gray-400">MCU Terakhir</p>
                            <p class="mt-1 font-medium text-gray-800 dark:text-white/90">{{ $participant->tanggal_mcu_terakhir ? $participant->tanggal_mcu_terakhir_formatted : 'Belum pernah MCU' }}</p>
                        </div>
                        <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 text-center dark:border-gray-800 dark:bg-gray-900/50">
                            <p class="text-theme-xs text-gray-500 dark:text-gray-400">Kategori Umur</p>
                            <p class="mt-1 font-medium text-gray-800 dark:text-white/90">{{ $participant->kategori_umur }}</p>
                        </div>
                    </div>
                </div>

                @if($participant->catatan)
                    <div class="mt-6 border-t border-gray-200 pt-6 dark:border-gray-800">
                        <h5 class="mb-2 text-base font-medium text-gray-800 dark:text-white/90">Catatan</h5>
                        <div class="rounded-lg border border-gray-200 bg-gray-50 p-3 text-theme-sm dark:border-gray-800 dark:bg-gray-900/50">{{ $participant->catatan }}</div>
                    </div>
                @endif
            @else
                <div class="py-12 text-center">
                    <p class="text-lg font-medium text-gray-800 dark:text-white/90">Data Peserta Tidak Ditemukan</p>
                    <p class="mt-1 text-theme-sm text-gray-500 dark:text-gray-400">Data peserta MCU Anda belum terdaftar. Silakan hubungi administrator.</p>
                </div>
            @endif
        </x-common.component-card>
    </div>

    <div>
        <x-common.component-card title="Informasi Akun">
            <dl class="space-y-3 text-theme-sm">
                <div><dt class="font-medium text-gray-500 dark:text-gray-400">Nama</dt><dd class="mt-0.5 text-gray-800 dark:text-white/90">{{ Auth::user()->name }}</dd></div>
                <div><dt class="font-medium text-gray-500 dark:text-gray-400">Email</dt><dd class="mt-0.5 text-gray-800 dark:text-white/90">{{ Auth::user()->email }}</dd></div>
                <div><dt class="font-medium text-gray-500 dark:text-gray-400">Role</dt><dd class="mt-0.5 text-gray-800 dark:text-white/90">{{ ucfirst(str_replace('_', ' ', Auth::user()->role ?? 'user')) }}</dd></div>
                <div><dt class="font-medium text-gray-500 dark:text-gray-400">Status</dt>
                    <dd class="mt-0.5">
                        <span class="inline-flex rounded-full px-2.5 py-0.5 text-theme-xs font-medium {{ Auth::user()->is_active ? 'bg-success-100 text-success-700 dark:bg-success-500/20 dark:text-success-400' : 'bg-error-100 text-error-700 dark:bg-error-500/20 dark:text-error-400' }}">
                            {{ Auth::user()->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </dd>
                </div>
            </dl>
        </x-common.component-card>
    </div>
</div>
@endsection
