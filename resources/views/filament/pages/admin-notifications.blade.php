<x-filament::page>
	<div class="space-y-4">
		<div class="flex justify-between items-center">
			<h2 class="text-lg font-semibold">Notifikasi</h2>
			<form method="post" action="#" wire:submit.prevent="markAllAsRead">
				<x-filament::button type="submit" color="success">Tandai Semua Sudah Dibaca</x-filament::button>
			</form>
		</div>

		<div class="grid gap-3">
			@php $notifications = auth()->user()?->notifications()->latest()->paginate(15); @endphp
			@forelse ($notifications as $notification)
				<div class="rounded-lg border p-4 flex items-start justify-between {{ is_null($notification->read_at) ? 'bg-yellow-50 border-yellow-200' : 'bg-white' }}">
					<div>
						<div class="font-medium">{{ data_get($notification->data, 'title', 'Notifikasi') }}</div>
						<div class="text-sm text-gray-600">{{ json_encode(data_get($notification->data, 'payload', [])) }}</div>
						<div class="text-xs text-gray-500 mt-1">{{ $notification->created_at->format('d/m/Y H:i') }}</div>
					</div>
					<div class="flex items-center gap-2">
						@if (is_null($notification->read_at))
							<form method="post" action="#" wire:submit.prevent="markAsRead('{{ $notification->id }}')">
								<x-filament::button type="submit" size="sm">Tandai Dibaca</x-filament::button>
							</form>
						@endif
					</div>
				</div>
			@empty
				<div class="text-center text-gray-500">Tidak ada notifikasi.</div>
			@endforelse
			<div>
				{{ $notifications->links() }}
			</div>
		</div>
	</div>
</x-filament::page>

