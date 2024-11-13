<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontEndController;
use App\Http\Controllers\Seller\ProductController;
use App\Models\SubCategory;
use Illuminate\Http\Request;
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
//     return view('front.page.home');
// });
Route::get('/', [FrontEndController::class, 'homePage'])->name('home');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.detail');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/products', [FrontEndController::class, 'productList'])->name('products.list');
Route::view('/example-page','example-pages');
Route::view('/example-auth','example-auth');
Route::view ('/example-frontend','example-frontend');
Route::view('/homepage','front.page.home' );
Route::get('/filter', [ProductController::class, 'filter'])->name('product.filter');

Route::get('/search', [ProductController::class, 'search'])->name('product.search');

Route::get('/about-us', [FrontEndController::class, 'getGeneralSettings'])->name('about-us');

Route::get('/category/{id}', [ProductController::class, 'searchByCategory'])->name('category.search');
Route::get('/api/subcategories', function (Request $request) {
    $categoryId = $request->query('category_id');
    return SubCategory::where('category_id', $categoryId)
                      ->where('is_child_of', 0)
                      ->with('children') // Include child subcategories
                      ->get();
});
Route::get('/contact-us', [FrontEndController::class, 'getContactDetails'])->name('contact-us');

// Route::get('/general-settings', [FrontEndController::class, 'getGeneralSettings'])->name('general-settings');

