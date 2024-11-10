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
            'product_image'=>'required|mimes:png,jpg,jpeg,jfif|max:1024',
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

    public function editProduct(Request $request){
        $product = Product::findOrFail($request->id);
        $categories = Category::orderBy('category_name','asc')->get();
        $subcategories = SubCategory::where('category_id',$product->category)
                                    ->where('is_child_of',0)
                                    ->orderBy('subcategory_name','asc')
                                    ->get();
         $data = [
             'pageTitle'=>'Edit Product',
             'categories'=>$categories,
             'subcategories'=>$subcategories,
             'product'=>$product
         ];
         return view('back.page.seller.edit-product',$data);
     }

     public function updateProduct(Request $request){
        $product = Product::findOrFail($request->product_id);
        $product_image = $product->product_image;

         $request->validate([
            'name'=>'required|unique:products,name,'.$product->id,
            'summary'=>'required|min:100',
            'product_image'=>'nullable|mimes:png,jpg,jpeg|max:1024',
            'subcategory'=>'required|exists:sub_categories,id',
            'price'=>['required', new ValidatePrice],
            'compare_price'=>['nullable', new ValidatePrice],
         ],[
            'name.required'=>'Enter product name',
            'name.unique'=>'This product name is already taken',
            'summary.required'=>'Write product summary',
            'subcategory.required'=>'Select product sub category',
            'price.required'=>'Enter product price'
         ]);

         //Upload product image
         if( $request->hasFile('product_image') ){
            $path = 'images/products/';
            $file = $request->file('product_image');
            $filename = 'PIMG_'.time().uniqid().'.'.$file->getClientOriginalExtension();
            $old_product_image = $product->product_image;

            $upload = $file->move(public_path($path),$filename);
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
                //Delete old product image
                if( File::exists(public_path($path.$old_product_image)) ){
                    File::delete(public_path($path.$old_product_image));
                }

                $product_image = $filename;
            }
         }

         //UPDATE PRODUCT
         $product->name = $request->name;
         $product->slug = null;
         $product->summary = $request->summary;
         $product->category = $request->category;
         $product->subcategory = $request->subcategory;
         $product->price = $request->price;
         $product->compare_price = $request->compare_price;
         $product->visibility = $request->visibility;
         $product->product_image = $product_image;
         $updated = $product->save();

         if( $updated ){
            return response()->json(['status'=>1,'msg'=>'Product has been successfully updated.']);
         }else{
            return response()->json(['status'=>0,'msg'=>'Something went wrong.']);
         }
    }
    public function deleteProduct(Request $request){
        $product = Product::findOrFail($request->product_id);

        $path = 'images/products/';
        $product_image = $product->product_image;
        if ($product_image != null && File::exists(public_path($path . $product_image))) {
            File::delete(public_path($path . $product_image));
        }

        $delete = $product->delete();

        if ($delete) {
            return response()->json(['status' => 1, 'msg' => 'Product has been successfully deleted.']);
        } else {
            return response()->json(['status' => 0, 'msg' => 'Something went wrong.']);
        }
    }
//     public function show($id)
// {
//     $product = Product::findOrFail($id);

//     return view('front.page.product-detail', compact('product'));
// }

    public function show($slug)
    {
        // Find the product by slug
        $product = Product::where('slug', $slug)->firstOrFail();

        // Retrieve related products from the same seller (excluding the current product)
        $relatedProducts = Product::where('seller_id', $product->seller_id)
                                ->where('id', '!=', $product->id)
                                ->take(6) // Limit the number of related products displayed
                                ->get();

        return view('front.page.product-detail', compact('product', 'relatedProducts'));
    }
    public function search(Request $request)
    {
        $searchTerm = $request->input('query'); // Get the search term from the query parameter

        $products = Product::where('name', 'LIKE', '%' . $searchTerm . '%')
                    ->where('visibility', 1) // Assuming visibility = 1 means the product is visible
                    ->paginate(10); // You can set the pagination limit as needed

        return view('front.page.search_results', compact('products', 'searchTerm'));
    }

        public function children()
    {
        return $this->hasMany(SubCategory::class, 'is_child_of', 'id');
    }
    public function filter(Request $request)
    {
        $query = Product::query();

        // Apply search term filter first
        if ($request->filled('query')) {
            $searchTerm = $request->input('query');
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        // Apply category filter
        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        // Apply combined subcategory filter
        if ($request->filled('subcategory')) {
            $query->where('subcategory', $request->input('subcategory'));
        }

        // Apply price sorting
        if (in_array($request->input('price'), ['asc', 'desc'])) {
            $query->orderBy('price', $request->input('price'));
        }

        // Paginate the filtered results
        $products = $query->paginate(10);

        // Retrieve all categories with subcategories for the filter dropdowns
        $categories = Category::with('subcategories.children')->get();

        return view('front.page.search_results', [
            'products' => $products,
            'searchTerm' => $request->input('query'),
            'categories' => $categories,
        ]);
    }

    public function searchByCategory($id)
{
    $category = Category::findOrFail($id);

    // Fetch products by category and include visibility check
    $products = Product::where('category', $id)
        ->where('visibility', 1)
        ->paginate(10);

    return view('front.page.category_search_results', compact('products', 'category'));
}



}
