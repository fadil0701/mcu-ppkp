@extends('client.layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Profile Saya</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    @if($participant)
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="card-title mb-4">Informasi Pribadi</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="150"><strong>NIK KTP</strong></td>
                                        <td>: {{ $participant->nik_ktp }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>NRK Pegawai</strong></td>
                                        <td>: {{ $participant->nrk_pegawai }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nama Lengkap</strong></td>
                                        <td>: {{ $participant->nama_lengkap }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tempat Lahir</strong></td>
                                        <td>: {{ $participant->tempat_lahir }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tanggal Lahir</strong></td>
                                        <td>: {{ $participant->tanggal_lahir_formatted }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jenis Kelamin</strong></td>
                                        <td>: {{ $participant->jenis_kelamin_text }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Umur</strong></td>
                                        <td>: {{ $participant->umur }} tahun</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5 class="card-title mb-4">Informasi Instansi</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="150"><strong>SKPD</strong></td>
                                        <td>: {{ $participant->skpd }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>UKPD</strong></td>
                                        <td>: {{ $participant->ukpd }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status Pegawai</strong></td>
                                        <td>: {{ $participant->status_pegawai }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>No. Telepon</strong></td>
                                        <td>: {{ $participant->no_telp }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email</strong></td>
                                        <td>: {{ $participant->email }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-12">
                                <h5 class="card-title mb-4">Status MCU</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Status MCU</h6>
                                                <span class="badge bg-{{ $participant->status_mcu_color }}">
                                                    {{ $participant->status_mcu }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">MCU Terakhir</h6>
                                                <p class="mb-0">
                                                    {{ $participant->tanggal_mcu_terakhir ? $participant->tanggal_mcu_terakhir_formatted : 'Belum pernah MCU' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Kategori Umur</h6>
                                                <p class="mb-0">{{ $participant->kategori_umur }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($participant->catatan)
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <h5 class="card-title mb-4">Catatan</h5>
                                <div class="alert alert-info">
                                    {{ $participant->catatan }}
                                </div>
                            </div>
                        </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-user-slash fa-3x text-muted"></i>
                            </div>
                            <h5>Data Peserta Tidak Ditemukan</h5>
                            <p class="text-muted">Data peserta MCU Anda belum terdaftar dalam sistem.</p>
                            <p class="text-muted">Silakan hubungi administrator untuk mendaftarkan data Anda.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Informasi Akun</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td width="120"><strong>Nama</strong></td>
                            <td>: {{ Auth::user()->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email</strong></td>
                            <td>: {{ Auth::user()->email }}</td>
                        </tr>
                        <tr>
                            <td><strong>Role</strong></td>
                            <td>: {{ Auth::user()->role_label }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>: 
                                <span class="badge bg-{{ Auth::user()->is_active ? 'success' : 'danger' }}">
                                    {{ Auth::user()->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
