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
        $middleware->alias([
            'IsGuest' => \App\Http\Middleware\IsGuest::class,
            'IsLogin' => \App\Http\Middleware\IsLogin::class,
            'IsAdmin' => \App\Http\Middleware\IsAdmin::class,
            'IsEmployee' => \App\Http\Middleware\IsEmployee::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
