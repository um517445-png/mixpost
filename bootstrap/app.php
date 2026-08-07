<?php

use Illuminate\Foundation\Application;

$app = new Application(dirname(__DIR__));

$app->useStoragePath('/tmp');

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    Illuminate\Foundation\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    Illuminate\Foundation\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    Illuminate\Foundation\Exceptions\Handler::class
);

$app->register(Illuminate\Events\EventServiceProvider::class);
$app->register(Illuminate\Log\LogServiceProvider::class);
$app->register(Illuminate\Routing\RoutingServiceProvider::class);
$app->register(Illuminate\Filesystem\FilesystemServiceProvider::class);
$app->register(Illuminate\View\ViewServiceProvider::class);
$app->register(Illuminate\Session\SessionServiceProvider::class);
$app->register(Illuminate\Cache\CacheServiceProvider::class);
$app->register(Illuminate\Database\DatabaseServiceProvider::class);
$app->register(Illuminate\Translation\TranslationServiceProvider::class);
$app->register(Illuminate\Validation\ValidationServiceProvider::class);
$app->register(Illuminate\Cookie\CookieServiceProvider::class);

$app->register(Inovector\Mixpost\MixpostServiceProvider::class);

return $app;
