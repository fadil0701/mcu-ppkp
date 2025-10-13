<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Filament\Facades\Filament;

class AdminAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip middleware for login routes
        $currentRoute = $request->route()?->getName();
        if (str_contains($currentRoute ?? '', 'filament.admin.auth')) {
            return $next($request);
        }
        
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('filament.admin.auth.login');
        }
        
        // Cek apakah user adalah admin atau super admin
        $user = auth()->user();
        if (!$user || (!$user->hasRole('admin') && !$user->hasRole('super_admin'))) {
            abort(403, 'Access denied. Admin access required.');
        }
        
        // Jika user adalah admin biasa (bukan super admin), batasi resources
        if ($user->hasRole('admin') && !$user->hasRole('super_admin')) {
            $panel = Filament::getDefaultPanel();
            
            // Batasi resources untuk admin biasa - hanya 4 menu utama
            $panel->resources([
                \App\Filament\Resources\ParticipantResource::class,
                \App\Filament\Resources\ScheduleResource::class,
                \App\Filament\Resources\McuResultResource::class,
            ]);
            
            // Batasi pages untuk admin biasa
            $panel->pages([
                \App\Filament\Pages\Dashboard::class,
                \App\Filament\Pages\Reports::class,
            ]);
            
            // Batasi widgets untuk admin biasa
            $panel->widgets([
                \Filament\Widgets\AccountWidget::class,
            ]);
        }
        
        return $next($request);
    }
}
