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


}
