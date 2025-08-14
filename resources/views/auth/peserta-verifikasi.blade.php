<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Aktivasi Akun Peserta - Sistem Monitoring MCU</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<style>
		body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
		.card { border: none; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
		.card-header { border-top-left-radius: 16px !important; border-top-right-radius: 16px !important; }
		.form-control { border: 2px solid #e9ecef; border-radius: 12px; padding: 12px 16px; }
		.form-control:focus { border-color: #667eea; box-shadow: 0 0 0 0.2rem rgba(102,126,234,.25); }
		.btn-primary { border-radius: 12px; padding: 12px 16px; font-weight: 600; }
		.alert { border: none; border-radius: 12px; }
	</style>
</head>
<body>
	<div class="container py-4">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="card">
					<div class="card-header bg-primary text-white text-center">
						<h4 class="mb-0"><i class="fas fa-user-check me-2"></i>Aktivasi Akun Peserta</h4>
						<small class="opacity-75">Masukkan NIK, NRK, atau Nomor Telepon Anda</small>
					</div>
					<div class="card-body p-4">
						@if (session('success'))
							<div class="alert alert-success">{{ session('success') }}</div>
						@endif
						@if ($errors->any())
							<div class="alert alert-danger">
								<ul class="mb-0">
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif
						<form method="POST" action="{{ url('/peserta/aktivasi-akun') }}">
							@csrf
							<div class="mb-3">
								<label for="identifier" class="form-label fw-semibold">NIK / NRK / No Telp</label>
								<input type="text" class="form-control" id="identifier" name="identifier" required autofocus placeholder="Masukkan NIK, NRK, atau No Telp">
							</div>
							<div class="d-grid">
								<button type="submit" class="btn btn-primary"><i class="fas fa-search me-2"></i>Verifikasi Peserta</button>
							</div>
						</form>
					</div>
				</div>
				<div class="text-center mt-3">
					<a href="{{ route('login') }}" class="text-white text-decoration-none"><i class="fas fa-arrow-left me-2"></i>Kembali ke Login</a>
				</div>
			</div>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

