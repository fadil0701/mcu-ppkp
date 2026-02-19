@extends('layouts.app')

@section('title', 'Data Peserta')

@section('content')
<x-common.page-breadcrumb pageTitle="Data Peserta" />

@if(session('success'))
    <div class="mb-4 rounded-lg border border-success-200 bg-success-50 p-4 text-theme-sm text-success-800 dark:border-success-800 dark:bg-success-500/10 dark:text-success-400">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="mb-4 rounded-lg border border-error-200 bg-error-50 p-4 text-theme-sm text-error-800 dark:border-error-800 dark:bg-error-500/10 dark:text-error-400">{{ session('error') }}</div>
@endif

<x-common.component-card title="Daftar Peserta">
    <div class="mb-4 flex flex-wrap items-center gap-2">
        <form method="GET" class="inline-flex flex-wrap items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIK, NRK, SKPD..." class="rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90 w-64">
            <select name="status_mcu" class="rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
                <option value="">Semua Status MCU</option>
                <option value="Belum MCU" {{ request('status_mcu') === 'Belum MCU' ? 'selected' : '' }}>Belum MCU</option>
                <option value="Sudah MCU" {{ request('status_mcu') === 'Sudah MCU' ? 'selected' : '' }}>Sudah MCU</option>
                <option value="Ditolak" {{ request('status_mcu') === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
            <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-theme-sm font-medium text-white hover:bg-brand-600">Cari</button>
        </form>
        <a href="{{ route('participants.template') }}" target="_blank" class="rounded-lg border border-gray-300 px-4 py-2 text-theme-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-800">Download Template</a>
        <form action="{{ route('admin.participants.import') }}" method="POST" enctype="multipart/form-data" class="inline-flex items-center gap-2">
            @csrf
            <input type="file" name="file" accept=".xlsx,.xls,.csv" required class="rounded-lg border border-gray-200 px-2 py-1.5 text-theme-sm file:mr-2 file:rounded file:border-0 file:bg-brand-50 file:px-3 file:py-1 file:text-theme-sm file:font-medium file:text-brand-700 dark:border-gray-700 dark:file:bg-brand-500/10 dark:file:text-brand-400">
            <button type="submit" class="rounded-lg bg-success-500 px-4 py-2 text-theme-sm font-medium text-white hover:bg-success-600">Import Peserta</button>
        </form>
        <a href="{{ route('admin.participants.create') }}" class="rounded-lg border border-brand-500 px-4 py-2 text-theme-sm font-medium text-brand-500 hover:bg-brand-50 dark:hover:bg-brand-500/10">Tambah Peserta</a>
        <button type="button" id="bulk-delete-btn" class="rounded-lg border border-error-200 bg-error-50 px-4 py-2 text-theme-sm font-medium text-error-700 hover:bg-error-100 dark:border-error-800 dark:bg-error-500/10 dark:text-error-400 dark:hover:bg-error-500/20 disabled:opacity-50 disabled:cursor-not-allowed" disabled>Bulk Hapus (<span id="selected-count">0</span>)</button>
    </div>

    <form id="bulk-delete-form" method="POST" action="{{ route('admin.participants.bulk-destroy') }}">
        @csrf
        <input type="hidden" name="search" value="{{ request('search') }}">
        <input type="hidden" name="status_mcu" value="{{ request('status_mcu') }}">
    <div class="overflow-x-auto">
        <table class="w-full text-theme-sm">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-800">
                    <th class="w-10 pb-3 text-left">
                        <input type="checkbox" id="select-all" class="h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-800" title="Pilih semua">
                    </th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">NIK</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">NRK Pegawai</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Nama Lengkap</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">SKPD</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Status</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Status MCU</th>
                    <th class="pb-3 text-center font-medium text-gray-700 dark:text-gray-300">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($participants as $p)
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <td class="w-10 py-3">
                            <input type="checkbox" name="ids[]" value="{{ $p->id }}" class="participant-checkbox h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-800">
                        </td>
                        <td class="py-3">{{ $p->nik_ktp }}</td>
                        <td class="py-3">{{ $p->nrk_pegawai }}</td>
                        <td class="py-3 font-medium text-gray-800 dark:text-white/90">{{ $p->nama_lengkap }}</td>
                        <td class="py-3">{{ $p->skpd }}</td>
                        <td class="py-3">{{ $p->status_pegawai }}</td>
                        <td class="py-3">
                            <span class="inline-flex rounded-full px-2.5 py-0.5 text-theme-xs font-medium
                                {{ $p->status_mcu === 'Sudah MCU' ? 'bg-success-100 text-success-700 dark:bg-success-500/20 dark:text-success-400' : ($p->status_mcu === 'Ditolak' ? 'bg-error-100 text-error-700 dark:bg-error-500/20 dark:text-error-400' : 'bg-warning-100 text-warning-700 dark:bg-warning-500/20 dark:text-warning-400') }}">{{ $p->status_mcu }}</span>
                        </td>
                        <td class="py-3">
                            <div class="flex flex-wrap items-center justify-center  gap-2">
                                <x-admin.action-badge type="view" :href="route('admin.participants.show', $p)" />
                                <x-admin.action-badge type="edit" :href="route('admin.participants.edit', $p)" />
                                <x-admin.action-badge type="delete" :href="route('admin.participants.destroy', $p)" confirm="Yakin hapus peserta ini?" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="py-6 text-center text-gray-500">Belum ada data peserta.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $participants->links() }}</div>
    </form>

    <script>
        (function() {
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.participant-checkbox');
            const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
            const selectedCount = document.getElementById('selected-count');
            const bulkDeleteForm = document.getElementById('bulk-delete-form');

            function updateUI() {
                const checked = document.querySelectorAll('.participant-checkbox:checked');
                const count = checked.length;
                selectedCount.textContent = count;
                bulkDeleteBtn.disabled = count === 0;
                selectAll.checked = checkboxes.length > 0 && checked.length === checkboxes.length;
                selectAll.indeterminate = count > 0 && count < checkboxes.length;
            }

            selectAll?.addEventListener('change', function() {
                checkboxes.forEach(cb => { cb.checked = this.checked; });
                updateUI();
            });

            checkboxes.forEach(cb => cb.addEventListener('change', updateUI));

            bulkDeleteBtn?.addEventListener('click', function() {
                if (this.disabled) return;
                if (!confirm('Yakin hapus peserta yang dipilih?')) return;
                bulkDeleteForm.submit();
            });
            updateUI();
        })();
    </script>
</x-common.component-card>
@endsection
