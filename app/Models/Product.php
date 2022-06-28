<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Product extends Model
{
    protected $collection = 'products';

    protected $primaryKey = '_id';

    protected $fillable = [
        'name', 'price', 'quantity', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}