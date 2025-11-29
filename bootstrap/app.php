<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckUserLogin;
use App\Http\Middleware\CheckFrontendUser;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        using: function () {
            require __DIR__.'/../routes/web.php';
            require __DIR__.'/../routes/admin.php';
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'checkLogin' => CheckUserLogin::class,
            'checkfrontenduser' => CheckFrontendUser::class,
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,

        ]);
         
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // You can customize exception handling here
    })
    ->create();
