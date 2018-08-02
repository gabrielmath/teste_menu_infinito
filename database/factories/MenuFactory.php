<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Menu::class, function (Faker $faker) {
    return [
        'nome' => $faker->word,
    ];
});
