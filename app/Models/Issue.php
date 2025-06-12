<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Issue extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'description',
        'type',
        'product_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
