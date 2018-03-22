<?php

use Faker\Generator as Faker;

$factory->define(\App\Product::class, function (Faker $faker) {
    return [
        'title' => 'titulo',
        'description' => 'Este es un gran producto.',
        'photo' => '/imagen/algo',
        'code' => '12345678',
        'sku' => '12345678',
        'volume' => '0',
        'weight' => '0',
        'price' => '100',
        'cost' => '90',
        'condition' => 'new',  // Terminado, matería prima, o ambas
        'days_to_deliver' => '2',
//        'category_id' => '1',  // habrá categorias
        'unit_of_measure' => 'piece',  // pieza, metros, cosas de esas
        'available_quantity' => $faker->numberBetween(0, 100)
    ];
});
