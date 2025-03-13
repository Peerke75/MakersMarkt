<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'categorie_id', 'name', 'description', 'price', 'image'
    ];

    // Relatie met Categorie
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
}
