<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Router;
use Faker\Generator as Faker;

$factory->define(Router::class, function (Faker $faker) {
    return [
        'sapId' => $faker->sentence,
        'hostname' => $faker->sentence,
        'loopback' => $faker->sentence,
        'mac_address' => $faker->sentence,
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});
