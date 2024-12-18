<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    use HasFactory;


    protected $fillable = [
        'cart_id',
        'product_id',
        'seller_id',
        'quantity',
        'price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

   
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
