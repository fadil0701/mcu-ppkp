@extends('layouts.app')

@section('title', 'Hasil MCU')

@section('content')
<x-common.page-breadcrumb pageTitle="Hasil MCU" />

@if(session('success'))
    <div class="mb-4 rounded-lg border border-success-200 bg-success-50 p-4 text-theme-sm text-success-800 dark:border-success-800 dark:bg-success-500/10 dark:text-success-400">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="mb-4 rounded-lg border border-error-200 bg-error-50 p-4 text-theme-sm text-error-800 dark:border-error-800 dark:bg-error-500/10 dark:text-error-400">{{ $errors->first() }}</div>
@endif

<x-common.component-card title="Daftar Hasil MCU">
    <form method="GET" class="mb-4 flex flex-wrap items-center gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / NIK peserta..." class="rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 w-64">
        <select name="status_kesehatan" class="rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800">
            <option value="">Semua Status Kesehatan</option>
            <option value="Sehat" {{ request('status_kesehatan') === 'Sehat' ? 'selected' : '' }}>Sehat</option>
            <option value="Kurang Sehat" {{ request('status_kesehatan') === 'Kurang Sehat' ? 'selected' : '' }}>Kurang Sehat</option>
            <option value="Tidak Sehat" {{ request('status_kesehatan') === 'Tidak Sehat' ? 'selected' : '' }}>Tidak Sehat</option>
        </select>
        <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-theme-sm font-medium text-white hover:bg-brand-600">Cari</button>
        <a href="{{ route('admin.mcu-results.create') }}" class="rounded-lg border border-brand-500 px-4 py-2 text-theme-sm font-medium text-brand-500 hover:bg-brand-50 dark:hover:bg-brand-500/10">Tambah Hasil MCU</a>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-theme-sm">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-800">
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Tanggal</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Peserta</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Diagnosis</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Status Kesehatan</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Publikasi</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($results as $r)
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <td class="py-3">{{ $r->tanggal_pemeriksaan?->format('d/m/Y') }}</td>
                        <td class="py-3 font-medium text-gray-800 dark:text-white/90">{{ $r->participant?->nama_lengkap ?? $r->participant_id }}</td>
                        <td class="py-3 max-w-xs truncate" title="{{ $r->diagnosis }}">{{ Str::limit($r->diagnosis, 40) ?: '-' }}</td>
                        <td class="py-3">
                            <span class="inline-flex rounded-full px-2.5 py-0.5 text-theme-xs font-medium
                                {{ $r->status_kesehatan === 'Sehat' ? 'bg-success-100 text-success-700 dark:bg-success-500/20' : ($r->status_kesehatan === 'Tidak Sehat' ? 'bg-error-100 text-error-700 dark:bg-error-500/20' : 'bg-warning-100 text-warning-700 dark:bg-warning-500/20') }}">{{ $r->status_kesehatan }}</span>
                        </td>
                        <td class="py-3">{{ $r->is_published ? 'Ya' : 'Tidak' }}</td>
                        <td class="py-3">
                            <div class="flex flex-wrap items-center gap-2">
                                @if($r->participant?->email)
                                <form method="POST" action="{{ route('admin.mcu-results.send-email', $r) }}" class="inline">
                                    @csrf
                                    <button type="submit" title="Kirim Email" class="inline-flex items-center justify-center rounded p-1.5 text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
                                    </button>
                                </form>
                                @endif
                                @if($r->participant?->no_telp)
                                <form method="POST" action="{{ route('admin.mcu-results.send-whatsapp', $r) }}" class="inline">
                                    @csrf
                                    <button type="submit" title="Kirim WhatsApp" class="inline-flex items-center justify-center rounded p-1.5 text-success-600 hover:bg-success-50 dark:hover:bg-success-500/10">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    </button>
                                </form>
                                @endif
                                <x-admin.action-badge type="edit" :href="route('admin.mcu-results.edit', $r)" />
                                <x-admin.action-badge type="delete" :href="route('admin.mcu-results.destroy', $r)" confirm="Yakin hapus hasil MCU ini?" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="py-6 text-center text-gray-500">Belum ada hasil MCU.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $results->links() }}</div>
</x-common.component-card>
@endsection
