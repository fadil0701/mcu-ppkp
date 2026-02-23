@extends('layouts.app')

@section('title', 'Edit Hasil MCU')

@section('content')
<x-common.page-breadcrumb pageTitle="Edit Hasil MCU" />

@if(session('success'))
    <div class="mb-4 rounded-lg border border-success-200 bg-success-50 p-4 text-theme-sm text-success-800 dark:border-success-800 dark:bg-success-500/10 dark:text-success-400">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="mb-4 rounded-lg border border-error-200 bg-error-50 p-4 text-theme-sm text-error-800 dark:border-error-800 dark:bg-error-500/10 dark:text-error-400">{{ $errors->first() }}</div>
@endif

<x-common.component-card title="Form Hasil MCU">
    <form method="POST" action="{{ route('admin.mcu-results.update-post', $mcuResult) }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div class="grid gap-4 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <x-form.searchable-select
                    name="participant_id"
                    label="Peserta *"
                    :options="$participants"
                    value-key="id"
                    label-key="nama_lengkap"
                    sublabel-key="nik_ktp"
                    placeholder="-- Pilih Peserta --"
                    :value="old('participant_id', $mcuResult->participant_id)"
                    :required="true"
                />
            </div>
            <div>
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Pemeriksaan *</label>
                <input type="date" name="tanggal_pemeriksaan" value="{{ old('tanggal_pemeriksaan', $mcuResult->tanggal_pemeriksaan?->format('Y-m-d')) }}" max="{{ now()->format('Y-m-d') }}" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
            </div>
            <div>
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Status Kesehatan *</label>
                <select name="status_kesehatan" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
                    <option value="Sehat" {{ old('status_kesehatan', $mcuResult->status_kesehatan) === 'Sehat' ? 'selected' : '' }}>Sehat</option>
                    <option value="Kurang Sehat" {{ old('status_kesehatan', $mcuResult->status_kesehatan) === 'Kurang Sehat' ? 'selected' : '' }}>Kurang Sehat</option>
                    <option value="Tidak Sehat" {{ old('status_kesehatan', $mcuResult->status_kesehatan) === 'Tidak Sehat' ? 'selected' : '' }}>Tidak Sehat</option>
                </select>
            </div>
            <div class="sm:col-span-2">
                <x-form.searchable-multi-select
                    name="diagnosis_ids"
                    label="Diagnosis (bisa pilih beberapa)"
                    :options="$diagnoses->map(fn($d) => (object)['id' => $d->id, 'label' => $d->code ? $d->code . ' - ' . $d->name : $d->name])"
                    value-key="id"
                    label-key="label"
                    placeholder="Ketik kode atau nama diagnosis..."
                    :selected-ids="old('diagnosis_ids', $diagnosisIds ?? [])"
                />
            </div>
            <div class="sm:col-span-2">
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Hasil Pemeriksaan</label>
                <textarea name="hasil_pemeriksaan" rows="3" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">{{ old('hasil_pemeriksaan', $mcuResult->hasil_pemeriksaan) }}</textarea>
            </div>
            <div class="sm:col-span-2">
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Rekomendasi</label>
                <textarea name="rekomendasi" rows="3" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90" placeholder="Tulis rekomendasi secara bebas...">{{ old('rekomendasi', $mcuResult->rekomendasi) }}</textarea>
            </div>
            <div class="sm:col-span-2">
                <x-form.searchable-multi-select
                    name="specialist_doctor_ids"
                    label="Rujukan Dokter Spesialis - bisa pilih beberapa"
                    :options="$specialistDoctors"
                    value-key="id"
                    label-key="name"
                    sublabel-key="specialty"
                    placeholder="Ketik nama atau spesialisasi..."
                    :selected-ids="old('specialist_doctor_ids', $specialistDoctorIds ?? [])"
                />
            </div>
            <div class="sm:col-span-2">
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Dokumen Hasil MCU</label>
                @if($mcuResult->hasFile())
                    <div class="mb-2 space-y-1">
                        @foreach($mcuResult->file_urls as $url)
                            <a href="{{ $url }}" target="_blank" class="flex items-center gap-2 text-theme-sm text-brand-600 hover:underline dark:text-brand-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                {{ basename(parse_url($url, PHP_URL_PATH)) }}
                            </a>
                        @endforeach
                    </div>
                @endif
                <input type="file" name="file_hasil[]" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.bmp,.tiff" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm file:mr-3 file:rounded file:border-0 file:bg-brand-50 file:px-4 file:py-2 file:text-theme-sm file:font-medium file:text-brand-700 dark:border-gray-800 dark:bg-gray-800 dark:text-white/90 dark:file:bg-brand-500/20 dark:file:text-brand-400">
                <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">PDF, DOC, DOCX, JPG, PNG. Maks 10MB per file. Upload baru akan ditambahkan ke dokumen yang ada.</p>
            </div>
            <div>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', $mcuResult->is_published) ? 'checked' : '' }} class="rounded border-gray-300">
                    <span class="text-theme-sm text-gray-700 dark:text-gray-300">Publikasikan ke peserta</span>
                </label>
            </div>
        </div>
        <div class="flex flex-wrap gap-2 pt-4">
            <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-theme-sm font-medium text-white hover:bg-brand-600">Simpan</button>
            @if($mcuResult->participant?->email)
            <form method="POST" action="{{ route('admin.mcu-results.send-email', $mcuResult) }}" class="inline">
                @csrf
                <button type="submit" class="rounded-lg border border-gray-300 px-4 py-2 text-theme-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-800 inline-flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
                    Kirim via Email
                </button>
            </form>
            @endif
            @if($mcuResult->participant?->no_telp)
            <form method="POST" action="{{ route('admin.mcu-results.send-whatsapp', $mcuResult) }}" class="inline">
                @csrf
                <button type="submit" class="rounded-lg border border-success-300 px-4 py-2 text-theme-sm font-medium text-success-700 hover:bg-success-50 dark:border-success-600 dark:text-success-400 dark:hover:bg-success-500/10 inline-flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    Kirim via WhatsApp
                </button>
            </form>
            @endif
            <a href="{{ route('admin.mcu-results.index') }}" class="rounded-lg border border-gray-200 px-4 py-2 text-theme-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-300 dark:hover:bg-white/5">Batal</a>
        </div>
    </form>
</x-common.component-card>
@endsection
