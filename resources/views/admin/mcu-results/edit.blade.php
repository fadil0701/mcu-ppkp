@extends('layouts.app')

@section('title', 'Edit Hasil MCU')

@section('content')
<x-common.page-breadcrumb pageTitle="Edit Hasil MCU" />

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
        <div class="flex gap-2 pt-4">
            <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-theme-sm font-medium text-white hover:bg-brand-600">Simpan</button>
            <a href="{{ route('admin.mcu-results.index') }}" class="rounded-lg border border-gray-200 px-4 py-2 text-theme-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-300 dark:hover:bg-white/5">Batal</a>
        </div>
    </form>
</x-common.component-card>
@endsection
