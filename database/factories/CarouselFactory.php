<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Carousel;
use Faker\Generator as Faker;

$factory->define(Carousel::class, function (Faker $faker) {
    return [
        'item_name' => $faker->name,
        'item_description' => $faker->realText(50),
        'item_image' => $faker->imageUrl(1200, 500, 'cats')
    ];
});
