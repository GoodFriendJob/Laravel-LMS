<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Test::class, function (Faker\Generator $faker) {
    $title = $faker->text(30);
    $slug = str_slug($title);
    return [
        'title' => $title,
        'description' => $faker->paragraph(10),
        'slug' => $slug,
        'published' => 1,
    ];
});
