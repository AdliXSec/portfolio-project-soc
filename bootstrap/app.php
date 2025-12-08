<?php

use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\SecurityHeaders::class,
            \App\Http\Middleware\TrackVisits::class,
        ]);

        // Rate limiting aliases
        $middleware->alias([
            'throttle.login' => \Illuminate\Routing\Middleware\ThrottleRequests::class . ':5,1',
            'throttle.contact' => \Illuminate\Routing\Middleware\ThrottleRequests::class . ':3,1',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json(['error' => 'Resource not found.'], 404);
            }
            return response()->view('errors.404', [], 404);
        });
        $exceptions->renderable(function (AuthorizationException $e, Request $request) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Forbidden.'], 403);
            }
            return response()->view('errors.403', [], 403);
        });
        $exceptions->renderable(function (HttpException $e, Request $request) {
            if ($e->getStatusCode() == 500) {
                if ($request->wantsJson()) {
                    return response()->json(['error' => 'Internal Server Error.'], 500);
                }
                return response()->view('errors.500', [], 500);
            }
        });
        $exceptions->renderable(function (MethodNotAllowedHttpException $e, Request $request) {
            if (!$request->wantsJson() && !$request->is('api/*')) {
                return response()->view('errors.404', [], 404);
            }
        });
    })->create();
