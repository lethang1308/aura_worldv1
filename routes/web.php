<?php

use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BannerController;
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
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\VariantController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\VNPayController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ShipperController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/adminn', function () {
    return view('admins.layouts.default');
})->middleware('checklogin')->name('admin');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->middleware('redirect.authenticated')->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('auths/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auths/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');

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
    Route::get('/products/trash', [ProductController::class, 'trash'])->name('products.trash');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::patch('/products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
    Route::delete('/products/{id}/force-delete', [ProductController::class, 'forceDelete'])->name('products.forceDelete');

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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

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
    Route::get('/variants/trash', [VariantController::class, 'trash'])->name('variants.trash');
    Route::patch('/variants/restore-multiple', [VariantController::class, 'restoreMultiple'])->name('variants.restoreMultiple');
    Route::delete('/variants/force-delete-multiple', [VariantController::class, 'forceDeleteMultiple'])->name('variants.forceDeleteMultiple');
    Route::delete('/variants/empty-trash', [VariantController::class, 'emptyTrash'])->name('variants.emptyTrash');
    Route::get('/variants/product/{productId}/attributes', [VariantController::class, 'getAttributeValuesByProduct'])->name('variants.getAttributeValuesByProduct');
    Route::get('/variants/{id}', [VariantController::class, 'show'])->name('variants.show');
    Route::get('/variants/{id}/edit', [VariantController::class, 'edit'])->name('variants.edit');
    Route::put('/variants/{id}', [VariantController::class, 'update'])->name('variants.update');
    Route::delete('/variants/{id}', [VariantController::class, 'destroy'])->name('variants.destroy');
    Route::patch('/variants/{id}/status', [VariantController::class, 'updateStatus'])->name('variants.updateStatus');
    Route::patch('/variants/{id}/restore', [VariantController::class, 'restore'])->name('variants.restore');
    Route::delete('/variants/{id}/force-delete', [VariantController::class, 'forceDelete'])->name('variants.forceDelete');

    // Order routes (Admin)
    Route::get('/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/update-status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::post('/orders/{id}/cancel', [App\Http\Controllers\Admin\OrderController::class, 'cancel'])->name('orders.cancel');
    Route::get('/orders-search', [App\Http\Controllers\Admin\OrderController::class, 'search'])->name('orders.search');

    // Route review cho admin  
    Route::get('/reviews', [ReviewController::class, 'index'])->name('admin.reviews.list');
    Route::get('/reviews/{id}/edit', [ReviewController::class, 'edit'])->name('admin.reviews.edit');
    Route::put('/reviews/{id}', [ReviewController::class, 'update'])->name('admin.reviews.update');
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('admin.reviews.delete');

    // Coupon routes
    Route::get('/coupons', [\App\Http\Controllers\Admin\CouponController::class, 'index'])->name('coupons.index');
    Route::get('/coupons/create', [\App\Http\Controllers\Admin\CouponController::class, 'create'])->name('coupons.create');
    Route::post('/coupons', [\App\Http\Controllers\Admin\CouponController::class, 'store'])->name('coupons.store');
    Route::get('/coupons/{id}/edit', [\App\Http\Controllers\Admin\CouponController::class, 'edit'])->name('coupons.edit');
    Route::put('/coupons/{id}', [\App\Http\Controllers\Admin\CouponController::class, 'update'])->name('coupons.update');
    Route::delete('/coupons/{id}', [\App\Http\Controllers\Admin\CouponController::class, 'destroy'])->name('coupons.destroy');
    Route::patch('/coupons/{id}/restore', [\App\Http\Controllers\Admin\CouponController::class, 'restore'])->name('coupons.restore');
    Route::get('/coupons/trash', [\App\Http\Controllers\Admin\CouponController::class, 'trash'])->name('coupons.trash');

    // Banner routes
    Route::get('/banners', [BannerController::class, 'index'])->name('banners.index');
    Route::get('/banners/create', [BannerController::class, 'create'])->name('banners.create');
    Route::post('/banners', [BannerController::class, 'store'])->name('banners.store');
    Route::get('/banners/{id}', [BannerController::class, 'show'])->name('banners.show');
    Route::get('/banners/{id}/edit', [BannerController::class, 'edit'])->name('banners.edit');
    Route::put('/banners/{id}', [BannerController::class, 'update'])->name('banners.update');
    Route::delete('/banners/{id}', [BannerController::class, 'destroy'])->name('banners.destroy');
    Route::patch('/banners/{id}/restore', [BannerController::class, 'restore'])->name('banners.restore');
    Route::get('/banners/trash', [BannerController::class, 'trash'])->name('banners.trash');
    Route::delete('/banners/{id}/force-delete', [BannerController::class, 'forceDelete'])->name('banners.forceDelete');

    // Admin profile routes
    Route::get('/profile', [AdminController::class, 'showProfile'])->name('admin.profile');
    Route::post('/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');

    Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases.index');
    Route::get('/purchases/{id}', [PurchaseController::class, 'show'])->name('purchases.show');
});

