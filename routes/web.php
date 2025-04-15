<?php

use App\Exports\SalesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['IsGuest'])->group(function () {
    Route::get('/login', [AuthController::class, 'index']);
    Route::post('/login/store', [AuthController::class, 'store'])->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['IsLogin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/sale', [SaleController::class, 'index'])->name('sale.index');
    Route::get('sales/generate-pdf/{id}', [SaleController::class, 'generatePdf'])->name('sales.generatePdf');

    Route::get('/export-sales', function () {
        return Excel::download(new SalesExport, 'sales.xlsx');
    })->name('sales.export');


    Route::middleware(['IsAdmin'])->group(function () {
        Route::get('/user', [UserController::class, 'index'])->name('user.index');
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

    Route::middleware(['IsEmployee'])->group(function () {
        Route::get('/sale/create', [SaleController::class, 'create'])->name('sale.create');
        Route::get('/sale/create/post', [SaleController::class, 'post'])->name('sale.post');
        Route::get('/sale/create/member/{id}', [SaleController::class, 'member'])->name('sale.member');
        Route::post('/sale/session', [SaleController::class, 'session'])->name('sale.session');
        Route::post('/sale/store', [SaleController::class, 'store'])->name('sale.store');
        Route::post('/sale/member/{id}', [SaleController::class, 'saveMember'])->name('sale.member.save');
        Route::get('/sale/detail-print/{id}', [SaleController::class, 'detail'])->name('sale.detail');
        Route::get('/sale/edit/{id}', [SaleController::class, 'edit']);
        Route::put('/sale/{id}', [SaleController::class, 'update']);
        Route::delete('/sale/{id}', [SaleController::class, 'destroy']);
    });
});

