<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Shop;
use App\Models\CartDetail;
use App\Models\GeneralSetting;

class frontEndController extends Controller
{


    public function homePage()
    {
        $featuredProducts = Product::where('visibility', 1)
        ->inRandomOrder() // Randomize products
        ->take(9) // Limit to 9 products
        ->get();

        $newestProducts = Product::orderBy('created_at', 'desc')
        ->take(7)
        ->get();


        $cartItemCount = 0;
    if (auth('client')->check()) {
        $cart = Cart::where('client_id', auth('client')->id())->first();
        $cartItemCount = $cart ? $cart->cartDetails()->sum('quantity') : 0;
    }
        return view('front.page.home', compact('featuredProducts', 'cartItemCount', 'newestProducts'));
    }
    public function productList()
    {
        $products = Product::where('visibility', 1)->paginate(10);
        return view('front.page.product-list', compact('products'));
    }

    public function getGeneralSettings()
    {
        $settings = GeneralSetting::first();
        return view('front.page.about-us', compact('settings'));

    }
    public function getContactDetails()
    {
        $settings = GeneralSetting::first();
        return view('front.page.contact-us', compact('settings'));
    }

public function viewShop($shopId)
{
    // Fetch the shop by ID
    $shop = Shop::with('seller')->findOrFail($shopId);

    // Fetch products for this shop using the seller_id linked to the shop
    $products = Product::where('seller_id', $shop->seller_id)
                       ->where('visibility', 1) // Only visible products
                       ->paginate(9);

    return view('front.page.shop-view', compact('shop', 'products'));
}

public function viewShopBySeller($sellerId)
{
    // Fetch the shop associated with the seller_id
    $shop = Shop::where('seller_id', $sellerId)->with('seller')->firstOrFail();

    // Fetch products for this shop using the seller_id
    $products = Product::where('seller_id', $sellerId)
                       ->where('visibility', 1) // Only visible products
                       ->paginate(9);

    return view('front.page.shop-view', compact('shop', 'products'));
}
}
