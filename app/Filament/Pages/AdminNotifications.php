<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class AdminNotifications extends Page
{
	protected static ?string $navigationIcon = 'heroicon-o-bell';
	protected static ?string $navigationLabel = 'Notifikasi';
	protected static ?string $navigationGroup = 'System Management';
	protected static ?int $navigationSort = 99;
	protected static ?string $title = 'Notifikasi Admin';
	protected static ?string $slug = 'notifications';
	protected static string $view = 'filament.pages.admin-notifications';

	public function mount(): void
	{
		if (!auth()->user()?->isAdmin()) {
			abort(403);
		}
	}

	public function markAsRead(string $id): void
	{
		$notification = auth()->user()?->notifications()->where('id', $id)->first();
		if ($notification && is_null($notification->read_at)) {
			$notification->markAsRead();
		}
	}

	public function markAllAsRead(): void
	{
		auth()->user()?->unreadNotifications->markAsRead();
	}
}

