<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Buat Akun Login Peserta - Sistem Monitoring MCU</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<style>
		body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
		.card { border: none; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
		.card-header { border-top-left-radius: 16px !important; border-top-right-radius: 16px !important; }
		.form-control { border: 2px solid #e9ecef; border-radius: 12px; padding: 12px 16px; }
		.form-control:focus { border-color: #28a745; box-shadow: 0 0 0 0.2rem rgba(40,167,69,.25); }
		.btn-success { border-radius: 12px; padding: 12px 16px; font-weight: 600; }
		.alert { border: none; border-radius: 12px; }
	</style>
</head>
<body>
	<div class="container py-4">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="card">
					<div class="card-header bg-success text-white text-center">
						<h4 class="mb-0"><i class="fas fa-user-plus me-2"></i>Buat Akun Login Peserta</h4>
						<small class="opacity-75">Lengkapi data berikut untuk membuat akun</small>
					</div>
					<div class="card-body p-4">
						@if ($errors->any())
							<div class="alert alert-danger">
								<ul class="mb-0">
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif

						<div class="mb-3">
							<label class="form-label fw-semibold">Nama Lengkap</label>
							<input type="text" class="form-control" value="{{ $participant->nama_lengkap }}" disabled>
						</div>
						<div class="mb-3">
							<label class="form-label fw-semibold">NIK</label>
							<input type="text" class="form-control" value="{{ $participant->nik_ktp }}" disabled>
						</div>
						<div class="mb-3">
							<label class="form-label fw-semibold">NRK</label>
							<input type="text" class="form-control" value="{{ $participant->nrk_pegawai }}" disabled>
						</div>

						<form method="POST" action="{{ url('/peserta/aktivasi-akun/register') }}">
							@csrf
							<div class="mb-3">
								<label for="email" class="form-label fw-semibold">Email</label>
								<input type="email" class="form-control" id="email" name="email" required autofocus placeholder="Email aktif">
							</div>
							<div class="mb-3">
								<label for="password" class="form-label fw-semibold">Password</label>
								<input type="password" class="form-control" id="password" name="password" required placeholder="Minimal 8 karakter">
							</div>
							<div class="mb-3">
								<label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password</label>
								<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Ulangi password">
							</div>
							<div class="d-grid">
								<button type="submit" class="btn btn-success"><i class="fas fa-user-check me-2"></i>Buat Akun Login</button>
							</div>
						</form>
					</div>
				</div>
				<div class="text-center mt-3">
					<a href="{{ route('peserta.aktivasi') }}" class="text-white text-decoration-none"><i class="fas fa-arrow-left me-2"></i>Kembali ke Verifikasi</a>
				</div>
			</div>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

