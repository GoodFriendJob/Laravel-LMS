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
$factory->define(App\Models\Blog::class, function (Faker\Generator $faker,$cat) {
    $name = $faker->text(50);
    return [
        'title' => $name,
        'slug' => str_slug($name),
        'content' => $faker->text(1000),
        'category_id' => rand(1,10),
        'user_id' => 1,
    ];
});
