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
$factory->define(App\Models\Bundle::class, function (Faker\Generator $faker) {
    $name = $faker->sentence(5);
    $placeholder = ['placeholder-1.jpg','placeholder-2.jpg','placeholder-3.jpg'];
    return [
        'title' => $name,
        'category_id' => rand(1,10),
        'slug' => str_slug($name),
        'course_image' =>$placeholder[rand(0,2)],
        'description' => $faker->text(),
        'price' => $faker->randomFloat(2, 0, 199),
        'featured' => array_random([0,1]),
        'trending' => array_random([0,1]),
        'popular' => array_random([0,1]),
        'published' => 1,
    ];
});
