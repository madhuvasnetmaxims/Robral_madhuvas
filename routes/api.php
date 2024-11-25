<?php

use App\Http\Controllers\Api\productController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::post("/login",[UserController::class,"login"]);
Route::post("/register",[UserController::class,"register"]);

// product crud for users
Route::middleware('tokenCheck')->group(function () {
    Route::resource("product", productController::class);
    Route::post('/product-update',[ProductController::class,"updateProduct"]);
    Route::get('/product-search', [ProductController::class, 'search']);
    Route::post('/logout', [UserController::class, 'logout'])->middleware("auth:api");
});





