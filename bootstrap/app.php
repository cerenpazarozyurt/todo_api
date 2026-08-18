<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (NotFoundHttpException $e, $request) {
            return response()->json([
                'success' => false,
                'message' => 'Kayıt bulunamadı.',
            ], 404);
        });

        $exceptions->render(function (AuthenticationException $e, $request) {
            return response()->json([
                'success' => false,
                'message' => 'Giriş yapmanız gerekiyor.',
            ], 401);
        });

        $exceptions->render(function (ValidationException $e, $request) {
            return response()->json([
                'success' => false,
                'message' => 'Doğrulama hatası',
                'errors' => $e->errors(),
            ], 422);
        });
    })->create();
