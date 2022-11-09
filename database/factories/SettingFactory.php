<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Setting;
use Faker\Generator as Faker;

$factory->define(Setting::class, function (Faker $faker) {

    return [
        'admin_email' => $faker->word,
        'withdraw_fees' => $faker->word,
        'withdraw_from_day' => $faker->word,
        'withdraw_to_day' => $faker->word,
        'allow_first_withdraw' => $faker->randomDigitNotNull,
        'minimum_withdraw_amount' => $faker->randomDigitNotNull,
        'profit_sharing_commision_l1' => $faker->randomDigitNotNull,
        'profit_sharing_commision_l2' => $faker->randomDigitNotNull,
        'profit_sharing_commision_l3' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
