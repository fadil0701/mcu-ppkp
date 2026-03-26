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
                        <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Dokumen</th>
                        <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mcuResults as $index => $result)
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <td class="py-3">{{ $index + 1 }}</td>
                            <td class="py-3 font-medium text-gray-800 dark:text-white/90">{{ $result->tanggal_pemeriksaan_formatted }}</td>
                            <td class="py-3">
                                @if($result->hasFile())
                                    @php $files = $result->file_hasil_files ?? ($result->file_hasil ? [$result->file_hasil] : []); @endphp
                                    <span class="inline-flex rounded-full bg-success-100 px-2.5 py-0.5 text-theme-xs font-medium text-success-700 dark:bg-success-500/20 dark:text-success-400">
                                        {{ count($files) }} file tersedia
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-0.5 text-theme-xs font-medium text-gray-600 dark:bg-gray-700 dark:text-gray-400">Tidak Ada</span>
                                @endif
                            </td>
                            <td class="py-3">
                                @if($result->hasFile())
                                    <a href="{{ route('client.results.downloadAll', ['result' => $result->id]) }}" class="inline-flex items-center gap-1.5 rounded-lg bg-brand-500 px-3 py-1.5 text-theme-sm font-medium text-white hover:bg-brand-600">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                        Download Semua
                                    </a>
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
    <div class="mt-6">
        <div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03] max-w-xs">
            <p class="text-theme-xs text-gray-500 dark:text-gray-400">Total Hasil MCU</p>
            <p class="text-2xl font-semibold text-gray-800 dark:text-white/90">{{ $mcuResults->total() }}</p>
        </div>
    </div>

    @php $latestResult = $mcuResults->first(); @endphp
    @if($latestResult && $latestResult->hasFile())
        @php $files = $latestResult->file_hasil_files ?? ($latestResult->file_hasil ? [$latestResult->file_hasil] : []); $fileCount = count($files); @endphp
        <x-common.component-card title="Hasil MCU Terbaru" class="mt-6">
            <p class="mb-4 text-theme-sm text-gray-600 dark:text-gray-400">Hasil MCU pemeriksaan tanggal {{ $latestResult->tanggal_pemeriksaan_formatted }}{{ $fileCount > 1 ? ' — ' . $fileCount . ' dokumen tersedia' : '' }}</p>
            <a href="{{ route('client.results.downloadAll', ['result' => $latestResult->id]) }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-theme-sm font-medium text-white hover:bg-brand-600">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Download {{ $fileCount > 1 ? 'Semua Dokumen (ZIP)' : 'Dokumen' }}
            </a>
        </x-common.component-card>
    @endif
@endif
@endsection
