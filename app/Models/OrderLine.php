<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    protected $fillable = ['order_id', 'product_id', 'quantity'];

    // Relatie met Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relatie met Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
