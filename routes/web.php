<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\PetugasController;
use Illuminate\Support\Facades\Http;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login'); // Buat tampilan login
})->name('login');



Route::post('/login', [AuthController::class, 'login'])->name('loginConfirm');

Route::post( '/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('/admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
   // Product routes
   Route::get('/products', [ProductController::class, 'index'])->name('products');
   Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
   Route::post('/products', [ProductController::class, 'store'])->name('products.store');
   Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
   Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
   Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

   // User routes
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/admin/users/export', [UserController::class, 'export'])->name('users.export');

    Route::get('/sales', [SaleController::class, 'adminIndex'])->name('sale');
    Route::get('/sales/export-excel', [SaleController::class, 'adminExportExcel'])->name('sale.export');
    
    Route::get('/export', [SaleController::class, 'exportExcel'])->name('exportInvoice');
});

// Route untuk petugas
Route::prefix('petugas')->group(function () {

    Route::get('/dashboard', [SaleController::class, 'dashboard'])->name('petugas.dashboard');

    Route::get('/product', [PetugasController::class, 'index'])->name('petugas.products');

    // pembelian
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('/products', [SaleController::class, 'productSale'])->name('sales.products');
    Route::post('/checkout', [SaleController::class, 'checkout'])->name('sales.checkout');
    Route::post('/payment', [SaleController::class, 'paymentTransaction'])->name('sales.payment');
    Route::post('/member-payment', [SaleController::class, 'memberTransaction'])->name('sales.memberpayment');
    Route::get('/receipt/{id}', [SaleController::class, 'showReceipt'])->name('sales.receipt');
    Route::get('/invoice/{id}', [SaleController::class, 'printPDF'])->name('sales.invoice');
    Route::get('/export-excel', [SaleController::class, 'exportExcel'])->name('sales.export');



});