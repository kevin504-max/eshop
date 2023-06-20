<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Frontend\FrontEndController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\FrontEnd\WishlistController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [FrontEndController::class, 'index']);
Route::get('category/', [FrontEndController::class, 'category']);
Route::get('category/{slug}', [FrontEndController::class, 'viewCategory']);
Route::get('category/{slug}/{product_title}', [FrontEndController::class, 'viewProduct']);

Auth::routes();

Route::get('load-cart-data', [CartController::class, 'cartCount']);
Route::get('load-wishlist-data', [WishlistController::class, 'wishlistCount']);
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('add-to-cart', [CartController::class, 'addProduct']);
Route::post('delete-cart-item', [CartController::class, 'removeProduct']);
Route::post('update-cart', [CartController::class, 'updateCart']);

Route::post('add-to-wishlist', [WishlistController::class, 'addProduct']);
Route::post('delete-wishlist-item', [WishlistController::class, 'removeProduct']);


Route::middleware(['auth'])->group(function () {
    Route::get('cart', [CartController::class, 'viewCart']);
    Route::get('checkout', [CheckoutController::class, 'index']);
    Route::post('place-order', [CheckoutController::class, 'placeOrder']);
    Route::get('my-orders', [UserController::class, 'index']);
    Route::get('view-order/{id}', [UserController::class, 'view']);
    Route::get('wishlist', [WishlistController::class, 'index']);
});

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\FrontEndController::class, 'index']);

    Route::name('categories.')->prefix('categories')->group(function () {
        Route::get('index', [CategoryController::class, 'index'])->name('index');
        Route::post('store', [CategoryController::class, 'store'])->name('store');
        Route::put('update', [CategoryController::class, 'update'])->name('update');
        Route::delete('destroy', [CategoryController::class, 'destroy'])->name('destroy');
    });

    Route::name('products.')->prefix('products')->group(function () {
        Route::get('index', [ProductController::class, 'index'])->name('index');
        Route::post('store', [ProductController::class, 'store'])->name('store');
        Route::put('update', [ProductController::class, 'update'])->name('update');
        Route::delete('destroy', [ProductController::class, 'destroy'])->name('destroy');
    });

    Route::name('admin.orders.')->prefix('orders')->group(function () {
        Route::get('index', [OrderController::class, 'index'])->name('index');
        Route::get('view-order/{id}', [OrderController::class, 'view'])->name('view');
        Route::put('update', [OrderController::class, 'update'])->name('update');
        Route::get('history', [OrderController::class, 'history'])->name('history');
    });

    Route::name('dashboard.')->prefix('dashboard')->group(function () {
        Route::get('users', [DashboardController::class, 'users'])->name('users');
        Route::get('view-user/{id}', [DashboardController::class, 'viewUser'])->name('viewUser');
    });
});
