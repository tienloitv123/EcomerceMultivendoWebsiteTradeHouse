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
        });
    });

    Route::middleware(['auth:client', 'PreventBackHistory'])->group(function() {
        Route::controller(ClientController::class)->group(function() {
            Route::get('/', 'home')->name('home');
            Route::post('/logout', 'logoutHandler')->name('logout');
            Route::get('/profile', 'profileView')->name('profile');
            Route::post('/update-profile', 'updateProfile')->name('update-profile');
            Route::post('/change-profile-picture', 'changeProfilePicture')->name('change-profile-picture'); 
        });
    });
});
