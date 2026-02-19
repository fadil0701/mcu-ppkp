<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Trust proxies for production
        $middleware->trustProxies(at: '*');
        
        // Register custom middleware
        $middleware->alias([
            'admin.access' => \App\Http\Middleware\AdminAccessMiddleware::class,
            'admin' => \App\Http\Middleware\EnsureAdmin::class,
            'force.session.config' => \App\Http\Middleware\ForceSessionConfig::class,
        ]);
        
        // Apply force session config globally
        $middleware->append(\App\Http\Middleware\ForceSessionConfig::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
