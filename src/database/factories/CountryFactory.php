<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Country;
use Faker\Generator as Faker;

$factory->define(Country::class, function (Faker $faker) {
    return [
        'name' => 'England',
        'label'=> 'england',
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime
    ];
});
