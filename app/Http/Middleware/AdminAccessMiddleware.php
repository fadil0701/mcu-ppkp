<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAccessMiddleware
{
    /**
     * Route prefix yang boleh diakses admin biasa (bukan super_admin).
     */
    protected function allowedRoutePrefixesForAdmin(): array
    {
        return [
            'dashboard',
            'admin.reports',
            'admin.participants',
            'admin.schedules',
            'admin.mcu-results',
        ];
    }

    public function handle(Request $request, Closure $next): Response
    {
        $currentRoute = $request->route()?->getName() ?? '';

        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        if (!$user || (!$user->hasRole('admin') && !$user->hasRole('super_admin'))) {
            abort(403, 'Access denied. Admin access required.');
        }

        // Admin biasa (bukan super_admin): hanya boleh akses route yang ada di allow list
        // Cek route saja, jangan ubah panel agar link menu tidak redirect ke dashboard
        if ($user->hasRole('admin') && !$user->hasRole('super_admin')) {
            $allowed = false;
            foreach ($this->allowedRoutePrefixesForAdmin() as $prefix) {
                if (str_starts_with($currentRoute, $prefix)) {
                    $allowed = true;
                    break;
                }
            }
            if (!$allowed) {
                abort(403, 'Akses hanya untuk Super Admin.');
            }
        }

        return $next($request);
    }
}
