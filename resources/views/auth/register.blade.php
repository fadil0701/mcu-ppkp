<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran MCU - PPKP DKI Jakarta</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .register-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .register-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }
        
        .register-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .register-header p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 0;
        }
        
        .form-section {
            padding: 40px;
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 15px 20px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }
        
        .btn-register {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            border-radius: 12px;
            padding: 15px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(40, 167, 69, 0.3);
        }
        
        .btn-back {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            border: none;
            border-radius: 12px;
            padding: 15px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(108, 117, 125, 0.3);
        }
        
        .info-card {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
        }
        
        .requirement-list {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .requirement-list h5 {
            color: #28a745;
            margin-bottom: 15px;
        }
        
        .requirement-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            padding: 8px 0;
        }
        
        .requirement-icon {
            width: 24px;
            height: 24px;
            background: #28a745;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.8rem;
            margin-right: 12px;
        }
        
        .alert {
            border-radius: 12px;
            border: none;
        }
        
        .logo-section {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .logo-placeholder {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }
        
        .step {
            display: flex;
            align-items: center;
            margin: 0 15px;
        }
        
        .step-number {
            width: 40px;
            height: 40px;
            background: #28a745;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 10px;
        }
        
        .step-text {
            font-weight: 600;
            color: #28a745;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-container">
            <!-- Header -->
            <div class="register-header">
                <div class="logo-section">
                    <div class="logo-placeholder">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="logo-placeholder">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                </div>
                <h1>Pendaftaran Medical Check Up</h1>
                <p>PPKP DKI Jakarta</p>
            </div>

            <!-- Step Indicator -->
            <div class="step-indicator">
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-text">Data Akun</div>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-text">Data Pribadi</div>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-text">Verifikasi</div>
                </div>
            </div>

            <!-- Form Section -->
            <div class="form-section">
                <div class="row">
                    <!-- Left Column - Form -->
                    <div class="col-lg-8">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

                            <!-- Account Information -->
                            <div class="card mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-user-circle me-2"></i>Informasi Akun
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label fw-semibold">
                                                <i class="fas fa-user me-2"></i>Nama Lengkap
                                            </label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name') }}" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label fw-semibold">
                                                <i class="fas fa-envelope me-2"></i>Email
                                            </label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" name="email" value="{{ old('email') }}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="password" class="form-label fw-semibold">
                                                <i class="fas fa-lock me-2"></i>Password
                                            </label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                   id="password" name="password" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="password_confirmation" class="form-label fw-semibold">
                                                <i class="fas fa-lock me-2"></i>Konfirmasi Password
                                            </label>
                                            <input type="password" class="form-control" 
                                                   id="password_confirmation" name="password_confirmation" required>
                                        </div>
                                    </div>
                                </div>
        </div>

                            <!-- Personal Information -->
                            <div class="card mb-4">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-id-card me-2"></i>Informasi Pribadi
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="nik_ktp" class="form-label fw-semibold">
                                                <i class="fas fa-id-card me-2"></i>NIK KTP
                                            </label>
                                            <input type="text" class="form-control" 
                                                   id="nik_ktp" name="nik_ktp" value="{{ old('nik_ktp') }}" 
                                                   maxlength="16" placeholder="16 digit NIK KTP">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="nrk_pegawai" class="form-label fw-semibold">
                                                <i class="fas fa-badge me-2"></i>NRK Pegawai
                                            </label>
                                            <input type="text" class="form-control" 
                                                   id="nrk_pegawai" name="nrk_pegawai" value="{{ old('nrk_pegawai') }}" 
                                                   placeholder="Nomor Registrasi Kepegawaian">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="tempat_lahir" class="form-label fw-semibold">
                                                <i class="fas fa-map-marker-alt me-2"></i>Tempat Lahir
                                            </label>
                                            <input type="text" class="form-control" 
                                                   id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="tanggal_lahir" class="form-label fw-semibold">
                                                <i class="fas fa-calendar me-2"></i>Tanggal Lahir
                                            </label>
                                            <input type="date" class="form-control" 
                                                   id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="jenis_kelamin" class="form-label fw-semibold">
                                                <i class="fas fa-venus-mars me-2"></i>Jenis Kelamin
                                            </label>
                                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="status_pegawai" class="form-label fw-semibold">
                                                <i class="fas fa-user-tie me-2"></i>Status Pegawai
                                            </label>
                                            <select class="form-control" id="status_pegawai" name="status_pegawai" required>
                                                <option value="">Pilih Status Pegawai</option>
                                                <option value="CPNS" {{ old('status_pegawai') == 'CPNS' ? 'selected' : '' }}>CPNS</option>
                                                <option value="PNS" {{ old('status_pegawai') == 'PNS' ? 'selected' : '' }}>PNS</option>
                                                <option value="PPPK" {{ old('status_pegawai') == 'PPPK' ? 'selected' : '' }}>PPPK</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="skpd" class="form-label fw-semibold">
                                                <i class="fas fa-building me-2"></i>SKPD
                                            </label>
                                            <input type="text" class="form-control" 
                                                   id="skpd" name="skpd" value="{{ old('skpd') }}" 
                                                   placeholder="Satuan Kerja Perangkat Daerah">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="ukpd" class="form-label fw-semibold">
                                                <i class="fas fa-sitemap me-2"></i>UKPD
                                            </label>
                                            <input type="text" class="form-control" 
                                                   id="ukpd" name="ukpd" value="{{ old('ukpd') }}" 
                                                   placeholder="Unit Kerja Perangkat Daerah">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="no_telp" class="form-label fw-semibold">
                                                <i class="fas fa-phone me-2"></i>No. Telepon
                                            </label>
                                            <input type="tel" class="form-control" 
                                                   id="no_telp" name="no_telp" value="{{ old('no_telp') }}" 
                                                   placeholder="08xxxxxxxxxx">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="email_personal" class="form-label fw-semibold">
                                                <i class="fas fa-envelope me-2"></i>Email Pribadi
                                            </label>
                                            <input type="email" class="form-control" 
                                                   id="email_personal" name="email_personal" value="{{ old('email_personal') }}" 
                                                   placeholder="email@example.com">
                                        </div>
                                    </div>
                                </div>
        </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('login') }}" class="btn btn-back me-md-2">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Login
                                </a>
                                <button type="submit" class="btn btn-register">
                                    <i class="fas fa-user-plus me-2"></i>Daftar MCU
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Right Column - Info -->
                    <div class="col-lg-4">
                        <div class="info-card">
                            <h5 class="fw-bold text-primary mb-3">
                                <i class="fas fa-info-circle me-2"></i>Informasi Penting
                            </h5>
                            <p class="mb-3">Pendaftaran MCU hanya untuk pegawai PPKP DKI Jakarta dengan status CPNS, PNS, atau PPPK.</p>
                            <p class="mb-0">Setelah pendaftaran berhasil, Anda akan menerima notifikasi jadwal MCU melalui email dan WhatsApp.</p>
        </div>

                        <div class="requirement-list">
                            <h5>
                                <i class="fas fa-check-circle me-2"></i>Syarat Pendaftaran
                            </h5>
                            <div class="requirement-item">
                                <div class="requirement-icon">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span>Status pegawai CPNS/PNS/PPPK</span>
                            </div>
                            <div class="requirement-item">
                                <div class="requirement-icon">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span>NIK KTP valid 16 digit</span>
                            </div>
                            <div class="requirement-item">
                                <div class="requirement-icon">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span>Belum MCU dalam 3 tahun terakhir</span>
                            </div>
                            <div class="requirement-item">
                                <div class="requirement-icon">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span>Data lengkap dan valid</span>
                            </div>
        </div>

                        <div class="card">
                            <div class="card-header bg-warning text-dark">
                                <h6 class="mb-0">
                                    <i class="fas fa-exclamation-triangle me-2"></i>Perhatian
                                </h6>
                            </div>
                            <div class="card-body">
                                <ul class="mb-0">
                                    <li>Pastikan data yang diisi akurat dan benar</li>
                                    <li>MCU hanya dapat dilakukan setiap 3 tahun sekali</li>
                                    <li>Jadwal MCU akan ditentukan oleh sistem</li>
                                    <li>Notifikasi akan dikirim via email dan WhatsApp</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
