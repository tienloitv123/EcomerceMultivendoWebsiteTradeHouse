<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_wallet_id',
        'seller_wallet_id',
        'order_id',
        'amount',
        'status',
    ];

    // Define relationships
    public function clientWallet()
    {
        return $this->belongsTo(Wallet::class, 'client_wallet_id');
    }

    public function sellerWallet()
    {
        return $this->belongsTo(Wallet::class, 'seller_wallet_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
