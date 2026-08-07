<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/mixpost');
});

Route::get('/login', function () {
    return redirect('/mixpost');
})->name('login');
