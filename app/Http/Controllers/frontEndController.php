<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;


class frontEndController extends Controller
{
    public function homePage(Request $request){
        $data = [
            'pageTitle'=>'LARAVECOM | Online Shopping Website'
        ];
        return view('front.pages.home',$data);
    }
    // public function homePage(Request $request)
    // {
    //     $products = Product::where('visibility', 1)->paginate(10);
    //     return view('front.pages.home', [
    //         'pageTitle' => 'LARAVECOM | Online Shopping Website',
    //         'products' => $products,
    //     ]);
    // }

}
