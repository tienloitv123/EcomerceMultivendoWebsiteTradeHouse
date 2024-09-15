<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerController;

Route::prefix('seller')->name('seller.')->group(function(){

    Route::middleware([])->group(function(){
        Route::controller(SellerController::class)->group(function(){

            Route::get('/login','login')->name('login');
            Route::get('/register','register')->name('register');
            Route::post('/create','createSeller')->name('create');
            Route::get('/account/verify/{token}','verifyAccount')->name('verify');
            Route::get('/register-success','registerSuccess')->name('register-success');

        });
    });

    Route::middleware([])->group(function(){
        Route::controller(SellerController::class)->group(function(){
            Route::get('/','home')->name('home');
        });
    });
});


