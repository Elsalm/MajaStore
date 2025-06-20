<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'status',
        'stripe_id',
    ];

    public function products()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function user()
    {

        return $this->belongsTo(User::class);
    }
}
