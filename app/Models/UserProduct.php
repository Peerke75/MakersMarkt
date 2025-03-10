<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProduct extends Model
{
    protected $fillable = ['user_id', 'product_id'];

    // Relatie met User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relatie met Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
