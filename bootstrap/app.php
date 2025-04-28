<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        using: function (){
            Route::prefix('api')->group(base_path('routes/api.php'))->middleware(['api', 'throttle:60,1']);
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->use([
            \Rakutentech\LaravelRequestDocs\LaravelRequestDocsMiddleware::class,
            \App\Http\Middlewares\SetLocale::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
