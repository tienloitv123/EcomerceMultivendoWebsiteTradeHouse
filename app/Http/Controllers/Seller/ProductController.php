<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Rules\ValidatePrice;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
class ProductController extends Controller
{
    public function addProduct(Request $request){
        $data   = [
            'pageTitle'=> 'Add Product',
            'categories'=>Category::orderBy('category_name','asc')->get()

        ];
        return view('back.page.seller.add-products', $data);

    }

    public function getProductCategory(Request $request){
        $category_id = $request->category_id;
        $category = Category::findOrFail($category_id);
        $subcategories = SubCategory::where('category_id',$category_id)
                                    ->where('is_child_of',0)
                                    ->orderBy('subcategory_name','asc')
                                    ->get();

        $html = '';
        foreach( $subcategories as $item ){
            $html.='<option value="'.$item->id.'">'.$item->subcategory_name.'</option>';
            if( count($item->children) > 0 ){
                foreach( $item->children as $child ){
                    $html.='<option value="'.$child->id.'">-- '.$child->subcategory_name.'</option>';
                }
            }
        }
        return response()->json(['status'=>1,'data'=>$html]);
    }

    public function createProduct(Request $request){
        /**
         * VALIDATE THE FORM
         * -----------------
         */
        $request->validate([
            'name'=>'required|unique:products,name',
            'summary'=>'required|min:100',
            'product_image'=>'required|mimes:png,jpg,jpeg|max:1024',
            'category'=>'required|exists:categories,id',
            'subcategory'=>'required|exists:sub_categories,id',
            'price'=>['required',new ValidatePrice],
            'compare_price'=>['nullable',new ValidatePrice],
        ],[
            'name.required'=>'Enter product name',
            'name.unique'=>'This product name is already taken.',
            'summary.required'=>'Write summary for this product',
            'product_image.required'=>'Choose product image',
            'category.required'=>'Select product category',
            'subcategory.required'=>'Select product sub category',
            'price.required'=>'Enter product price'
        ]);

        $product_image = null;
        if( $request->hasFile('product_image') ){
            $path = 'images/products/';
            $file = $request->file('product_image');
            $filename = 'PIMG_'.time().uniqid().'.'.$file->getClientOriginalExtension();

            $upload = $file->move(public_path($path), $filename);
            // $maxWidth = 1080;
            // $maxHeight = 1080;
            // $full_path = $path.$filename;
            // $image = Image::make($file->path());

            // $image->height() > $image->width() ? $maxWidth = null : $maxHeight = null;
            // $image->fit($maxWidth, $maxHeight, function($constraint){
            //       $constraint->upsize();
            // });
            // $upload = $image->save($full_path);

            if( $upload ){
                $product_image = $filename;
            }
        }

        //SAVE PRODUCT DETAILS
        $product = new Product();
        $product->user_type = 'seller';
        $product->seller_id = auth('seller')->id();
        $product->name = $request->name;
        $product->summary = $request->summary;
        $product->category = $request->category;
        $product->subcategory = $request->subcategory;
        $product->price = $request->price;
        $product->compare_price = $request->compare_price;
        $product->visibility = $request->visibility;
        $product->product_image = $product_image;
        $saved = $product->save();

        if( $saved ){
            return response()->json(['status'=>1,'msg'=>'New product has been successfully created.']);
        }else{
            return response()->json(['status'=>0,'msg'=>'Something went wrong.']);
        }
    }
    public function allProducts(Request $request){
        $data = [
            'pageTitle'=>'My Products'
        ];
        return view('back.page.seller.products',$data);
    }
}
