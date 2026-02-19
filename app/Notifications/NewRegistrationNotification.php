<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewRegistrationNotification extends Notification
{
	public function __construct(
		public string $type, // 'baru' or 'ulang'
		public array $payload = []
	) {}

	public function via(object $notifiable): array
	{
		return ['database'];
	}

	public function toArray(object $notifiable): array
	{
		$title = $this->type === 'baru' ? 'Pendaftaran Peserta Baru' : 'Pendaftaran Ulang Peserta';
		$name = $this->payload['nama_lengkap'] ?? $this->payload['name'] ?? 'Peserta';
		$message = $this->type === 'baru'
			? "{$name} mendaftar sebagai peserta baru."
			: "{$name} melakukan pendaftaran ulang.";
		return [
			'title' => $title,
			'message' => $message,
			'payload' => $this->payload,
		];
	}
}
