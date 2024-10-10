<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\VentasController;


Auth::routes();


Route::middleware(['auth'])->group(function(){
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products',ProductController::class)->middleware('admin');   
    Route::resource('supplier',SupplierController::class)->middleware('admin');
    Route::resource('customers',CustomerController::class)->middleware('admin');
    Route::resource('sales', SalesController::class)->only(['index']);
    Route::get('/ventas', [VentasController::class, 'index'])->name('ventas');
    
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});