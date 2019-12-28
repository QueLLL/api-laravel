<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'year_of_writing' => rand(1000, 2000),
        'number_of_pages' => rand(10, 500),
    ];
});
