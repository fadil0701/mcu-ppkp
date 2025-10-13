<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;

class AdminNavigationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Filament::serving(function () {
            $user = auth()->user();
            
            // Jika user sudah login, cek akses
            if ($user) {
                // Jika user bukan admin atau super admin, block akses
                if (!$user->hasRole('admin') && !$user->hasRole('super_admin')) {
                    abort(403, 'Access denied. Admin access required.');
                }
                
                // Jika user adalah admin biasa (bukan super admin), batasi navigation
                if ($user->hasRole('admin') && !$user->hasRole('super_admin')) {
                    // Custom navigation groups untuk admin terbatas
                    Filament::registerNavigationGroups([
                        NavigationGroup::make()
                            ->label('Dashboard')
                            ->collapsed(false),
                            
                        NavigationGroup::make()
                            ->label('Data Management')
                            ->collapsed(false),
                            
                        NavigationGroup::make()
                            ->label('Reports & Analytics')
                            ->collapsed(false),
                    ]);
                }
            }
        });
    }
}
