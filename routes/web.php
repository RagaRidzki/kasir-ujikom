<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['IsGuest'])->group(function() {
    Route::get('/login', [AuthController::class, 'index']);
    Route::post('/login/store', [AuthController::class, 'store'])->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['IsLogin'])->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/sale', [SaleController::class, 'index'])->name('sale.index');

    Route::middleware(['IsAdmin'])->group(function() {
        Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
        Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.delete');

        Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::patch('/product/{id}', [ProductController::class, 'updateStock'])->name('product.update.stock');
        Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.delete');
    });
});
