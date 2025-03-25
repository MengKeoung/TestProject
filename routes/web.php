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
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\ExchangeRateController;
use App\Http\Controllers\RoleController;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::middleware('admin')->name('admin.')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Product
    Route::get('/product', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
    Route::get('/product/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/product/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/product/{id}/update', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/product/{id}/delete', [ProductController::class, 'destroy'])->name('products.delete');
    Route::post('/product/update-status', [ProductController::class, 'updateStatus'])->name('products.update_status');
    Route::get('/products/filter', [ProductController::class, 'filterProducts'])->name('products.filter');

    // web.php (Routes)

    Route::get('/product/get/{id}', [ProductController::class, 'getProduct'])->name('products.getProduct');


    // Category
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}/update', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}/delete', [CategoryController::class, 'destroy'])->name('categories.delete');

    // Customer
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/customers/store', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{id}/update', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{id}/delete', [CustomerController::class, 'destroy'])->name('customers.delete');

    //pos
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::get('/pos/search', [PosController::class, 'searchProduct'])->name('pos.search');


    //transaction
    Route::get('/transaction', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transaction/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transaction/store', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transaction/{id}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::put('/transaction/{id}/update', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/transaction/{id}/delete', [TransactionController::class, 'destroy'])->name('transactions.delete');
    Route::get('/transaction/search', [TransactionController::class, 'search'])->name('transaction.search');
    Route::get('/transaction/get/{id}', [TransactionController::class, 'getTransaction'])->name('transaction.getTransaction');
    Route::get('/transaction/filter', [TransactionController::class, 'filterPaymentstatus'])->name('transactions.filter');

    //user
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}/update', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}/delete', [UserController::class, 'destroy'])->name('users.delete');
    Route::get('/user/search', [UserController::class, 'search'])->name('user.search');
    // Route::get('/users/get/{id}', [UserController::class, 'getUser'])->name('users.getUser');

    //role
    // Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    // Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::resource('roles', RoleController::class);

    //setting
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::put('/setting/update', [SettingController::class, 'update'])->name('setting.update');

    //currency
    // Route::get('/currency', [CurrencyController::class, 'index'])->name('currency.index');
    Route::get('/currency/create', [CurrencyController::class, 'create'])->name('currency.create');
    Route::post('/currency/store', [CurrencyController::class, 'store'])->name('currency.store');
    Route::get('/currency/{id}/edit', [CurrencyController::class, 'edit'])->name('currency.edit');
    Route::put('/currency/{id}/update', [CurrencyController::class, 'update'])->name('currency.update');
    Route::delete('/currency/{id}/delete', [CurrencyController::class, 'destroy'])->name('currency.delete');

    //paymentType
    // Route::get('/paymentType', [PaymentTypeController::class, 'index'])->name('paymentType.index');
    Route::get('/paymentType/create', [PaymentTypeController::class, 'create'])->name('paymentType.create');
    Route::post('/paymentType/store', [PaymentTypeController::class, 'store'])->name('paymentType.store');
    Route::get('/paymentType/{id}/edit', [PaymentTypeController::class, 'edit'])->name('paymentType.edit');
    Route::put('/paymentType/{id}/update', [PaymentTypeController::class, 'update'])->name('paymentType.update');
    Route::delete('/paymentType/{id}/delete', [PaymentTypeController::class, 'destroy'])->name('paymentType.delete');

    //exchangeRate
    // Route::get('/exchangeRate', [ExchangeRateController::class, 'index'])->name('exchangeRate.index');
    Route::get('/exchangeRate/create', [ExchangeRateController::class, 'create'])->name('exchangeRate.create');
    Route::post('/exchangeRate/store', [ExchangeRateController::class, 'store'])->name('exchangeRate.store');
    Route::get('/exchangeRate/{id}/edit', [ExchangeRateController::class, 'edit'])->name('exchangeRate.edit');
    Route::put('/exchangeRate/{id}/update', [ExchangeRateController::class, 'update'])->name('exchangeRate.update');
    Route::delete('/exchangeRate/{id}/delete', [ExchangeRateController::class, 'destroy'])->name('exchangeRate.delete');
});
