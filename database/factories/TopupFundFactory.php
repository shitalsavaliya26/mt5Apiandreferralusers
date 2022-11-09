<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\TopupFund;
use Faker\Generator as Faker;

$factory->define(TopupFund::class, function (Faker $faker) {

    return [
        'user_id' => $faker->randomDigitNotNull,
        'amount' => $faker->word,
        'reciept' => $faker->word,
        'status' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
