@extends('layouts.app')

@section('title', 'Permintaan Reschedule')

@section('content')
<x-common.page-breadcrumb pageTitle="Permintaan Reschedule" />

@if(session('success'))
    <div class="mb-4 rounded-lg border border-success-200 bg-success-50 p-4 text-theme-sm text-success-800 dark:border-success-800 dark:bg-success-500/10 dark:text-success-400">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="mb-4 rounded-lg border border-error-200 bg-error-50 p-4 text-theme-sm text-error-800 dark:border-error-800 dark:bg-error-500/10 dark:text-error-400">{{ session('error') }}</div>
@endif

<x-common.component-card title="Daftar Permintaan Reschedule">
    <form method="GET" class="mb-4 flex flex-wrap items-end gap-2">
        <div>
            <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">SKPD</label>
            <select name="skpd" class="rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90 w-48">
                <option value="">Semua</option>
                @foreach($skpds as $k => $v)
                    <option value="{{ $k }}" {{ request('skpd') == $k ? 'selected' : '' }}>{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Dari Tanggal</label>
            <input type="date" name="from" value="{{ request('from') }}" class="rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
        </div>
        <div>
            <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Sampai Tanggal</label>
            <input type="date" name="until" value="{{ request('until') }}" class="rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
        </div>
        <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-theme-sm font-medium text-white hover:bg-brand-600">Filter</button>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-theme-sm">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-800">
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Peserta</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">NIK</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Tgl Lama</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Jam Lama</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Tgl Baru</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Jam Baru</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Alasan</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schedules as $s)
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <td class="py-3 font-medium text-gray-800 dark:text-white/90">{{ $s->participant->nama_lengkap ?? $s->nama_lengkap }}</td>
                        <td class="py-3">{{ $s->nik_ktp }}</td>
                        <td class="py-3">{{ $s->tanggal_pemeriksaan?->format('d/m/Y') }}</td>
                        <td class="py-3">{{ $s->jam_pemeriksaan ? (\Carbon\Carbon::parse($s->jam_pemeriksaan)->format('H:i')) : '-' }}</td>
                        <td class="py-3">{{ $s->reschedule_new_date?->format('d/m/Y') }}</td>
                        <td class="py-3">{{ $s->reschedule_new_time ? (\Carbon\Carbon::parse($s->reschedule_new_time)->format('H:i')) : '-' }}</td>
                        <td class="py-3 max-w-[200px] truncate" title="{{ $s->reschedule_reason }}">{{ Str::limit($s->reschedule_reason, 30) }}</td>
                        <td class="py-3">
                            <form method="POST" action="{{ route('admin.reschedule-center.approve', $s) }}" class="inline" onsubmit="return confirm('Setujui reschedule ini?');">
                                @csrf
                                <button type="submit" class="text-success-600 hover:underline text-theme-sm">Setujui</button>
                            </form>
                            <span class="text-gray-400 mx-1">|</span>
                            <form method="POST" action="{{ route('admin.reschedule-center.reject', $s) }}" class="inline" onsubmit="return confirm('Tolak permintaan reschedule?');">
                                @csrf
                                <button type="submit" class="text-error-500 hover:underline text-theme-sm">Tolak</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="py-6 text-center text-gray-500">Tidak ada permintaan reschedule.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $schedules->links() }}</div>
</x-common.component-card>
@endsection
