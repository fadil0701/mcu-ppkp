<div>
	<div class="grid grid-cols-2 gap-3">
		<div class="p-4 bg-white shadow rounded">
			<div class="text-xs text-gray-500">Konfirmasi Hadir (Hari Ini)</div>
			<div class="text-2xl font-bold text-green-600">{{ $confirmedToday }}</div>
		</div>
		<div class="p-4 bg-white shadow rounded">
			<div class="text-xs text-gray-500">Permintaan Reschedule (Hari Ini)</div>
			<div class="text-2xl font-bold text-yellow-600">{{ $pendingRescheduleToday }}</div>
		</div>
	</div>
</div>
