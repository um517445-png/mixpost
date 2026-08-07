<?php

use Illuminate\Support\Facades\Route;
use Inovector\Mixpost\Http\Controllers\AccountsController;
use Inovector\Mixpost\Http\Controllers\AddAccountController;
use Inovector\Mixpost\Http\Controllers\CallbackSocialProviderController;
use Inovector\Mixpost\Http\Controllers\DashboardController;
use Inovector\Mixpost\Http\Controllers\PostsController;
use Inovector\Mixpost\Http\Controllers\ServicesController;
use Inovector\Mixpost\Http\Controllers\SettingsController;
use Inovector\Mixpost\Http\Middleware\Auth;
use Inovector\Mixpost\Http\Middleware\HandleInertiaRequests;

Route::get('/', function () {
    return redirect('/mixpost');
});

Route::get('/login', function () {
    return redirect('/mixpost');
})->name('login');

Route::prefix(config('mixpost.prefix', 'mixpost'))
    ->name('mixpost.')
    ->middleware([
        'web',
        Auth::class,
        HandleInertiaRequests::class,
    ])
    ->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::get('/services', [ServicesController::class, 'index'])->name('services.index');
        Route::post('/services', [ServicesController::class, 'update'])->name('services.update');
        Route::get('/accounts', [AccountsController::class, 'index'])->name('accounts.index');
        Route::post('/accounts/add/{provider}', AddAccountController::class)->name('accounts.add');
        Route::post('/accounts/callback/{provider}', CallbackSocialProviderController::class)->name('accounts.callback');
        Route::delete('/accounts/{account}', [AccountsController::class, 'delete'])->name('accounts.delete');
        Route::get('/posts', [PostsController::class, 'index'])->name('posts.index');
        Route::get('/posts/create', [PostsController::class, 'create'])->name('posts.create');
        Route::post('/posts', [PostsController::class, 'store'])->name('posts.store');
        Route::get('/posts/{post}/edit', [PostsController::class, 'edit'])->name('posts.edit');
        Route::put('/posts/{post}', [PostsController::class, 'update'])->name('posts.update');
        Route::delete('/posts/{post}', [PostsController::class, 'destroy'])->name('posts.destroy');
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
    });
