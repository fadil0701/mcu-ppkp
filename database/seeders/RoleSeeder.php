<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert roles
        DB::table('roles')->insertOrIgnore([
            ['name' => 'super_admin', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'admin', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'user', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
        ]);
        
        // Assign super_admin role to first user (assuming there's at least one user)
        $firstUser = \App\Models\User::first();
        if ($firstUser) {
            $firstUser->assignRole('super_admin');
            $this->command->info('Super Admin role assigned to user: ' . $firstUser->email);
        }
    }
}
