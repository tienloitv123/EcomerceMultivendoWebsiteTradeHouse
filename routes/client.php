<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;

Route::prefix('client')->name('client.')->group(function() {
    Route::middleware(['guest:client', 'PreventBackHistory'])->group(function() {
        Route::controller(ClientController::class)->group(function() {
            Route::get('/login', 'login')->name('login');
            Route::post('/login-handler', 'loginHandler')->name('login-handler');
            Route::get('/register', 'register')->name('register');
            Route::post('/create', 'createClient')->name('create');
            Route::get('/account/verify/{token}', 'verifyAccount')->name('verify');
            Route::get('/register-success', 'registerSuccess')->name('register-success');
            Route::get('/cart', [ClientController::class, 'viewCart'])->name('cart.view');
            Route::post('/add-to-cart', [ClientController::class, 'addToCart'])->name('cart.add');
            Route::get('/forgot-password', [ClientController::class, 'forgotPassword'])->name('forgot-password');
            Route::post('/send-password-reset-link', [ClientController::class, 'sendPasswordResetLink'])->name('send-password-reset-link');
            Route::get('/reset-password/{token}', [ClientController::class, 'showResetForm'])->name('reset-password');
            Route::post('/reset-password-handler', [ClientController::class, 'resetPasswordHandler'])->name('reset-password-handler');

        });
    });

    Route::middleware(['auth:client', 'PreventBackHistory'])->group(function() {
        Route::controller(ClientController::class)->group(function() {
            Route::get('/', 'home')->name('home');
            Route::post('/logout', 'logoutHandler')->name('logout');
            Route::get('/profile', 'profileView')->name('profile');
            Route::post('/update-profile', 'updateProfile')->name('update-profile');
            Route::post('/change-profile-picture', 'changeProfilePicture')->name('change-profile-picture');
            Route::get('/cart', [ClientController::class, 'showCart'])->name('cart');
            Route::post('/add-to-cart', 'addToCart')->name('cart.add');
            Route::post('/cart/update-quantity', 'updateCartQuantity')->name('cart.updateQuantity');
            Route::post('/cart/remove-item', 'removeItem')->name('cart.removeItem');
            Route::get('/order/preview', [ClientController::class, 'previewOrder'])->name('order.preview');
            Route::post('/order/store', [ClientController::class, 'storeOrder'])->name('order.store');
            Route::post('/order/create', [ClientController::class, 'createOrder'])->name('order.create');
            Route::get('/orders/manage', [ClientController::class, 'manageOrders'])->name('orders.manage');
            Route::post('/orders/{orderId}/update', [ClientController::class, 'updateOrderStatus'])->name('orders.update');
            Route::post('/client/update-password', [ClientController::class, 'updatePassword'])->name('update-password');
        });
    });
});
