<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->web(append: [
            // Ajoutez vos middlewares web ici si nécessaire
        ]);
        
        // Middleware de gestion des rôles
        $middleware->alias([
            'role' => RoleMiddleware::class,
        ]);
        
        $middleware->group('client', [
            'web',
            'auth',
            'role:client',
        ]);
        
        $middleware->group('gestionnaire', [
            'web',
            'auth',
            'role:gestionnaire',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
