<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\CartDetail;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Rules\ValidatePrice;
use Illuminate\Support\Facades\File;
use App\Models\Shop;
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
        $request->validate([
            'name'=>'required|unique:products,name',
            'summary'=>'required|min:20',
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

     public function updateProduct(Request $request)
     {
         $product = Product::findOrFail($request->product_id);
         $existingImage = $product->product_image;

         $validatedData = $request->validate([
             'name' => 'required|unique:products,name,' . $product->id,
             'summary' => 'required|min:20',
             'product_image' => 'nullable|mimes:png,jpg,jpeg|max:1024',
             'subcategory' => 'required|exists:sub_categories,id',
             'price' => ['required', new ValidatePrice],
             'compare_price' => ['nullable', new ValidatePrice],
         ], [
             'name.required' => 'Enter product name',
             'name.unique' => 'This product name is already taken',
             'summary.required' => 'Write product summary',
             'subcategory.required' => 'Select product subcategory',
             'price.required' => 'Enter product price',
         ]);

         if ($request->hasFile('product_image')) {
             $uploadDirectory = 'images/products/';
             $uploadedFile = $request->file('product_image');
             $newFileName = 'PIMG_' . time() . uniqid() . '.' . $uploadedFile->getClientOriginalExtension();

             if (!empty($existingImage) && File::exists(public_path($uploadDirectory . $existingImage))) {
                 File::delete(public_path($uploadDirectory . $existingImage));
             }

             $uploadedFile->move(public_path($uploadDirectory), $newFileName);
             $existingImage = $newFileName;
         }

         $product->fill([
             'name' => $validatedData['name'],
             'slug' => null,
             'summary' => $validatedData['summary'],
             'category' => $request->category,
             'subcategory' => $validatedData['subcategory'],
             'price' => $validatedData['price'],
             'compare_price' => $validatedData['compare_price'],
             'visibility' => $request->visibility,
             'product_image' => $existingImage,
         ]);

         if ($product->save()) {
             return response()->json(['status' => 1, 'msg' => 'Product has been successfully updated.']);
         }

         return response()->json(['status' => 0, 'msg' => 'Something went wrong.']);
     }

 public function deleteProduct(Request $request)
{
    $product = Product::findOrFail($request->product_id);

    $path = 'images/products/';
    $product_image = $product->product_image;

    if ($product_image != null && File::exists(public_path($path . $product_image))) {
        File::delete(public_path($path . $product_image));
    }
    CartDetail::where('product_id', $product->id)->delete();
    OrderDetail::where('product_id', $product->id)->delete();
    $delete = $product->delete();

    if ($delete) {
        return response()->json(['status' => 1, 'msg' => 'Product and related data have been successfully deleted.']);
    } else {
        return response()->json(['status' => 0, 'msg' => 'Something went wrong.']);
    }
}

    public function show($id)
    {
        // $product = Product::findOrFail($id);
        $product = Product::findOrFail($id);
        $relatedProducts = Product::inRandomOrder()->where('seller_id', $product->seller_id)
                                ->where('id', '!=', $product->id)
                                ->take(6)
                                ->get();
        $shop = Shop::where('seller_id', $product->seller_id)->first();
        return view('front.page.product-detail', compact('product', 'relatedProducts','shop'));

    }


    public function search(Request $request)
{
    $searchTerm = $request->input('query'); // Get the search term from the query parameter

    // Search for products matching the term
    $products = Product::where('name', 'LIKE', '%' . $searchTerm . '%')
                ->where('visibility', 1) // Assuming visibility = 1 means the product is visible
                ->paginate(9); // Adjust pagination as needed

    // Search for shops matching the term
    $shops = Shop::where('shop_name', 'LIKE', '%' . $searchTerm . '%')->get();

    return view('front.page.search_results', compact('products', 'shops', 'searchTerm'));
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
        $products = $query->where('visibility', 1)->paginate(9);

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

    $products = Product::where('category', $id)
        ->where('visibility', 1)
        ->paginate(9);

    return view('front.page.category_search_results', compact('products', 'category'));
}



}
