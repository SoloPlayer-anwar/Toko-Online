<?php

use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\RateController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// RESPONSE USER
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::post('updated/{id}', [UserController::class, 'updated']);
Route::post('delete/{id}', [UserController::class, 'delete']);
Route::get('user', [UserController::class, 'user']);

// REPONSE CATEGORY
Route::get('category', [CategoryController::class, 'category']);

// Response Profile
Route::post('profile', [ProfileController::class, 'profile']);
Route::post('profile/{id}', [ProfileController::class, 'editProfile']);

// Product
Route::get('product', [ProductController::class, 'product']);

// Rating
Route::post('rate', [RateController::class, 'storeRate']);

// Cart
Route::post('cart', [CartController::class, 'storeCart']);
Route::post('cart/{id}', [CartController::class, 'updateCart']);
Route::delete('cart/{id}', [CartController::class, 'destroyCart']);
Route::get('cart', [CartController::class, 'cart']);

// Transaction
Route::post('checkout', [TransactionController::class, 'checkout']);
Route::post('checkout/{id}', [TransactionController::class, 'updateCheckout']);
Route::delete('checkout/{id}', [TransactionController::class, 'deleteCheckout']);
Route::get('transaction', [TransactionController::class, 'transaction']);

