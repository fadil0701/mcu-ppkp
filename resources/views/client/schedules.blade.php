@extends('layouts.app')

@section('title', 'Jadwal MCU Saya')

@section('content')
<x-common.page-breadcrumb pageTitle="Jadwal MCU Saya" />

@if(session('success'))
    <div class="mb-4 rounded-lg border border-success-200 bg-success-50 p-4 text-theme-sm text-success-800 dark:border-success-800 dark:bg-success-500/10 dark:text-success-400">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="mb-4 rounded-lg border border-error-200 bg-error-50 p-4 text-theme-sm text-error-800 dark:border-error-800 dark:bg-error-500/10 dark:text-error-400">
        <ul class="list-inside list-disc">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<x-common.component-card title="Jadwal MCU Saya">
    @if($schedules->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-theme-sm">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800">
                        <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">No</th>
                        <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Tanggal</th>
                        <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Jam</th>
                        <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Lokasi</th>
                        <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">No. Antrian</th>
                        <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Status</th>
                        <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($schedules as $index => $schedule)
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <td class="py-3">{{ $index + 1 }}</td>
                            <td class="py-3">{{ $schedule->tanggal_pemeriksaan_formatted }}</td>
                            <td class="py-3">{{ $schedule->jam_pemeriksaan_formatted }}</td>
                            <td class="py-3 max-w-xs truncate" title="{{ $schedule->lokasi_pemeriksaan }}">{{ $schedule->lokasi_pemeriksaan }}</td>
                            <td class="py-3">
                                @if($schedule->queue_number)
                                    <span class="inline-flex rounded-full bg-brand-100 px-2.5 py-0.5 text-theme-xs font-medium text-brand-700 dark:bg-brand-500/20 dark:text-brand-400">{{ $schedule->queue_number }}</span>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="py-3">
                                <span class="inline-flex rounded-full px-2.5 py-0.5 text-theme-xs font-medium
                                    @if(($schedule->status_color ?? '') === 'success') bg-success-100 text-success-700 dark:bg-success-500/20 dark:text-success-400
                                    @elseif(($schedule->status_color ?? '') === 'warning') bg-warning-100 text-warning-700 dark:bg-warning-500/20 dark:text-warning-400
                                    @elseif(($schedule->status_color ?? '') === 'danger') bg-error-100 text-error-700 dark:bg-error-500/20 dark:text-error-400
                                    @else bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 @endif">{{ $schedule->status }}</span>
                                @if($schedule->participant_confirmed)
                                    <span class="ml-1 inline-flex rounded-full bg-success-100 px-2.5 py-0.5 text-theme-xs font-medium text-success-700 dark:bg-success-500/20 dark:text-success-400">Confirmed</span>
                                @endif
                                @if($schedule->reschedule_requested)
                                    <span class="ml-1 inline-flex rounded-full bg-warning-100 px-2.5 py-0.5 text-theme-xs font-medium text-warning-700 dark:bg-warning-500/20 dark:text-warning-400">Reschedule Requested</span>
                                @endif
                            </td>
                            <td class="py-3">
                                @if($schedule->status === 'Terjadwal' && !$schedule->participant_confirmed)
                                    <form method="POST" action="{{ route('client.schedule.confirm', $schedule->id) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="rounded-lg bg-success-500 px-3 py-1.5 text-theme-sm font-medium text-white hover:bg-success-600">Konfirmasi Hadir</button>
                                    </form>
                                    <div x-data="{ open: false }" class="inline">
                                        <button @click="open = !open" type="button" class="ml-1 rounded-lg border border-warning-300 px-3 py-1.5 text-theme-sm text-warning-700 hover:bg-warning-50 dark:border-warning-700 dark:text-warning-400 dark:hover:bg-warning-500/10">Reschedule</button>
                                        <div x-show="open" class="mt-2 rounded-lg border border-gray-200 bg-gray-50 p-3 dark:border-gray-800 dark:bg-gray-900/50">
                                            <form method="POST" action="{{ route('client.schedule.reschedule', $schedule->id) }}" class="flex flex-wrap items-end gap-2" x-data="rescheduleForm({{ json_encode($schedule->lokasi_pemeriksaan ?? config('mcu.default_location')) }})">
                                                @csrf
                                                <div class="relative">
                                                    <input type="text" name="new_date" x-ref="dateInput" readonly placeholder="dd/mm/yyyy" class="min-w-[140px] rounded-lg border border-gray-200 px-3 py-2 pr-9 text-theme-sm dark:border-gray-800 dark:bg-gray-800" required>
                                                    <span class="absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none text-gray-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" class="size-5"><path fill-rule="evenodd" clip-rule="evenodd" d="M8 2C8.41421 2 8.75 2.33579 8.75 2.75V3.75H15.25V2.75C15.25 2.33579 15.5858 2 16 2C16.4142 2 16.75 2.33579 16.75 2.75V3.75H18.5C19.7426 3.75 20.75 4.75736 20.75 6V9V19C20.75 20.2426 19.7426 21.25 18.5 21.25H5.5C4.25736 21.25 3.25 20.2426 3.25 19V9V6C3.25 4.75736 4.25736 3.75 5.5 3.75H7.25V2.75C7.25 2.33579 7.58579 2 8 2Z" fill="currentColor"></path></svg>
                                                    </span>
                                                </div>
                                                <input type="time" name="new_time" class="rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800" required>
                                                <input type="text" name="reason" class="min-w-[180px] rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800" placeholder="Alasan reschedule" required>
                                                <button type="submit" class="rounded-lg bg-brand-500 px-3 py-2 text-theme-sm font-medium text-white hover:bg-brand-600">Kirim Permintaan</button>
                                                <p x-show="quotaText" x-text="quotaText" class="w-full text-theme-sm mt-1" :class="quotaError ? 'text-error-600 dark:text-error-400' : 'text-gray-600 dark:text-gray-400'"></p>
                                            </form>
                                        </div>
                                    </div>
                                    <div x-data="{ open: false }" class="inline">
                                        <button @click="open = !open" type="button" class="ml-1 rounded-lg border border-error-300 px-3 py-1.5 text-theme-sm text-error-700 hover:bg-error-50 dark:border-error-700 dark:text-error-400 dark:hover:bg-error-500/10">Batalkan Jadwal</button>
                                        <div x-show="open" class="mt-2 rounded-lg border border-gray-200 bg-gray-50 p-3 dark:border-gray-800 dark:bg-gray-900/50">
                                            <form method="POST" action="{{ route('client.schedule.cancel', $schedule->id) }}">
                                                @csrf
                                                <input type="text" name="cancel_reason" class="mb-2 w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800" placeholder="Alasan pembatalan" required>
                                                <button type="submit" class="rounded-lg bg-error-500 px-3 py-2 text-theme-sm font-medium text-white hover:bg-error-600">Kirim Pembatalan</button>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-gray-500 text-theme-sm">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if(method_exists($schedules, 'links') && $schedules->hasPages())
            <div class="mt-4">{{ $schedules->links() }}</div>
        @endif
    @else
        <div class="py-12 text-center">
            <p class="text-lg font-medium text-gray-800 dark:text-white/90">Belum Ada Jadwal MCU</p>
            <p class="mt-1 text-theme-sm text-gray-500 dark:text-gray-400">Anda belum memiliki jadwal MCU.</p>
        </div>
    @endif
</x-common.component-card>

@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('rescheduleForm', (location) => ({
        fp: null,
        quotaText: '',
        quotaError: false,
        init() {
            this.$nextTick(() => {
                const input = this.$refs.dateInput;
                if (typeof flatpickr === 'undefined') return;
                this.fp = flatpickr(input, {
                    locale: 'id',
                    dateFormat: 'Y-m-d',
                    altInput: true,
                    altFormat: 'd/m/Y',
                    minDate: 'today',
                    onChange: (dates, dateStr) => this.fetchQuota(dateStr, location)
                });
            });
        },
        async fetchQuota(dateStr, location) {
            if (!dateStr) { this.quotaText = ''; return; }
            try {
                const r = await fetch('{{ route('client.schedule-quota') }}?date=' + encodeURIComponent(dateStr) + '&location=' + encodeURIComponent(location || ''));
                const d = await r.json();
                if (d.quota === null) {
                    this.quotaText = 'Sisa kuota: tidak dibatasi (' + d.count + ' terdaftar)';
                    this.quotaError = false;
                } else {
                    const sisa = d.remaining;
                    this.quotaText = 'Sisa kuota: ' + sisa + ' dari ' + d.quota + ' slot';
                    this.quotaError = sisa <= 0;
                }
            } catch (e) {
                this.quotaText = '';
            }
        }
    }));
});
</script>
@endpush
@endsection
