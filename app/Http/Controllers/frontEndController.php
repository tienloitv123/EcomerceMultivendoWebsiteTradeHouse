<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;


class frontEndController extends Controller
{
    // public function homePage(Request $request){
    //     $data = [
    //         'pageTitle'=>'LARAVECOM | Online Shopping Website'
    //     ];
    //     return view('front.pages.home',$data);
    // }

    public function homePage()
    {
        $featuredProducts = Product::where('visibility', 1)->latest()->take(10)->get(); // Lấy 10 sản phẩm mới nhất
        return view('front.page.home', compact('featuredProducts'));
    }
    public function productList()
    {
        $products = Product::where('visibility', 1)->paginate(10); // Lấy sản phẩm có `visibility = 1`

        return view('front.page.product-list', compact('products'));
    }
}
