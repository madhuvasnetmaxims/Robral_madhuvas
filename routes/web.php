<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

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
//  user authentication apis
Route::get('/register',[AuthController::class,"register"])->name("register");
Route::post('/reg-sav',[AuthController::class,'regSave'])->name('reg-save');
Route::get('/login',[AuthController::class,"login"])->name("login");
Route::post('/login-verify',[AuthController::class,'verify'])->name('user-verify');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');


// dashboard apis 
// Note :- i am not using any authentication middleware because i am handdling both guest and logged in users with session
Route::get('/',[ProductController::class,"index"])->name("index");
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add-to-cart');
Route::get('/cart', [CartController::class, 'viewCart'])->name('view.cart');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart-update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

