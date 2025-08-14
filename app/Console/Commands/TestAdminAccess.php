<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Filament\Panel;

class TestAdminAccess extends Command
{
    protected $signature = 'test:admin-access';
    protected $description = 'Test admin access and debug 403 error';

    public function handle()
    {
        $this->info('Testing Admin Access...');
        
        // Check if admin users exist
        $adminUsers = User::where('role', 'admin')->get();
        $superAdminUsers = User::where('role', 'super_admin')->get();
        
        $this->info("Admin users found: " . $adminUsers->count());
        $this->info("Super Admin users found: " . $superAdminUsers->count());
        
        foreach ($adminUsers as $user) {
            $this->info("Admin: {$user->email} - Role: {$user->role} - Active: " . ($user->is_active ? 'Yes' : 'No'));
        }
        
        foreach ($superAdminUsers as $user) {
            $this->info("Super Admin: {$user->email} - Role: {$user->role} - Active: " . ($user->is_active ? 'Yes' : 'No'));
        }
        
        // Test canAccessPanel method
        $testUser = User::where('role', 'admin')->first();
        if ($testUser) {
            $this->info("Testing canAccessPanel for: {$testUser->email}");
            $this->info("User is active: " . ($testUser->is_active ? 'Yes' : 'No'));
            $this->info("User role: {$testUser->role}");
            $this->info("Role check: " . (in_array($testUser->role, ['super_admin', 'admin']) ? 'Valid' : 'Invalid'));
        }
        
        $this->info('Test completed!');
        $this->info('Try logging in with: admin@mcu.local / password');
    }
}
