<?php

/** @var Factory $factory */
use App\Models\User;
use App\Models\Country;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'country_id' => factory(Country::class),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => bcrypt('test@123'), // password
        'phone' => '325698236',
        'address' => $faker->address,
        'dob' => $faker->date('Y-m-d'),
        'status' => 'active'
    ];
});
