<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;


class AdminCategoriesSubCategoriesList extends Component
{
    public function render()
    {
        return view('livewire.admin-categories-sub-categories-list',[
            'categories'=>Category::orderBy('ordering','asc')->get()
       ]);
    }
}
