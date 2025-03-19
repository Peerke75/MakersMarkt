<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'maker_id', 'status', 'status_description', 'completed_at'];

    // Relatie met User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relatie met User
    public function maker()
    {
        return $this->belongsTo(User::class, 'maker_id');
    }

    // Relatie met OrderLines
    public function orderLines()
    {
        return $this->hasMany(OrderLine::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
