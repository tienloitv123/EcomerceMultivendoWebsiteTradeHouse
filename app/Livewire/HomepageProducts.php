<?php

// app/Http/Livewire/HomepageProducts.php
namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;

class HomepageProducts extends Component
{
    use WithPagination;

    public $perPage = 9;

    public function render()
    {
        return view('livewire.homepage-products', [
            'products' => Product::where('visibility', 1)->paginate($this->perPage),
        ]);
    }
}
