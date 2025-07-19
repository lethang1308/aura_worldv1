<?php

use App\Http\Controllers\AdminController;
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
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\ProductImageController;

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
Route::patch('/categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
Route::get('/categories/trash', [CategoryController::class, 'trash'])->name('categories.trash');

// Customer routes
Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
Route::patch('/customers/{id}/restore', [CustomerController::class, 'restore'])->name('customers.restore');
Route::get('/customers/trash', [CustomerController::class, 'trash'])->name('customers.trash');

// Attribute routes
Route::get('/attributes', [AttributeController::class, 'index'])->name('attributes.index');
Route::get('/attributes/create', [AttributeController::class, 'create'])->name('attributes.create');
Route::post('/attributes', [AttributeController::class, 'store'])->name('attributes.store');
Route::get('/attributes/{id}/edit', [AttributeController::class, 'edit'])->name('attributes.edit');
Route::put('/attributes/{id}', [AttributeController::class, 'update'])->name('attributes.update');
Route::delete('/attributes/{id}', [AttributeController::class, 'destroy'])->name('attributes.destroy');
Route::patch('/attributes/{id}/restore', [AttributeController::class, 'restore'])->name('attributes.restore');
Route::get('/attributes/trash', [AttributeController::class, 'trash'])->name('attributes.trash');

// Attribute Value routes
Route::get('/attributevalues', [AttributeValueController::class, 'index'])->name('attributeValues.list');
Route::get('/attributevalues/create', [AttributeValueController::class, 'create'])->name('attributeValues.create');
Route::post('/attributevalues', [AttributeValueController::class, 'store'])->name('attributeValues.store');
Route::get('/attributevalues/{id}/edit', [AttributeValueController::class, 'edit'])->name('attributeValues.edit');
Route::put('/attributevalues/{id}', [AttributeValueController::class, 'update'])->name('attributeValues.update');
Route::delete('/attributevalues/{id}', [AttributeValueController::class, 'destroy'])->name('attributeValues.destroy');
Route::patch('/attributevalues/{id}/restore', [AttributeValueController::class, 'restore'])->name('attributeValues.restore');
Route::get('/attributevalues/trash', [AttributeValueController::class, 'trash'])->name('attributeValues.trash');

// Forgot password
Route::get('/password/forgot', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ForgotPasswordController::class, 'reset'])->name('password.update');

// Admin route
Route::get('/', [AdminController::class, 'index'])->name('admin.list');

// Product Image routes
Route::delete('/products/images/{id}', [ProductImageController::class, 'destroy'])->name('products.images.destroy');
Route::get('/images', [ProductImageController::class, 'index'])->name('products.images.list');
