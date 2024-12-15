<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Cart;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('front.layout.pages-layout', function ($view) {
            $cartItemCount = 0;

            if (auth('client')->check()) {
                $clientId = auth('client')->id();
                $cart = Cart::where('client_id', $clientId)->first();
                $cartItemCount = $cart ? $cart->cartDetails()->sum('quantity') : 0;
            }

            $view->with('cartItemCount', $cartItemCount);
        });
        }
}
