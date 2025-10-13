<?php

namespace App\Filament\Resources\ScheduleResource\Pages;

use App\Filament\Resources\ScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Schedule;
use App\Models\Participant;

class CreateSchedule extends CreateRecord
{
	protected static string $resource = ScheduleResource::class;

	public function mount(): void
	{
		parent::mount();
		
		// Check if participant_id is provided in the URL
		$participantId = request()->get('participant_id');
		
		if ($participantId) {
			$participant = Participant::find($participantId);
			
			if ($participant) {
				// Pre-fill the form with participant data
				$this->form->fill([
					'participant_id' => $participant->id,
					'nik_ktp' => $participant->nik_ktp,
					'nrk_pegawai' => $participant->nrk_pegawai,
					'nama_lengkap' => $participant->nama_lengkap,
					'tanggal_lahir' => $participant->tanggal_lahir,
					'jenis_kelamin' => $participant->jenis_kelamin,
					'skpd' => $participant->skpd,
					'ukpd' => $participant->ukpd,
					'no_telp' => $participant->no_telp,
					'email' => $participant->email,
				]);
			}
		}
	}

	protected function mutateFormDataBeforeCreate(array $data): array
	{
		if (!empty($data['tanggal_pemeriksaan'])) {
			$max = Schedule::whereDate('tanggal_pemeriksaan', $data['tanggal_pemeriksaan'])->max('queue_number');
			$data['queue_number'] = (int) $max + 1;
		}
		return $data;
	}
}
