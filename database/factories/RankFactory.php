<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Rank;
use Faker\Generator as Faker;

$factory->define(Rank::class, function (Faker $faker) {

    return [
        'name' => $faker->word,
        'own_package' => $faker->word,
        'direct_sale' => $faker->word,
        'downline' => $faker->word,
        'direct_downline' => $faker->word,
        'total_downline' => $faker->word,
        'pipes_commison' => $faker->word,
        'package_overriding' => $faker->word,
        'leader_bonus' => $faker->word,
        'profit_sharing' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
