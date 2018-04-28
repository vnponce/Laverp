<?php

use Faker\Generator as Faker;

$factory->define(\App\Product::class, function (Faker $faker) {
    $price = $faker->numberBetween(1000, 90000);
    $cost = $price - ($price*0.6);
    return [
        'title' => $faker->name,
        'description' => $faker->text,
//        'image' => $faker->imageUrl('300', '200', 'technics'),
        'code' => $faker->numberBetween(00000000, 99999999),
        'sku' => $faker->numberBetween(00000000, 99999999),
        'volume' => $faker->numberBetween(100, 9000),
        'weight' => $faker->numberBetween(100, 9000),
        'price' => $price,
        'cost' => $cost,
        'condition' => 'new',  // Terminado, matería prima, o ambas
        'days_to_deliver' => $faker->numberBetween(0, 10),
//        'category_id' => '1',  // habrá categorias
        'unit_of_measure' => 'piece',  // pieza, metros, cosas de esas
        'available_quantity' => $faker->numberBetween(0, 100)
    ];
});
