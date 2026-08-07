<?php

use Illuminate\Foundation\Application;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        \Inovector\Mixpost\MixpostServiceProvider::class,
    ])
    ->create();
