<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
        // 'name'              => $faker->name,
        // 'email'             => $faker->unique()->safeEmail,
        'name' => 'user',
        'email' => 'user@example.com',
        'nick_name' => $faker->firstName,
        'address' => $faker->address,
        'tel' => $faker->phoneNumber,
        'password' => Hash::make('12345678'),
        'remember_token' => Str::random(10),
    ];
});
