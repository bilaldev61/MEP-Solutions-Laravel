<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// PHP 8.5 deprecates PDO::MYSQL_ATTR_SSL_CA, which Laravel's bundled
// config/database.php still references. That file is evaluated during config
// loading (before Laravel's error handler is installed), so the notices leak
// into page/CLI output. This runs early enough to silence deprecation-level
// messages everywhere without hiding real errors.
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
