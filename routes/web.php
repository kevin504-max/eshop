<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\FrontEndController;
use App\Http\Controllers\Admin\CategoriasController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/dashboard', [FrontEndController::class, 'index']);

    Route::name('categoria.')->prefix('categoria')->group(function () {
        Route::get('index', [CategoriasController::class, 'index'])->name('index');
        Route::post('store', [CategoriasController::class, 'store'])->name('store');
        Route::put('update', [CategoriasController::class, 'update'])->name('update');
        Route::delete('destroy', [CategoriasController::class, 'destroy'])->name('destroy');
    });
});
