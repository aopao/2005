<?php

use Faker\Generator as Faker;

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
$factory->define(App\Entities\Admin::class, function (Faker $faker) {

    return [
        'mobile' => '18678199939',
        'password' => 'admin',
        'uuid' => '11',
        'nickname' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'remember_token' => str_random(10),
    ];
});
