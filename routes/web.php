<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return redirect()->route('login');
    return view('login');
});

Route::match(["GET", "POST"], "/register", function () {
    return redirect("/login");
})->name("register");

Auth::routes();
Route::group(['middleware' => ['auth', 'admin']], function() {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('user', UserController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('product', ProductController::class);
});
