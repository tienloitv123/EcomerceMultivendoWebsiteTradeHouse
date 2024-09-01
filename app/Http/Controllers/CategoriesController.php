<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Category;
use \Cviebrock\EloquentSluggable\Services\SlugService;


class CategoriesController extends Controller
{
   public function catSubcatList(Request $request){
        $data = [
            'pageTitle'=>'Categories & Sub categories management'
        ];
        return view('back.page.admin.cats-subcats-list',$data);
    }

    public function addCategory(Request $request){
        $data = [
            'pageTitle'=>'Add Category'
        ];
        return view('back.page.admin.add-category',$data);
    }


    public function storeCategory(Request $request){
        //VALIDATE THE FORM
        $request->validate([
            'category_name'=>'required|min:5|unique:categories,category_name',
            'category_image'=>'required|image|mimes:png,jpg,jpeg,svg',
        ],[
            'category_name.required'=>':Attribute is required',
            'category_name.min'=>':Attribute must contains atleast 5 characters',
            'category_name.unique'=>'This :attribute is already exists',
            'category_image.required'=>':Attribute is required',
            'category_image.image'=>':Attribute must be an image',
            'category_image.mimes'=>':Attribute must be in JPG,JPEG,PNG or SVG format'
        ]);

        if( $request->hasFile('category_image') ){
            $path = 'images/categories/';
            $file = $request->file('category_image');
            $filename = time().'_'.$file->getClientOriginalName();

            if(!File::exists(public_path($path))){
                File::makeDirectory(public_path($path));
            }

            //Upload category image
            $upload = $file->move(public_path($path),$filename);

            if($upload){
                //Save category into Database
                $category = new Category();
                $category->category_name = $request->category_name;
                $category->category_image = $filename;
                $saved = $category->save();

                if( $saved ){
                    return redirect()->route('admin.manage-categories.add-category')->with('success','<b>'.ucfirst($request->category_name).'</b> category has been successfully added.');
                }else{
                    return redirect()->route('admin.manage-categories.add-category')->with('fail','Something went wrong. Try again later.');
                }
            }else{
                return redirect()->route('admin.manage-categories.add-category')->with('fail','Something went wrong while uploading category image.');
            }
        }
    }

    public function editCategory(Request $request){
        $category_id = $request->id;
        $category = Category::findOrFail($category_id);
        $data = [
            'pageTitle'=>'Edit Category',
            'category'=>$category
        ];
        return view('back.page.admin.edit-category',$data);
    }

    public function updateCategory(Request $request){
        $category_id = $request->category_id;
        $category = Category::findOrFail($category_id);

        //VALIDATE THE FORM
        $request->validate([
            'category_name'=>'required|min:5|unique:categories,category_name,'.$category_id,
            'category_image'=>'nullable|image|mimes:png,jpg,jpeg,svg',
        ],[
            'category_name.required'=>':Attribute is required',
            'category_name.min'=>':Attribute must contains atleast 5 characters',
            'category_name.unique'=>'This :attribute is already exists',
            'category_image.image'=>':Attribute must be an image',
            'category_image.mimes'=>':Attribute must be in JPG,JPEG,PNG or SVG format'
        ]);

        if( $request->hasFile('category_image') ){
            $path = 'images/categories/';
            $file = $request->file('category_image');
            $filename = time().'_'.$file->getClientOriginalName();
            $old_category_image = $category->category_image;

            //Upload new category image
            $upload = $file->move(public_path($path),$filename);

            if( $upload ){
                 //Delete old category image
                 if( File::exists(public_path($path.$old_category_image)) ){
                    File::delete(public_path($path.$old_category_image));
                 }
                 //Update category info
                 $category->category_name = $request->category_name;
                 $category->category_image = $filename;
                 $category->category_slug = null;
                 $saved = $category->save();

                 if( $saved ){
                    return redirect()->route('admin.manage-categories.edit-category',['id'=>$category_id])->with('success','<b>'.ucfirst($request->category_name).'</b> category has been updated.');
                 }else{
                    return redirect()->route('admin.manage-categories.edit-category',['id'=>$category_id])->with('fail','Something went wrong.');
                 }
            }else{
                return redirect()->route('admin.manage-categories.edit-category',['id'=>$category_id])->with('fail','Error in uploading category image.');
            }

        }else{
            //Update category Info
            $category->category_name = $request->category_name;
            $category->category_slug = null;
            $saved = $category->save();

            if( $saved ){
                return redirect()->route('admin.manage-categories.edit-category',['id'=>$category_id])->with('success','<b>'.ucfirst($request->category_name).'</b> category has been updated.');
            }else{
                return redirect()->route('admin.manage-categories.edit-category',['id'=>$category_id])->with('fail','Something went wrong. Try again later.');
            }
        }
    }

}
