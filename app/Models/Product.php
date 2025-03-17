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
        'image'
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
}
