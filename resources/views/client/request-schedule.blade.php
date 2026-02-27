@extends('layouts.app')

@section('title', 'Pendaftaran Ulang MCU')

@section('content')
<x-common.page-breadcrumb pageTitle="Pendaftaran Ulang MCU" />

@if (session('success'))
    <div class="mb-4 rounded-lg border border-success-200 bg-success-50 p-4 text-theme-sm text-success-800 dark:border-success-800 dark:bg-success-500/10 dark:text-success-400">{{ session('success') }}</div>
@endif
@if ($errors->any())
    <div class="mb-4 rounded-lg border border-error-200 bg-error-50 p-4 text-theme-sm text-error-800 dark:border-error-800 dark:bg-error-500/10 dark:text-error-400">
        <ul class="list-inside list-disc">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(!$eligible)
    <div class="mb-4 rounded-lg border border-warning-200 bg-warning-50 p-4 text-theme-sm text-warning-800 dark:border-warning-800 dark:bg-warning-500/10 dark:text-warning-400">
        {{ $reason }}
    </div>
@endif

<div class="grid gap-6 lg:grid-cols-3">
    <div class="lg:col-span-2">
        <x-common.component-card title="Form Pengajuan Jadwal">
            <form method="POST" action="{{ route('client.schedule.request.store') }}" class="space-y-4"
                x-data="requestScheduleForm({{ json_encode(config('mcu.default_location')) }}, {{ $eligible ? 'true' : 'false' }})">
                @csrf
                <div>
                    <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Pemeriksaan</label>
                    <div class="relative">
                        <input type="text" name="tanggal_pemeriksaan" x-ref="dateInput" value="{{ old('tanggal_pemeriksaan') }}"
                            placeholder="dd/mm/yyyy"
                            class="w-full rounded-lg border border-gray-200 px-3 py-2 pr-10 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90"
                            {{ $eligible ? '' : 'disabled' }} required>
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" class="size-5"><path fill-rule="evenodd" clip-rule="evenodd" d="M8 2C8.41421 2 8.75 2.33579 8.75 2.75V3.75H15.25V2.75C15.25 2.33579 15.5858 2 16 2C16.4142 2 16.75 2.33579 16.75 2.75V3.75H18.5C19.7426 3.75 20.75 4.75736 20.75 6V9V19C20.75 20.2426 19.7426 21.25 18.5 21.25H5.5C4.25736 21.25 3.25 20.2426 3.25 19V9V6C3.25 4.75736 4.25736 3.75 5.5 3.75H7.25V2.75C7.25 2.33579 7.58579 2 8 2Z" fill="currentColor"></path></svg>
                        </span>
                    </div>
                    <p x-show="quotaText" x-text="quotaText" class="mt-1 text-theme-sm" :class="quotaError ? 'text-error-600 dark:text-error-400' : 'text-gray-600 dark:text-gray-400'"></p>
                </div>
                <div>
                    <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Jam Pemeriksaan</label>
                    <input type="time" name="jam_pemeriksaan" value="{{ old('jam_pemeriksaan') }}"
                        class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90"
                        {{ $eligible ? '' : 'disabled' }} required>
                </div>
                <div>
                    <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Lokasi Pemeriksaan</label>
                    <input type="hidden" name="lokasi_pemeriksaan" value="{{ config('mcu.default_location') }}">
                    <p class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-theme-sm text-gray-700 dark:border-gray-800 dark:bg-gray-800 dark:text-gray-300">{{ config('mcu.default_location') }}</p>
                </div>
                <div>
                    <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Catatan (opsional)</label>
                    <textarea name="catatan" rows="3" {{ $eligible ? '' : 'disabled' }}
                        class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">{{ old('catatan') }}</textarea>
                </div>
                <button type="submit" class="w-full rounded-lg bg-brand-500 px-4 py-2.5 text-theme-sm font-medium text-white hover:bg-brand-600 disabled:opacity-50" {{ $eligible ? '' : 'disabled' }}>
                    Ajukan Jadwal
                </button>
            </form>
        </x-common.component-card>
    </div>
    <div>
        <x-common.component-card title="Status Kelayakan">
            <ul class="space-y-3 text-theme-sm">
                <li class="flex items-center gap-2 text-gray-800 dark:text-white/90">{{ $participant->nama_lengkap }}</li>
                <li class="flex items-center gap-2 text-gray-600 dark:text-gray-400">NIK: {{ $participant->nik_ktp }}</li>
                <li class="flex items-center gap-2 text-gray-600 dark:text-gray-400">{{ $participant->skpd }}</li>
                <li class="flex items-center gap-2 text-gray-600 dark:text-gray-400">Terakhir MCU: {{ $participant->tanggal_mcu_terakhir_formatted }}</li>
                <li class="flex items-center gap-2">
                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-theme-xs font-medium {{ $eligible ? 'bg-success-100 text-success-700 dark:bg-success-500/20 dark:text-success-400' : 'bg-warning-100 text-warning-700 dark:bg-warning-500/20 dark:text-warning-400' }}">
                        Kelayakan: {{ $eligible ? 'Memenuhi syarat' : 'Belum memenuhi' }}
                    </span>
                </li>
            </ul>
        </x-common.component-card>
    </div>
</div>

@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('requestScheduleForm', (location, enabled) => ({
        fp: null,
        quotaText: '',
        quotaError: false,
        init() {
            this.$nextTick(() => {
                const input = this.$refs.dateInput;
                if (typeof flatpickr === 'undefined' || !input) return;
                this.fp = flatpickr(input, {
                    locale: 'id',
                    dateFormat: 'Y-m-d',
                    altInput: true,
                    altFormat: 'd/m/Y',
                    minDate: 'today',
                    disable: !enabled,
                    onChange: (dates, dateStr) => this.fetchQuota(dateStr, location)
                });
                if (input.value && input.value.length >= 10) this.fetchQuota(input.value, location);
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
