<?php

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
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
        $exceptions->render(function (AuthenticationException $e, $request) {
            if ($request->expectsJson()) {
                return json_response(success: false, message: __('messages.unauthenticated'), code: 401);
            }
//            return redirect()->guest(route('login'));
        });

        $exceptions->render(function (AuthorizationException|AccessDeniedHttpException $e, $request) {
            if ($request->expectsJson()) {
                return json_response(success: false, message: __('messages.unauthorized'), code: 403);
            }
            return redirect()->back()->with('error', __('messages.unauthorized'));
        });

        $exceptions->render(function (ValidationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'errors' => $e->errors(),
                ], 422);
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        });

        $exceptions->render(function (\Illuminate\Database\Eloquent\ModelNotFoundException $e, $request) {
            if ($request->expectsJson()) {
                return json_response(success: false, message: __('messages.item_not_found'), code: 404);
            }
//            return response()->view('errors.404', [], 404);
        });

        $exceptions->render(function (\Symfony\Component\Translation\Exception\InvalidArgumentException $e, $request) {
            // Handle translation exceptions gracefully
            // Reset the locale to English (default) and clear any problematic cookies/session data
            App::setLocale('en');
            Session::forget('locale');
            setcookie('filament_language_switch_locale', '', time() - 3600, '/');

            if ($request->expectsJson()) {
                return json_response(success: false, message: 'A translation error occurred. Your language has been reset to English.', code: 500);
            }

            return redirect()->back()->with('error', 'A translation error occurred. Your language has been reset to English.');
        });

        $exceptions->render(function (\Exception $e, $request) {
            if ($request->expectsJson()) {
                return json_response(success: false, message: $e->getMessage(), code: 500);
            }
//            return response()->view('errors.500', ['message' => $e->getMessage()], 500);
        });
    })->create();
