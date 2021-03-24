<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'code' => $faker->randomNumber(5),
        'name' => $faker->text(10),
        'description' => $faker->text(50),
        'brand_id' => factory(\App\Brand::class)->create()->id,
        'type_id' => factory(\App\Type::class)->create()->id,
        'img' => $faker->imageUrl(100, 100, 'cats')
    ];
});

$factory->afterCreating(Product::class, function ($product, $faker) {
    $type = $product->type;
    $type->brands()->save($product->brand);
});
