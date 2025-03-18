<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['maker_id', 'koper_id', 'completed_at', 'status', 'status_message', 'total_price'];

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

    public function buyer()
    {
        return $this->belongsTo(User::class, 'koper_id', 'id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'maker_id', 'id');
    }

    public function getTotalPriceAttribute($value)
    {
        return '€ ' . number_format($value, 2);
    }

}
