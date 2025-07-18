<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AttributeValueController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/adminn', function () {
    return view('admins.layouts.default');
})->name('admin');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/logout', function () {
    Auth::logout(); // Đăng xuất
    return redirect('/login'); // Chuyển hướng về trang login
})->name('logout');

// Product routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

// Category routes
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

// Customer routes
Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');

// Attribute routes
Route::get('/attributes', [AttributeController::class, 'index'])->name('attributes.index');
Route::get('/attributes/create', [AttributeController::class, 'create'])->name('attributes.create');
Route::post('/attributes', [AttributeController::class, 'store'])->name('attributes.store');
Route::get('/attributes/{id}/edit', [AttributeController::class, 'edit'])->name('attributes.edit');
Route::put('/attributes/{id}', [AttributeController::class, 'update'])->name('attributes.update');
Route::delete('/attributes/{id}', [AttributeController::class, 'destroy'])->name('attributes.destroy');

Route::get('/', [AttributeValueController::class, 'index'])->name('attributeValues.list');
Route::get('/create', [AttributeValueController::class, 'create'])->name('attributeValues.create');
Route::post('/', [AttributeValueController::class, 'store'])->name('attributeValues.store');
Route::get('/{id}/edit', [AttributeValueController::class, 'edit'])->name('attributeValues.edit');
Route::put('/{id}', [AttributeValueController::class, 'update'])->name('attributeValues.update');
Route::delete('/{id}', [AttributeValueController::class, 'destroy'])->name('attributeValues.destroy');
