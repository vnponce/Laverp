<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'name',
        'address'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity');
    }
}
