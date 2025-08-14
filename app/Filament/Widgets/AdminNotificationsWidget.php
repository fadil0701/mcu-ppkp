<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class AdminNotificationsWidget extends Widget
{
	protected static string $view = 'filament.widgets.admin-notifications';

	protected int|string|array $columnSpan = 'full';

	public static function canView(): bool
	{
		$user = Auth::user();
		return $user && in_array($user->role, ['admin', 'super_admin'], true);
	}
}

