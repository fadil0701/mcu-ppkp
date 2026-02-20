@extends('layouts.app')

@section('title', 'Jadwal MCU')

@section('content')
<x-common.page-breadcrumb pageTitle="Jadwal MCU" />

@if(session('success'))
    <div class="mb-4 rounded-lg border border-success-200 bg-success-50 p-4 text-theme-sm text-success-800 dark:border-success-800 dark:bg-success-500/10 dark:text-success-400">{{ session('success') }}</div>
@endif
@if($errors->has('send'))
    <div class="mb-4 rounded-lg border border-error-200 bg-error-50 p-4 text-theme-sm text-error-800 dark:border-error-800 dark:bg-error-500/10 dark:text-error-400">{{ $errors->first('send') }}</div>
@endif

<x-common.component-card title="Daftar Jadwal MCU">
    <div class="mb-4 flex flex-wrap items-center gap-2">
        <form method="GET" class="inline-flex flex-wrap items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIK, lokasi..." class="rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 w-64">
            <input type="date" name="date" value="{{ request('date') }}" onclick="this.showPicker?.()" class="rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800">
            <select name="status" class="rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800">
                <option value="">Semua Status</option>
                <option value="Terjadwal" {{ request('status') === 'Terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                <option value="Selesai" {{ request('status') === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="Batal" {{ request('status') === 'Batal' ? 'selected' : '' }}>Batal</option>
                <option value="Ditolak" {{ request('status') === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
            <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-theme-sm font-medium text-white hover:bg-brand-600">Cari</button>
        </form>
        <a href="{{ route('admin.schedules.create') }}" class="rounded-lg border border-brand-500 px-4 py-2 text-theme-sm font-medium text-brand-500 hover:bg-brand-50 dark:hover:bg-brand-500/10">Tambah Jadwal</a>
        <button type="button" id="bulk-delete-btn" class="rounded-lg border border-error-200 bg-error-50 px-4 py-2 text-theme-sm font-medium text-error-700 hover:bg-error-100 dark:border-error-800 dark:bg-error-500/10 dark:text-error-400 dark:hover:bg-error-500/20 disabled:opacity-50 disabled:cursor-not-allowed" disabled>Bulk Hapus (<span id="selected-count">0</span>)</button>
    </div>

    <form id="bulk-delete-form" method="POST" action="{{ route('admin.schedules.bulk-destroy') }}">
        @csrf
        <input type="hidden" name="search" value="{{ request('search') }}">
        <input type="hidden" name="date" value="{{ request('date') }}">
        <input type="hidden" name="status" value="{{ request('status') }}">
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-theme-sm">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-800">
                    <th class="w-10 pb-3 text-left">
                        <input type="checkbox" id="select-all" class="h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-800" title="Pilih semua">
                    </th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Tanggal</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Peserta</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Lokasi</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">No. Antrian</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Status</th>
                    <th class="pb-3 text-center font-medium text-gray-700 dark:text-gray-300">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schedules as $s)
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <td class="w-10 py-3">
                            <input type="checkbox" value="{{ $s->id }}" class="schedule-checkbox h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-800">
                        </td>
                        <td class="py-3">{{ $s->tanggal_pemeriksaan?->format('d/m/Y') }}</td>
                        <td class="py-3 font-medium text-gray-800 dark:text-white/90">{{ $s->nama_lengkap ?? $s->participant?->nama_lengkap }}</td>
                        <td class="py-3 max-w-xs truncate" title="{{ $s->lokasi_pemeriksaan }}">{{ $s->lokasi_pemeriksaan }}</td>
                        <td class="py-3">{{ $s->queue_number ?? '-' }}</td>
                        <td class="py-3">
                            <span class="inline-flex rounded-full px-2.5 py-0.5 text-theme-xs font-medium
                                {{ $s->status === 'Selesai' ? 'bg-success-100 text-success-700 dark:bg-success-500/20' : ($s->status === 'Ditolak' || $s->status === 'Batal' ? 'bg-error-100 text-error-700 dark:bg-error-500/20' : 'bg-warning-100 text-warning-700 dark:bg-warning-500/20') }}">{{ $s->status }}</span>
                        </td>
                        <td class="py-3 ">
                            <div class="flex flex-wrap items-center justify-end gap-2">
                                <form method="POST" action="{{ route('admin.schedules.send-whatsapp', $s) }}" class="inline" onsubmit="return confirm('Kirim jadwal MCU via WhatsApp ke {{ addslashes($s->nama_lengkap) }}?');">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1 rounded-lg border border-success-200 bg-success-50 px-2 py-1 text-theme-xs font-medium text-success-700 hover:bg-success-100 dark:border-success-800 dark:bg-success-500/10 dark:text-success-400 dark:hover:bg-success-500/20" title="Kirim WA">📱 WA</button>
                                </form>
                                <form method="POST" action="{{ route('admin.schedules.send-email', $s) }}" class="inline" onsubmit="return confirm('Kirim jadwal MCU via Email ke {{ addslashes($s->email ?? $s->nama_lengkap) }}?');">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1 rounded-lg border border-brand-200 bg-brand-50 px-2 py-1 text-theme-xs font-medium text-brand-700 hover:bg-brand-100 dark:border-brand-800 dark:bg-brand-500/10 dark:text-brand-400 dark:hover:bg-brand-500/20" title="Kirim Email">✉ Email</button>
                                </form>
                                <x-admin.action-badge type="edit" :href="route('admin.schedules.edit', $s)" />
                                <x-admin.action-badge type="delete" :href="route('admin.schedules.destroy', $s)" confirm="Yakin hapus jadwal ini?" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="py-6 text-center text-gray-500">Belum ada jadwal.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $schedules->links() }}</div>

    <script>
        (function() {
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.schedule-checkbox');
            const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
            const selectedCount = document.getElementById('selected-count');
            const bulkDeleteForm = document.getElementById('bulk-delete-form');

            function updateUI() {
                const checked = document.querySelectorAll('.schedule-checkbox:checked');
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
                if (!confirm('Yakin hapus jadwal yang dipilih?')) return;
                const ids = Array.from(document.querySelectorAll('.schedule-checkbox:checked')).map(cb => cb.value);
                bulkDeleteForm.querySelectorAll('input[name="ids[]"]').forEach(el => el.remove());
                ids.forEach(function(id) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = id;
                    bulkDeleteForm.appendChild(input);
                });
                bulkDeleteForm.submit();
            });
            updateUI();
        })();
    </script>
</x-common.component-card>
@endsection
