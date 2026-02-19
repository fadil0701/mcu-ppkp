@extends('layouts.app')

@section('title', 'Hasil MCU Saya')

@section('content')
<x-common.page-breadcrumb pageTitle="Hasil MCU Saya" />

<x-common.component-card title="Hasil MCU Saya">
    @if($mcuResults->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-theme-sm">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800">
                        <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">No</th>
                        <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Tanggal Pemeriksaan</th>
                        <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Diagnosis</th>
                        <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Status Kesehatan</th>
                        <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">File Hasil</th>
                        <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mcuResults as $index => $result)
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <td class="py-3">{{ $index + 1 }}</td>
                            <td class="py-3 font-medium text-gray-800 dark:text-white/90">{{ $result->tanggal_pemeriksaan_formatted }}</td>
                            <td class="py-3 max-w-xs">
                                @php $dx = $result->diagnosis_text ?? null; @endphp
                                @if($dx && $dx !== '-')
                                    {{ $dx }}
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="py-3">
                                <span class="inline-flex rounded-full px-2.5 py-0.5 text-theme-xs font-medium
                                    @if(($result->status_kesehatan_color ?? '') === 'success') bg-success-100 text-success-700 dark:bg-success-500/20 dark:text-success-400
                                    @elseif(($result->status_kesehatan_color ?? '') === 'warning') bg-warning-100 text-warning-700 dark:bg-warning-500/20 dark:text-warning-400
                                    @elseif(($result->status_kesehatan_color ?? '') === 'danger') bg-error-100 text-error-700 dark:bg-error-500/20 dark:text-error-400
                                    @else bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 @endif">{{ $result->status_kesehatan }}</span>
                            </td>
                            <td class="py-3">
                                @if($result->hasFile())
                                    <span class="inline-flex rounded-full bg-success-100 px-2.5 py-0.5 text-theme-xs font-medium text-success-700 dark:bg-success-500/20 dark:text-success-400">Tersedia</span>
                                @else
                                    <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-0.5 text-theme-xs font-medium text-gray-600 dark:bg-gray-700 dark:text-gray-400">Tidak Ada</span>
                                @endif
                            </td>
                            <td class="py-3">
                                @if($result->hasFile())
                                    <a href="{{ route('client.results.downloadAll', ['result' => $result->id]) }}" class="inline-flex rounded-lg bg-brand-500 px-3 py-1.5 text-theme-sm font-medium text-white hover:bg-brand-600">Download</a>
                                @else
                                    <span class="text-theme-sm text-gray-500">Tidak Tersedia</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($mcuResults->hasPages())
            <div class="mt-4">{{ $mcuResults->links() }}</div>
        @endif
    @else
        <div class="py-12 text-center">
            <p class="text-lg font-medium text-gray-800 dark:text-white/90">Belum Ada Hasil MCU</p>
            <p class="mt-1 text-theme-sm text-gray-500 dark:text-gray-400">Hasil MCU akan muncul setelah pemeriksaan selesai dan diupload oleh administrator.</p>
        </div>
    @endif
</x-common.component-card>

@if($mcuResults->count() > 0)
    <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-4">
        <div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
            <p class="text-theme-xs text-gray-500 dark:text-gray-400">Total Hasil</p>
            <p class="text-2xl font-semibold text-gray-800 dark:text-white/90">{{ $mcuResults->total() }}</p>
        </div>
        <div class="rounded-2xl border border-success-200 bg-success-50 p-4 dark:border-success-800 dark:bg-success-500/10">
            <p class="text-theme-xs text-success-700 dark:text-success-400">Sehat</p>
            <p class="text-2xl font-semibold text-success-800 dark:text-success-300">{{ $mcuResults->where('status_kesehatan', 'Sehat')->count() }}</p>
        </div>
        <div class="rounded-2xl border border-warning-200 bg-warning-50 p-4 dark:border-warning-800 dark:bg-warning-500/10">
            <p class="text-theme-xs text-warning-700 dark:text-warning-400">Kurang Sehat</p>
            <p class="text-2xl font-semibold text-warning-800 dark:text-warning-300">{{ $mcuResults->where('status_kesehatan', 'Kurang Sehat')->count() }}</p>
        </div>
        <div class="rounded-2xl border border-error-200 bg-error-50 p-4 dark:border-error-800 dark:bg-error-500/10">
            <p class="text-theme-xs text-error-700 dark:text-error-400">Tidak Sehat</p>
            <p class="text-2xl font-semibold text-error-800 dark:text-error-300">{{ $mcuResults->where('status_kesehatan', 'Tidak Sehat')->count() }}</p>
        </div>
    </div>

    @php $latestResult = $mcuResults->first(); @endphp
    @if($latestResult)
        <x-common.component-card title="Detail Hasil Terbaru" class="mt-6">
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <p class="mb-1 text-theme-sm font-medium text-gray-700 dark:text-gray-300">Hasil Pemeriksaan</p>
                    <div class="rounded-lg border border-gray-200 bg-gray-50 p-3 text-theme-sm dark:border-gray-800 dark:bg-gray-900/50">{{ $latestResult->hasil_pemeriksaan }}</div>
                </div>
                <div>
                    <p class="mb-1 text-theme-sm font-medium text-gray-700 dark:text-gray-300">Rekomendasi</p>
                    <div class="rounded-lg border border-gray-200 bg-gray-50 p-3 text-theme-sm dark:border-gray-800 dark:bg-gray-900/50">{{ $latestResult->rekomendasi ?: 'Tidak ada rekomendasi khusus' }}</div>
                </div>
                <div class="sm:col-span-2">
                    <p class="mb-1 text-theme-sm font-medium text-gray-700 dark:text-gray-300">Rekomendasi Dokter Spesialis</p>
                    <div class="rounded-lg border border-gray-200 bg-gray-50 p-3 text-theme-sm dark:border-gray-800 dark:bg-gray-900/50">{{ $latestResult->rekomendasi_dokter_spesialis ?: 'Tidak ada rekomendasi dokter spesialis' }}</div>
                </div>
            </div>
        </x-common.component-card>
    @endif
@endif
@endsection
