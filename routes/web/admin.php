<?php

use App\Http\Controllers\Admin\Franchises;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::prefix('franchises')->name('franchises.')->group(function () {
        Route::get('/', [Franchises\IndexController::class, '__invoke'])->name('index');
        Route::get('/create', [Franchises\CreateController::class, 'create'])->name('create');
        Route::post('/', [Franchises\CreateController::class, '__invoke'])->name('store');
    });
});