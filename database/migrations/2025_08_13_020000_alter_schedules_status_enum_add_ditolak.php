<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		// Update ENUM to include 'Ditolak'
		DB::statement("ALTER TABLE `schedules` MODIFY `status` ENUM('Terjadwal','Selesai','Batal','Ditolak') NOT NULL DEFAULT 'Terjadwal'");
	}

	public function down(): void
	{
		// Revert ENUM to previous set (without 'Ditolak')
		DB::statement("ALTER TABLE `schedules` MODIFY `status` ENUM('Terjadwal','Selesai','Batal') NOT NULL DEFAULT 'Terjadwal'");
	}
};

