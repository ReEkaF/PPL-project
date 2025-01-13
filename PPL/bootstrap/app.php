<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Registering your middleware aliases
        $middleware->alias([
            'admin' => \App\Http\Middleware\SuperadminMiddleware::class,
            'staff_akademik' => \App\Http\Middleware\StaffakademikMiddleware::class,
            'staff_perpus' => \App\Http\Middleware\StaffperpusMiddleware::class,
            'pembina_ekstra' => \App\Http\Middleware\PembinaMiddleware::class,
            'guru' => \App\Http\Middleware\GuruMiddleware::class,
            'siswa' => \App\Http\Middleware\SiswaMiddleware::class,
            'pengurus' => \App\Http\Middleware\PengurusMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // You can handle exceptions here
    })
    ->create();
$app->register(\Barryvdh\DomPDF\ServiceProvider::class);
