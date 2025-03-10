<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $fillable = ['name'];

    // Relatie met Products
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
