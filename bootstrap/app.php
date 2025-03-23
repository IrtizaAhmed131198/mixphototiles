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
    ->withMiddleware(function (Middleware $middleware) {
        // Example of adding global middleware (you can add more as needed)
        // $middleware->web([\App\Http\Middleware\CustomAuthMiddleware::class]);
        // $middleware->api([\App\Http\Middleware\Authenticate::class]);
        $middleware->web([
            App\Http\Middleware\CustomAuthMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // You could customize exception handling here if needed
    })
    ->create();
