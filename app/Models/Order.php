<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'completed_at', 'status'];

    // Relatie met User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relatie met OrderLines
    public function orderLines()
    {
        return $this->hasMany(OrderLine::class);
    }
}
