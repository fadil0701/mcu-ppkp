<div class="flex justify-end">
	@php
		$unread = auth()->user()?->unreadNotifications()->count() ?? 0;
	@endphp
	<a href="{{ url('/admin') }}" class="relative inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-gray-700">
		<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
			<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C8.67 6.165 8 7.388 8 8.75V14l-1.595 1.595A1 1 0 007 17h8z" />
		</svg>
		@if($unread > 0)
			<span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full">{{ $unread }}</span>
		@endif
	</a>
</div>

