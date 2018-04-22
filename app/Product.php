<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'code',
        'sku',
        'volume',
        'weight',
        'price',
        'cost',
        'condition',  // Terminado, matería prima, o ambas
        'days_to_deliver',
        'category_id',  // habrá categorias
        'unit_of_measure_id',  // pieza, metros, cosas de esas
        'available_quantity'
    ];

    public function stores()
    {
        return $this->belongsToMany(Store::class)
            ->withPivot('quantity');
    }
}
