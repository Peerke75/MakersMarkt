<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'description',
        'categorie_id',
        'production_time',
        'material',
        'price',
        'quantity',
        'image',
        'status'
    ];

    // Relatie met Categorie model
    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    // Relatie met Users via UserProduct
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_product');
    }

    // Relatie met OrderLines
    public function orderLines()
    {
        return $this->hasMany(OrderLine::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }


    // Relatie met CartItems
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    
    public function maker()
    {
        return $this->belongsTo(User::class, 'maker_id');
    }
}
