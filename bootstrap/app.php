<?php

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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
            \App\Http\Middlewares\SetLocale::class,
            \App\Http\Middlewares\CorsMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (AuthenticationException $e) {
            return json_response(success: false, message: __('messages.unauthenticated'), code: 401);
        });
        $exceptions->render(function (AuthorizationException $e) {
            return json_response(success: false, message: __('messages.not_allowed'), code: 403);
        });
        $exceptions->render(function (AccessDeniedHttpException $e) {
            return json_response(success: false, message: __('messages.not_allowed'), code: 403);
        });
        $exceptions->render(function (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' =>$e->getMessage(),
                'errors' => $e->errors(),
            ], 422);
        });
        $exceptions->render(function (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return json_response(success: false, message: __('messages.item_not_found'), code: 404);
        });
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
            return json_response(success: false, message: __('messages.not_found').' '.$e->getMessage(), code: 404);
        });
        $exceptions->render(function (\Exception $e) {
            return json_response(success: false, message: $e->getMessage(), code: 500);
        });
    })->create();
