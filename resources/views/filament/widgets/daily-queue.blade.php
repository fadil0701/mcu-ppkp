<div>
	<div class="grid grid-cols-2 md:grid-cols-5 gap-3">
		<div class="p-4 bg-white shadow rounded">
			<div class="text-xs text-gray-500">Total Hari Ini</div>
			<div class="text-2xl font-bold">{{ $total }}</div>
		</div>
		<div class="p-4 bg-white shadow rounded">
			<div class="text-xs text-gray-500">Terjadwal</div>
			<div class="text-2xl font-bold text-yellow-600">{{ $terjadwal }}</div>
		</div>
		<div class="p-4 bg-white shadow rounded">
			<div class="text-xs text-gray-500">Selesai</div>
			<div class="text-2xl font-bold text-green-600">{{ $selesai }}</div>
		</div>
		<div class="p-4 bg-white shadow rounded">
			<div class="text-xs text-gray-500">Ditolak</div>
			<div class="text-2xl font-bold text-gray-600">{{ $ditolak }}</div>
		</div>
		<div class="p-4 bg-white shadow rounded">
			<div class="text-xs text-gray-500">Batal</div>
			<div class="text-2xl font-bold text-red-600">{{ $batal }}</div>
		</div>
	</div>
</div>
