<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create super admin user
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@mcu.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'),
                'role' => 'super_admin',
                'is_active' => true,
            ]
        );
        
        // Assign super_admin role
        $superAdmin->assignRole('super_admin');
        
        $this->command->info('Super Admin user created: superadmin@mcu.com (password: password123)');
    }
}
