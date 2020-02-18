<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\User;
use Faker\Generator as Faker;
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

$func = function ($role_id) {
    return function (Faker $faker) use ($role_id) {
            return [
            'role_id' => $role_id,
            'first_name'  => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => $faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    };
};

$factory->define(User::class, $func(1), 'public');
$factory->define(User::class, $func(2), 'moderator');
$factory->define(User::class, $func(3), 'admin');
$factory->define(User::class, $func(4), 'super_admin');

