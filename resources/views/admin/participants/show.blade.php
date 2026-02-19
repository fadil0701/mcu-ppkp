@extends('layouts.app')

@section('title', 'Detail Peserta')

@section('content')
<x-common.page-breadcrumb pageTitle="Detail Peserta" />

<x-common.component-card title="{{ $participant->nama_lengkap }}">
    <div class="mb-4 flex gap-2">
        <a href="{{ route('admin.participants.edit', $participant) }}" class="rounded-lg bg-brand-500 px-4 py-2 text-theme-sm font-medium text-white hover:bg-brand-600">Edit</a>
        <a href="{{ route('admin.participants.index') }}" class="rounded-lg border border-gray-200 px-4 py-2 text-theme-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-300 dark:hover:bg-white/5">Kembali</a>
    </div>

    <dl class="grid gap-3 sm:grid-cols-2 text-theme-sm">
        <div><dt class="font-medium text-gray-500 dark:text-gray-400">NIK KTP</dt><dd>{{ $participant->nik_ktp }}</dd></div>
        <div><dt class="font-medium text-gray-500 dark:text-gray-400">NRK Pegawai</dt><dd>{{ $participant->nrk_pegawai }}</dd></div>
        <div><dt class="font-medium text-gray-500 dark:text-gray-400">Tempat, Tanggal Lahir</dt><dd>{{ $participant->tempat_lahir }}, {{ $participant->tanggal_lahir?->format('d/m/Y') }}</dd></div>
        <div><dt class="font-medium text-gray-500 dark:text-gray-400">Jenis Kelamin</dt><dd>{{ $participant->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</dd></div>
        <div><dt class="font-medium text-gray-500 dark:text-gray-400">SKPD / UKPD</dt><dd>{{ $participant->skpd }} / {{ $participant->ukpd }}</dd></div>
        <div><dt class="font-medium text-gray-500 dark:text-gray-400">Status Pegawai</dt><dd>{{ $participant->status_pegawai }}</dd></div>
        <div><dt class="font-medium text-gray-500 dark:text-gray-400">No. Telp</dt><dd>{{ $participant->no_telp }}</dd></div>
        <div><dt class="font-medium text-gray-500 dark:text-gray-400">Email</dt><dd>{{ $participant->email }}</dd></div>
        <div><dt class="font-medium text-gray-500 dark:text-gray-400">Status MCU</dt><dd><span class="inline-flex rounded-full px-2.5 py-0.5 text-theme-xs font-medium {{ $participant->status_mcu === 'Sudah MCU' ? 'bg-success-100 text-success-700' : ($participant->status_mcu === 'Ditolak' ? 'bg-error-100 text-error-700' : 'bg-warning-100 text-warning-700') }}">{{ $participant->status_mcu }}</span></dd></div>
        @if($participant->catatan)
            <div class="sm:col-span-2"><dt class="font-medium text-gray-500 dark:text-gray-400">Catatan</dt><dd>{{ $participant->catatan }}</dd></div>
        @endif
    </dl>
</x-common.component-card>

<x-common.component-card title="Jadwal MCU Terbaru" class="mt-6">
    @if($participant->schedules->count())
        <div class="overflow-x-auto">
            <table class="w-full text-theme-sm">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800">
                        <th class="pb-2 text-left font-medium text-gray-700 dark:text-gray-300">Tanggal</th>
                        <th class="pb-2 text-left font-medium text-gray-700 dark:text-gray-300">Jam</th>
                        <th class="pb-2 text-left font-medium text-gray-700 dark:text-gray-300">Lokasi</th>
                        <th class="pb-2 text-left font-medium text-gray-700 dark:text-gray-300">Status</th>
                        <th class="pb-2 text-left font-medium text-gray-700 dark:text-gray-300">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($participant->schedules as $s)
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <td class="py-2">{{ $s->tanggal_pemeriksaan?->format('d/m/Y') }}</td>
                            <td class="py-2">{{ $s->jam_pemeriksaan ? \Carbon\Carbon::parse($s->jam_pemeriksaan)->format('H:i') : '-' }}</td>
                            <td class="py-2 max-w-[200px] truncate">{{ Str::limit($s->lokasi_pemeriksaan, 30) }}</td>
                            <td class="py-2">{{ $s->status }}</td>
                            <td class="py-2"><a href="{{ route('admin.schedules.edit', $s) }}" class="text-brand-500 hover:underline">Edit</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <p class="mt-2 text-theme-xs text-gray-500"><a href="{{ route('admin.schedules.index', ['search' => $participant->nik_ktp]) }}" class="text-brand-500 hover:underline">Lihat semua jadwal</a></p>
    @else
        <p class="text-gray-500">Belum ada jadwal MCU.</p>
    @endif
</x-common.component-card>

<x-common.component-card title="Hasil MCU Terbaru" class="mt-6">
    @if($participant->mcuResults->count())
        <div class="overflow-x-auto">
            <table class="w-full text-theme-sm">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800">
                        <th class="pb-2 text-left font-medium text-gray-700 dark:text-gray-300">Tanggal</th>
                        <th class="pb-2 text-left font-medium text-gray-700 dark:text-gray-300">Status Kesehatan</th>
                        <th class="pb-2 text-left font-medium text-gray-700 dark:text-gray-300">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($participant->mcuResults as $r)
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <td class="py-2">{{ $r->tanggal_pemeriksaan?->format('d/m/Y') }}</td>
                            <td class="py-2">{{ $r->status_kesehatan }}</td>
                            <td class="py-2"><a href="{{ route('admin.mcu-results.edit', $r) }}" class="text-brand-500 hover:underline">Edit</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-500">Belum ada hasil MCU.</p>
    @endif
</x-common.component-card>
@endsection
