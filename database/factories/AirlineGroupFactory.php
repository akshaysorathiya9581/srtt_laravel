<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\AirlineGroup;
use Faker\Generator as Faker;

$factory->define(AirlineGroup::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name,
    ];
});
