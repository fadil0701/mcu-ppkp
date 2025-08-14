@extends('client.layout')

@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="page-title">Selamat Datang, {{ Auth::user()->name }}!</h1>
                <p class="text-muted">Dashboard monitoring MCU PPKP DKI Jakarta</p>
            </div>
            <div class="text-end">
                <small class="text-muted">Terakhir diperbarui: {{ now()->format('d/m/Y H:i') }}</small>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stats-number">{{ $participant ? '1' : '0' }}</div>
            <div class="stats-label">Status Pendaftaran</div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stats-number">{{ $schedules->count() }}</div>
            <div class="stats-label">Jadwal MCU</div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-file-medical"></i>
            </div>
            <div class="stats-number">{{ $mcuResults->count() }}</div>
            <div class="stats-label">Hasil MCU</div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stats-number">
                @if($participant && $participant->tanggal_mcu_terakhir)
                    {{ \Carbon\Carbon::parse($participant->tanggal_mcu_terakhir)->diffForHumans() }}
                @else
                    Belum MCU
                @endif
            </div>
            <div class="stats-label">MCU Terakhir</div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-people-group"></i>
            </div>
            <div class="stats-number">{{ isset($todayQueueTotal) ? $todayQueueTotal : 0 }}</div>
            <div class="stats-label">Total Antrian Aktif Hari Ini</div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-ban"></i>
            </div>
            <div class="stats-number">{{ $schedules->where('status', 'Ditolak')->count() }}</div>
            <div class="stats-label">Jadwal Ditolak</div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-user-clock"></i>
            </div>
            @php
                $myTodayQueues = $schedules->filter(fn($s) => $s->tanggal_pemeriksaan && $s->tanggal_pemeriksaan->isToday() && $s->status === 'Terjadwal' && !is_null($s->queue_number))->sortBy('queue_number');
                $myQueueNumber = optional($myTodayQueues->first())->queue_number;
            @endphp
            <div class="stats-number">{{ $myQueueNumber ?? '-' }}</div>
            <div class="stats-label">Nomor Antrian Saya Hari Ini</div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Profile Status -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user-circle me-2"></i>Status Profile
                </h5>
            </div>
            <div class="card-body">
                @if($participant)
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <div class="user-avatar" style="width: 60px; height: 60px; font-size: 1.5rem;">
                                {{ strtoupper(substr($participant->nama_lengkap, 0, 1)) }}
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">{{ $participant->nama_lengkap }}</h6>
                            <p class="text-muted mb-1">{{ $participant->skpd }}</p>
                            <span class="badge bg-{{ $participant->status_mcu_color }}">
                                {{ $participant->status_mcu }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted">NIK KTP</small>
                            <p class="mb-2"><strong>{{ $participant->nik_ktp }}</strong></p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Status Pegawai</small>
                            <p class="mb-2"><strong>{{ $participant->status_pegawai }}</strong></p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Umur</small>
                            <p class="mb-2"><strong>{{ $participant->umur }} tahun</strong></p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Jenis Kelamin</small>
                            <p class="mb-2"><strong>{{ $participant->jenis_kelamin_text }}</strong></p>
                        </div>
                    </div>
                    
                    <a href="{{ route('client.profile') }}" class="btn btn-primary w-100">
                        <i class="fas fa-edit me-2"></i>Lihat Profile Lengkap
                    </a>
                @else
                    <div class="text-center py-4">
                        <div class="mb-3">
                            <i class="fas fa-user-slash fa-3x text-muted"></i>
                        </div>
                        <h6>Data Profile Belum Lengkap</h6>
                        <p class="text-muted mb-3">Silakan lengkapi data profile Anda untuk dapat mengakses fitur MCU.</p>
                        <a href="{{ route('client.profile') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus me-2"></i>Lengkapi Profile
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-bolt me-2"></i>Aksi Cepat
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6">
                        <a href="{{ route('client.schedules') }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center">
                            <i class="fas fa-calendar fa-2x mb-2"></i>
                            <span>Jadwal MCU</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('client.results') }}" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center">
                            <i class="fas fa-file-medical fa-2x mb-2"></i>
                            <span>Hasil MCU</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('client.schedule.request') }}" class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center">
                            <i class="fas fa-repeat fa-2x mb-2"></i>
                            <span>Daftar Ulang MCU</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('client.profile') }}" class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center">
                            <i class="fas fa-user fa-2x mb-2"></i>
                            <span>Profile</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                           class="btn btn-outline-danger w-100 h-100 d-flex flex-column align-items-center justify-content-center">
                            <i class="fas fa-sign-out-alt fa-2x mb-2"></i>
                            <span>Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="row">
    <!-- Upcoming Schedules -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>Jadwal MCU Terdekat
                </h5>
            </div>
            <div class="card-body">
                @if($schedules->count() > 0)
                    @foreach($schedules->take(3) as $schedule)
                        <div class="d-flex align-items-center mb-3 p-3 border rounded">
                            <div class="flex-shrink-0">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px;">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">{{ $schedule->tanggal_pemeriksaan_formatted }}</h6>
                                <p class="text-muted mb-1">{{ $schedule->jam_pemeriksaan_formatted }} - {{ $schedule->lokasi_pemeriksaan }}</p>
                                <span class="badge bg-{{ $schedule->status_color }}">
                                    {{ $schedule->status }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                    <a href="{{ route('client.schedules') }}" class="btn btn-outline-primary w-100">
                        <i class="fas fa-eye me-2"></i>Lihat Semua Jadwal
                    </a>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <h6>Belum Ada Jadwal MCU</h6>
                        <p class="text-muted">Jadwal MCU akan muncul setelah Anda didaftarkan oleh administrator.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Results -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-line me-2"></i>Hasil MCU Terbaru
                </h5>
            </div>
            <div class="card-body">
                @if($mcuResults->count() > 0)
                    @foreach($mcuResults->take(3) as $result)
                        <div class="d-flex align-items-center mb-3 p-3 border rounded">
                            <div class="flex-shrink-0">
                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px;">
                                    <i class="fas fa-file-medical"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">{{ $result->tanggal_pemeriksaan_formatted }}</h6>
                                <p class="text-muted mb-1">
                                    @php
                                        $dx = $result->diagnosis_text;
                                    @endphp
                                    @if($dx && $dx !== '-')
                                        {{ Str::limit($dx, 30) }}
                                    @else
                                        Tidak ada diagnosis
                                    @endif
                                </p>
                                <span class="badge bg-{{ $result->status_kesehatan_color }}">
                                    {{ $result->status_kesehatan }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                    <a href="{{ route('client.results') }}" class="btn btn-outline-success w-100">
                        <i class="fas fa-eye me-2"></i>Lihat Semua Hasil
                    </a>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-file-medical fa-3x text-muted mb-3"></i>
                        <h6>Belum Ada Hasil MCU</h6>
                        <p class="text-muted">Hasil MCU akan muncul setelah pemeriksaan selesai dan diupload oleh administrator.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- System Information -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Informasi Sistem
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center">
                            <i class="fas fa-shield-alt fa-2x text-primary mb-2"></i>
                            <h6>Sistem Aman</h6>
                            <p class="text-muted small">Data Anda dilindungi dengan sistem keamanan tingkat tinggi</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                            <h6>24/7 Tersedia</h6>
                            <p class="text-muted small">Sistem dapat diakses kapan saja dan di mana saja</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <i class="fas fa-headset fa-2x text-success mb-2"></i>
                            <h6>Dukungan Penuh</h6>
                            <p class="text-muted small">Tim support siap membantu Anda kapan saja</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
