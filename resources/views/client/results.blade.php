@extends('client.layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Hasil MCU Saya</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if($mcuResults->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Pemeriksaan</th>
                                        <th>Diagnosis</th>
                                        <th>Status Kesehatan</th>
                                        <th>File Hasil</th>
                                        <th>Download Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($mcuResults as $index => $result)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $result->tanggal_pemeriksaan_formatted }}</strong>
                                        </td>
                                        <td>
                                            @php
                                                $dx = $result->diagnosis_text;
                                            @endphp
                                            @if($dx && $dx !== '-')
                                                {{ $dx }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $result->status_kesehatan_color }}">
                                                {{ $result->status_kesehatan }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($result->hasFile())
                                                <span class="badge bg-success">
                                                    <i class="fas fa-file"></i> Tersedia
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-times"></i> Tidak Ada
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($result->is_downloaded)
                                                <span class="badge bg-info">
                                                    <i class="fas fa-download"></i> Sudah Download
                                                </span>
                                                <br>
                                                <small class="text-muted">
                                                    {{ $result->downloaded_at ? $result->downloaded_at->format('d/m/Y H:i') : '' }}
                                                </small>
                                            @else
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-clock"></i> Belum Download
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($result->hasFile())
                                                <a href="{{ route('client.results.download', $result->id) }}" 
                                                   class="btn btn-sm btn-primary">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                                <a href="{{ route('client.results.downloadAll', $result->id) }}"
                                                   class="btn btn-sm btn-outline-primary ms-1">
                                                    <i class="fas fa-file-zipper"></i> Download Semua
                                                </a>
                                            @else
                                                <button class="btn btn-sm btn-secondary" disabled>
                                                    <i class="fas fa-times"></i> Tidak Tersedia
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($mcuResults->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $mcuResults->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-file-medical fa-3x text-muted"></i>
                            </div>
                            <h5>Belum Ada Hasil MCU</h5>
                            <p class="text-muted">Anda belum memiliki hasil MCU yang tersedia.</p>
                            <p class="text-muted">Hasil MCU akan muncul setelah pemeriksaan selesai dan hasil diupload oleh administrator.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($mcuResults->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Statistik Hasil MCU</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Total Hasil</h6>
                                    <h3 class="mb-0">{{ $mcuResults->total() }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Sehat</h6>
                                    <h3 class="mb-0">{{ $mcuResults->where('status_kesehatan', 'Sehat')->count() }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Kurang Sehat</h6>
                                    <h3 class="mb-0">{{ $mcuResults->where('status_kesehatan', 'Kurang Sehat')->count() }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Tidak Sehat</h6>
                                    <h3 class="mb-0">{{ $mcuResults->where('status_kesehatan', 'Tidak Sehat')->count() }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Detail Hasil Terbaru</h5>
                    @php
                        $latestResult = $mcuResults->first();
                    @endphp
                    @if($latestResult)
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Hasil Pemeriksaan:</h6>
                                <div class="alert alert-info">
                                    {{ $latestResult->hasil_pemeriksaan }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6>Rekomendasi:</h6>
                                <div class="alert alert-warning">
                                    @if($latestResult->rekomendasi)
                                        {{ $latestResult->rekomendasi }}
                                    @else
                                        <em>Tidak ada rekomendasi khusus</em>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
