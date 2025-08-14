<?php

namespace App\Imports;

use App\Models\Participant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ParticipantsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Basic normalization
        $data = [
            'nik_ktp' => (string) ($row['nik_ktp'] ?? ''),
            'nrk_pegawai' => (string) ($row['nrk_pegawai'] ?? ''),
            'nama_lengkap' => (string) ($row['nama_lengkap'] ?? ''),
            'tempat_lahir' => (string) ($row['tempat_lahir'] ?? ''),
            'tanggal_lahir' => (string) ($row['tanggal_lahir'] ?? ''),
            'jenis_kelamin' => strtoupper((string) ($row['jenis_kelamin'] ?? '')),
            'skpd' => (string) ($row['skpd'] ?? ''),
            'ukpd' => (string) ($row['ukpd'] ?? ''),
            'no_telp' => (string) ($row['no_telp'] ?? ''),
            'email' => (string) ($row['email'] ?? ''),
            'status_pegawai' => strtoupper((string) ($row['status_pegawai'] ?? '')),
            'status_mcu' => (string) ($row['status_mcu'] ?? 'Belum MCU'),
            'tanggal_mcu_terakhir' => $row['tanggal_mcu_terakhir'] ?? null,
            'catatan' => (string) ($row['catatan'] ?? null),
        ];

        // Coerce/format dates
        $data['tanggal_lahir'] = !empty($data['tanggal_lahir'])
            ? Carbon::parse($data['tanggal_lahir'])->format('Y-m-d')
            : null; // should be required but guard anyway

        $data['tanggal_mcu_terakhir'] = !empty($data['tanggal_mcu_terakhir'])
            ? Carbon::parse($data['tanggal_mcu_terakhir'])->format('Y-m-d')
            : null; // ensure NULL not empty string for nullable date

        // Normalize enums
        $allowedPegawai = ['CPNS', 'PNS', 'PPPK'];
        if (!in_array($data['status_pegawai'], $allowedPegawai, true)) {
            $data['status_pegawai'] = 'PNS';
        }

        $allowedMcu = ['Belum MCU', 'Sudah MCU', 'Ditolak'];
        if (!in_array($data['status_mcu'], $allowedMcu, true)) {
            $data['status_mcu'] = 'Belum MCU';
        }

        $data['jenis_kelamin'] = in_array($data['jenis_kelamin'], ['L', 'P'], true)
            ? $data['jenis_kelamin']
            : 'L';

        // Create model
        return new Participant($data);
    }
}


