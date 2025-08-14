@extends('client.layout')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<div class="page-title-box d-flex align-items-center justify-content-between">
				<h4 class="mb-0">Pendaftaran Ulang MCU</h4>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-8">
			<div class="card">
				<div class="card-body">
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

					@if(!$eligible)
						<div class="alert alert-warning mb-4">
							<i class="fas fa-exclamation-triangle me-2"></i>{{ $reason }}
						</div>
					@endif

					<form method="POST" action="{{ route('client.schedule.request.store') }}">
						@csrf
						<div class="mb-3">
							<label class="form-label">Tanggal Pemeriksaan</label>
							<input type="date" name="tanggal_pemeriksaan" class="form-control" value="{{ old('tanggal_pemeriksaan') }}" {{ $eligible ? '' : 'disabled' }} required>
						</div>
						<div class="mb-3">
							<label class="form-label">Jam Pemeriksaan</label>
							<input type="time" name="jam_pemeriksaan" class="form-control" value="{{ old('jam_pemeriksaan') }}" {{ $eligible ? '' : 'disabled' }} required>
						</div>
						<div class="mb-3">
							<label class="form-label">Lokasi Pemeriksaan</label>
							<input type="text" name="lokasi_pemeriksaan" class="form-control" value="{{ old('lokasi_pemeriksaan') }}" {{ $eligible ? '' : 'disabled' }} required>
						</div>
						<div class="mb-3">
							<label class="form-label">Catatan (opsional)</label>
							<textarea name="catatan" class="form-control" rows="3" {{ $eligible ? '' : 'disabled' }}>{{ old('catatan') }}</textarea>
						</div>
						<div class="d-grid">
							<button type="submit" class="btn btn-primary" {{ $eligible ? '' : 'disabled' }}>
								<i class="fas fa-paper-plane me-2"></i>Ajukan Jadwal
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Status Kelayakan</h5>
					<ul class="list-unstyled mb-0">
						<li class="mb-2"><i class="fas fa-user me-2 text-primary"></i>{{ $participant->nama_lengkap }}</li>
						<li class="mb-2"><i class="fas fa-id-card me-2 text-primary"></i>{{ $participant->nik_ktp }}</li>
						<li class="mb-2"><i class="fas fa-building me-2 text-primary"></i>{{ $participant->skpd }}</li>
						<li class="mb-2"><i class="fas fa-calendar me-2 text-primary"></i>
							Terakhir MCU: {{ $participant->tanggal_mcu_terakhir_formatted }}
						</li>
						<li class="mb-2"><i class="fas fa-check-circle me-2 text-{{ $eligible ? 'success' : 'warning' }}"></i>
							Kelayakan: {{ $eligible ? 'Memenuhi syarat' : 'Belum memenuhi' }}
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

