<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'description',
        'photo',
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
}