// Forgot password routes (nên không bọc auth)
Route::get('/password/forgot', [ForgotPasswordController::class, 'showForgotForm'])->name('password.forgot');
Route::post('/password/forgot', [ForgotPasswordController::class, 'handleForgotPassword'])->name('password.handleForgot');
Route::get('/password/reset', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::put('/password/reset', [ForgotPasswordController::class, 'handleResetPassword'])->name('password.handleReset');


Route::get('/clients', function () {
    return view('clients.layouts.home');
})->name('clients.home');

Route::prefix('clients')->group(function () {
    Route::get('/', [ClientController::class, 'home'])->name('client.home');

    Route::get('/products', [ClientController::class, 'index'])->name('client.products');
    Route::get('/products/{id}', [ClientController::class, 'showProduct'])->name('client.products.show');
    Route::get('/brands', [ClientController::class, 'showAllBrand'])->name('client.brands');

    Route::get('/carts', [ClientController::class, 'viewCart'])->name('client.carts');
    Route::post('/carts/add', [ClientController::class, 'addToCart'])->name('client.carts.add');

    Route::get('/profiles', [ClientController::class, 'showProfile'])->name('client.profiles');

    Route::get('/profiles/change', [ClientController::class, 'showChangePasswordForm'])->name('password.change');


    Route::get('/orders', [ClientController::class, 'orderList'])->name('client.orders');

    Route::post('/products/{id}/reviews', [ClientController::class, 'addReview'])->name('review.add');
});

Route::prefix('clients')->middleware('auth')->group(function () {

    Route::get('/cart/recalculate', [ClientController::class, 'recalculate'])->name('client.carts.recalculate');
    Route::put('/carts/update/{item}', [ClientController::class, 'updateQuantity'])->name('client.carts.update');
    Route::delete('/cart/delete/{item}', [ClientController::class, 'deleteProduct'])->name('client.carts.delete');

    Route::get('/carts/checkout', [ClientController::class, 'viewCheckOut'])->name('client.carts.checkout');
    Route::post('/carts/checkout', [ClientController::class, 'placeOrder'])->name('client.carts.placeOrder');
    Route::get('/checkout/vnpay-return', [ClientController::class, 'handleReturn']);


    Route::post('/profiles/update', [ClientController::class, 'updateProfile'])->name('client.profiles.update');
    Route::post('/profiles/change', [ClientController::class, 'changePassword'])->name('password.change.post');

    Route::get('/orders/{id}', [ClientController::class, 'orderDetail'])->name('client.orders.detail');
    Route::post('/orders/cancel', [ClientController::class, 'cancelOrder'])->name('client.orders.cancel');

    Route::post('/coupon/use-coupon', [ClientController::class, 'useCoupon'])->name('client.carts.useCoupon');
    Route::post('/coupon/remove-coupon', [ClientController::class, 'removeCoupon'])->name('client.carts.removeCoupon');
});

Route::get('/orders/success', [VNPayController::class, 'paymentSuccess'])->name('client.orders.success');
Route::get('/orders/failed', [VNPayController::class, 'paymentFailed'])->name('client.orders.failed');
Route::get('/vnpay/return', [VNPayController::class, 'return'])->name('vnpay.return');
