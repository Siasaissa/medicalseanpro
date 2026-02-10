<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Add Sanctum middleware for API stateful authentication
        $middleware->statefulApi();
        
        // OR if you want more control:
        // $middleware->api(prepend: [
        //     \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        // ]);
        
        // Alias middleware for use in routes
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            // Add other middleware aliases here
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();