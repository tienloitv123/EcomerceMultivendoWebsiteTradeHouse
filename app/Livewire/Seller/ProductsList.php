<?php

namespace App\Livewire\Seller;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsList extends Component
{
    use WithPagination;

    public $perPage = 10;

    public function render()
    {
        $products = Product::where('user_type', 'seller')
                            ->where('seller_id', auth()->id())
                            ->where('visibility', 1) 
                            ->latest()
                            ->paginate($this->perPage);

        return view('livewire.seller.products-list', ['products' => $products]);
    }
}
