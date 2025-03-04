<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\LoginController; // Make sure LoginController is imported
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;

Route::middleware('admin')->group(function () {
    // Route::get('/admin', function () {
    //     return view('pages.admin');
    // });
    // Route::get('/', function () {
    //     return view('pages.home');
    // });
    // Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('pages.home');

    // Product
    Route::get('/product', [ProductController::class, 'index'])->name('pages.products.index');
    Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
    Route::get('/product/create', [ProductController::class, 'create'])->name('pages.products.create');
    Route::post('/product/store', [ProductController::class, 'store'])->name('pages.products.store');
    Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('pages.products.edit');
    Route::put('/product/{id}/update', [ProductController::class, 'update'])->name('pages.products.update');
    Route::delete('/product/{id}/delete', [ProductController::class, 'destroy'])->name('pages.products.delete');
    Route::post('/product/update-status', [ProductController::class, 'updateStatus'])->name('pages.products.update_status');
    Route::get('/products/filter', [ProductController::class, 'filterProducts'])->name('products.filter');

    // web.php (Routes)

Route::get('/product/get/{id}', [ProductController::class, 'getProduct'])->name('products.getProduct');

    
    // Category
    Route::get('/categories', [CategoryController::class, 'index'])->name('pages.categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('pages.categories.create');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('pages.categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('pages.categories.edit');
    Route::put('/categories/{id}/update', [CategoryController::class, 'update'])->name('pages.categories.update');
    Route::delete('/categories/{id}/delete', [CategoryController::class, 'destroy'])->name('pages.categories.delete');

    // Customer
    Route::get('/customers', [CustomerController::class, 'index'])->name('pages.customers.index');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('pages.customers.create');
    Route::post('/customers/store', [CustomerController::class, 'store'])->name('pages.customers.store');
    Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('pages.customers.edit');
    Route::put('/customers/{id}/update', [CustomerController::class, 'update'])->name('pages.customers.update');
    Route::delete('/customers/{id}/delete', [CustomerController::class, 'destroy'])->name('pages.customers.delete');

    //pos
    Route::get('/pos', [PosController::class, 'index'])->name('pages.pos.index');
    Route::get('/pos/search', [PosController::class, 'searchProduct'])->name('pos.search');


    //transaction
    Route::get('/transaction', [TransactionController::class, 'index'])->name('pages.transactions.index');
    Route::get('/transaction/create', [TransactionController::class, 'create'])->name('pages.transactions.create');
    Route::post('/transaction/store', [TransactionController::class, 'store'])->name('pages.transactions.store');
    Route::get('/transaction/{id}/edit', [TransactionController::class, 'edit'])->name('pages.transactions.edit');
    Route::put('/transaction/{id}/update', [TransactionController::class, 'update'])->name('pages.transactions.update');
    Route::delete('/transaction/{id}/delete', [TransactionController::class, 'destroy'])->name('pages.transactions.delete');
    Route::get('/transaction/search', [TransactionController::class, 'search'])->name('transaction.search');
    Route::get('/transaction/get/{id}', [TransactionController::class, 'getTransaction'])->name('transaction.getTransaction');
    Route::get('/transaction/filter', [TransactionController::class, 'filterPaymentstatus'])->name('transactions.filter');

    //user
    Route::get('/users', [UserController::class, 'index'])->name('pages.users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('pages.users.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('pages.users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('pages.users.edit');
    Route::put('/users/{id}/update', [UserController::class, 'update'])->name('pages.users.update');
    Route::delete('/users/{id}/delete', [UserController::class, 'destroy'])->name('pages.users.delete');
    Route::get('/user/search', [UserController::class, 'search'])->name('user.search');
    // Route::get('/users/get/{id}', [UserController::class, 'getUser'])->name('users.getUser');

});

Auth::routes(); // Default authentication routes

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});
