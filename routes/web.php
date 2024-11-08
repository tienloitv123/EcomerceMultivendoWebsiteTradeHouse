<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontEndController;
use App\Http\Controllers\Seller\ProductController;
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
    return view('front.page.home');
});
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.detail');

Route::view('/example-page','example-pages');
Route::view('/example-auth','example-auth');
Route::view ('/example-frontend','example-frontend');
Route::view('/homepage','front.page.home' );

