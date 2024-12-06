<?php

use App\Http\Middleware\RedirectIfAdminAuthenticated;
use Illuminate\Foundation\Application;
use App\Http\Middleware\CheckOrganizer;
use App\Http\Middleware\RedirectIfOrganizerAuthenticated;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'organizer' => CheckOrganizer::class,
            'organizer.guest' => RedirectIfOrganizerAuthenticated::class,
            'admin' => CheckAdmin::class,
            'admin.guest' => RedirectIfAdminAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
