<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Admin;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

$factory->define(Admin::class, function (Faker $faker) {
    return [
        'name'              => "admin",
        'email'             => "admin@example.com",
        'password'          => Hash::make('12345678'),
        'remember_token'    => Str::random(10),
    ];
});
