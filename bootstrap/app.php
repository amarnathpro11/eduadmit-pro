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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'accountant' => \App\Http\Middleware\AccountantMiddleware::class,
            'admin.auth' => \App\Http\Middleware\AdminMiddleware::class,
            'counselor' => \App\Http\Middleware\CounselorMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, $request) {
            return redirect()->route('home')->with('error', 'Your session has expired due to inactivity. Please log in again.');
        });
    })->create();
