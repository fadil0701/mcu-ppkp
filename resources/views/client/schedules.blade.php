@extends('client.layout')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<div class="page-title-box d-flex align-items-center justify-content-between">
				<h4 class="mb-0">Jadwal MCU Saya</h4>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					@if(session('success'))
						<div class="alert alert-success">{{ session('success') }}</div>
					@endif
					@if($errors->any())
						<div class="alert alert-danger">
							<ul class="mb-0">
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					@if($schedules->count() > 0)
						<div class="table-responsive">
							<table class="table table-striped align-middle">
								<thead>
									<tr>
										<th>No</th>
										<th>Tanggal</th>
										<th>Jam</th>
										<th>Lokasi</th>
										<th>No. Antrian</th>
										<th>Status</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
								@foreach($schedules as $index => $schedule)
									<tr>
										<td>{{ $index + 1 }}</td>
										<td>{{ $schedule->tanggal_pemeriksaan_formatted }}</td>
										<td>{{ $schedule->jam_pemeriksaan_formatted }}</td>
										<td>{{ $schedule->lokasi_pemeriksaan }}</td>
										<td>
											@if($schedule->queue_number)
												<span class="badge bg-primary">{{ $schedule->queue_number }}</span>
											@else
												<span class="text-muted">-</span>
											@endif
										</td>
										<td>
											<span class="badge bg-{{ $schedule->status_color }}">{{ $schedule->status }}</span>
											@if($schedule->participant_confirmed)
												<span class="badge bg-success ms-1">Confirmed</span>
											@endif
											@if($schedule->reschedule_requested)
												<span class="badge bg-warning text-dark ms-1">Reschedule Requested</span>
											@endif
										</td>
										<td>
									@if($schedule->status === 'Terjadwal' && !$schedule->participant_confirmed)
												<form method="POST" action="{{ route('client.schedule.confirm', $schedule->id) }}" class="d-inline">
													@csrf
													<button type="submit" class="btn btn-sm btn-success">Konfirmasi Hadir</button>
												</form>
												<button class="btn btn-sm btn-outline-warning" type="button" data-bs-toggle="collapse" data-bs-target="#resched-{{ $schedule->id }}">Reschedule</button>
												<div class="collapse mt-2" id="resched-{{ $schedule->id }}">
													<form method="POST" action="{{ route('client.schedule.reschedule', $schedule->id) }}" class="row g-2">
														@csrf
														<div class="col-md-4">
															<input type="date" name="new_date" class="form-control" min="{{ now()->toDateString() }}" required>
														</div>
														<div class="col-md-3">
															<input type="time" name="new_time" class="form-control" required>
														</div>
														<div class="col-md-5">
															<input type="text" name="reason" class="form-control" placeholder="Alasan reschedule" required>
														</div>
														<div class="col-12">
															<button type="submit" class="btn btn-sm btn-primary">Kirim Permintaan</button>
														</div>
													</form>
												</div>
										<button class="btn btn-sm btn-outline-danger mt-2" type="button" data-bs-toggle="collapse" data-bs-target="#cancel-{{ $schedule->id }}">Batalkan Jadwal</button>
										<div class="collapse mt-2" id="cancel-{{ $schedule->id }}">
											<form method="POST" action="{{ route('client.schedule.cancel', $schedule->id) }}" class="row g-2">
												@csrf
												<div class="col-12">
													<input type="text" name="cancel_reason" class="form-control" placeholder="Alasan pembatalan" required>
												</div>
												<div class="col-12">
													<button type="submit" class="btn btn-sm btn-danger">Kirim Pembatalan</button>
												</div>
											</form>
										</div>
											@endif
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>

						@if(method_exists($schedules, 'links') && $schedules->hasPages())
							{{ $schedules->links() }}
						@endif
					@else
						<div class="text-center py-5">
							<i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
							<h5>Belum Ada Jadwal MCU</h5>
							<p class="text-muted">Anda belum memiliki jadwal MCU.</p>
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
