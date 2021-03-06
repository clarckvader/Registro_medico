<?php

use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\App;

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
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' =>bcrypt('secret'), // password
        'remember_token' => Str::random(10),
        'ci' => $faker->randomNumber(8,true),
        'address' => $faker->address,
        'phone' => $faker->e164PhoneNumber,
        'role' => $faker -> randomElement(['patient', 'doctor']),
    ];
});



$factory->state(User::class, 'patient', [
    'role' => 'patient'
]);

$factory->state(User::class, 'doctor', [
    'role' => 'doctor'
]);