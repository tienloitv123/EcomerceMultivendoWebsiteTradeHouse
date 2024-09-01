<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\File;


class AdminCategoriesSubCategoriesList extends Component
{
    protected $listeners = [
        'updateCategoriesOrdering',
        'deleteCategory'
    ];
    public function updateCategoriesOrdering($positions){
        foreach($positions as $position){
            $index = $position[0];
            $newPosition = $position[1];
            Category::where('id',$index)->update([
                'ordering'=>$newPosition
            ]);

            session()->flash('success', 'Categories ordering have been successfully updated.');

        }
    }
    public function deleteCategory($category_id){
        $category = Category::findOrFail($category_id);
        $path = 'images/categories/';
        $category_image = $category->category_image;

        //CHECK IF THIS CATEGORY HAS SUBCATEGORIES
        // if( $category->subcategories->count() > 0 ){
        //     //Check if on of these subcategories has related product(s)

        //     //Delete sub categories
        //     // foreach( $category->subcategories as $subcategory ){
        //     //     $subcategory = SubCategory::findOrFail($subcategory->id);
        //     //     $subcategory->delete();
        //     // }
        // }

        //DELETE CATEGORY IMAGE
        if( File::exists(public_path($path.$category_image)) ){
            File::delete($path.$category_image);
        }

        //DELETE CATEGORY FROM DB
        $delete = $category->delete();

        if( $delete ){
            $this->showToastr('success','Category has been successfully deleted.');
        }else{
            $this->showToastr('error','Something went wrong.');
        }
    }
    public function render()
    {
        return view('livewire.admin-categories-sub-categories-list',[
            'categories'=>Category::orderBy('ordering','asc')->get()
       ]);
    }

    public function showToastr($type, $message){
        return $this->dispatch('showToastr',[
             'type'=>$type,
             'message'=>$message
        ]);
    }
}
