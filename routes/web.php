<?php

use App\Http\Controllers\Admin\Franchises;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Rotas Administrativas
Route::prefix('admin')->name('admin.')->group(function () {
    Route::prefix('franchises')->name('franchises.')->group(function () {
        Route::get('/', [Franchises\IndexController::class, '__invoke'])->name('index');
        Route::get('/create', [Franchises\CreateController::class, 'create'])->name('create');
        Route::post('/', [Franchises\CreateController::class, '__invoke'])->name('store');
        
        // Rotas de edição - Note que removemos o '/admin/franchises' do início
        Route::get('/{franchise}/edit', [Franchises\EditController::class, '__invoke'])->name('edit');
        Route::put('/{franchise}', [Franchises\UpdateController::class, '__invoke'])->name('update');
    });
});
