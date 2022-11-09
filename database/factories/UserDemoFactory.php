<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\UserDemo;
use Faker\Generator as Faker;

$factory->define(UserDemo::class, function (Faker $faker) {

    return [
        'name' => $faker->word,
        'email' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
