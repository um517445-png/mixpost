<?php

if (!is_dir('/tmp/cache')) {
    @mkdir('/tmp/cache', 0777, true);
}
if (!is_dir('/tmp/storage/framework/views')) {
    @mkdir('/tmp/storage/framework/views', 0777, true);
}
if (!is_dir('/tmp/storage/framework/sessions')) {
    @mkdir('/tmp/storage/framework/sessions', 0777, true);
}

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();

$app->useStoragePath('/tmp/storage');
$app->useBootstrapPath('/tmp');
$app->useNamespace('App\\');

return $app;
