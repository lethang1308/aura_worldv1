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
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\VariantController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/adminn', function () {
    return view('admins.layouts.default');
})->middleware('checklogin')->name('admin');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/logout', function () {
    Auth::logout(); // Đăng xuất
    return redirect('/login');
})->name('logout');

// Bọc tất cả route trong middleware 'auth' và prefix 'admin'
Route::middleware(['checklogin'])->prefix('admin')->group(function () {

    // Product routes
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::patch('/products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
    Route::get('/products/trash', [ProductController::class, 'trash'])->name('products.trash');

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

    // Admin dashboard
    Route::get('/', [AdminController::class, 'index'])->name('admin.list');

    // Product Image routes
    Route::delete('/products/images/{id}', [ProductImageController::class, 'destroy'])->name('products.images.destroy');
    Route::get('/images', [ProductImageController::class, 'index'])->name('products.images.list');

    // Brand routes
    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
    Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
    Route::get('/brands/{id}/edit', [BrandController::class, 'edit'])->name('brands.edit');
    Route::put('/brands/{id}', [BrandController::class, 'update'])->name('brands.update');
    Route::delete('/brands/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');
    Route::patch('/brands/{id}/restore', [BrandController::class, 'restore'])->name('brands.restore');
    Route::get('/brands/trash', [BrandController::class, 'trash'])->name('brands.trash');

    // Variant routes
    Route::get('/variants', [VariantController::class, 'index'])->name('variants.index');
    Route::get('/variants/create', [VariantController::class, 'create'])->name('variants.create');
    Route::post('/variants', [VariantController::class, 'store'])->name('variants.store');
    Route::get('/variants/{id}', [VariantController::class, 'show'])->name('variants.show');
    Route::get('/variants/{id}/edit', [VariantController::class, 'edit'])->name('variants.edit');
    Route::put('/variants/{id}', [VariantController::class, 'update'])->name('variants.update');
    Route::delete('/variants/{id}', [VariantController::class, 'destroy'])->name('variants.destroy');
    Route::patch('/variants/{id}/status', [VariantController::class, 'updateStatus'])->name('variants.updateStatus');
    Route::get('/variants/trash', [VariantController::class, 'trash'])->name('variants.trash');
    Route::patch('/variants/{id}/restore', [VariantController::class, 'restore'])->name('variants.restore');
    Route::delete('/variants/{id}/force-delete', [VariantController::class, 'forceDelete'])->name('variants.forceDelete');
    Route::get('/variants/product/{productId}/attributes', [VariantController::class, 'getAttributeValuesByProduct'])->name('variants.getAttributeValuesByProduct');
});

// Forgot password routes (nên không bọc auth)
Route::get('/password/forgot', [ForgotPasswordController::class, 'showForgotForm'])->name('password.forgot');
Route::post('/password/forgot', [ForgotPasswordController::class, 'handleForgotPassword'])->name('password.handleForgot');
Route::get('/password/reset', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::put('/password/reset', [ForgotPasswordController::class, 'handleResetPassword'])->name('password.handleReset');


Route::get('/client', function () {
    return view('clients.home');
})->name('clients.home');