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

$factory->define(App\Models\Reason::class, function (Faker\Generator $faker) {
    $title = $faker->sentence(5);
    $content = $faker->paragraph(2);
    $icon = [
        'fab fa-accessible-icon',
        'fab fa-accusoft' ,
        'fas fa-address-book' ,
        'far fa-address-card' ,
        'fas fa-adjust',
        'fab fa-adn',
        'fab fa-adversal',
        'fab fa-affiliatetheme' ,
        'fab fa-algolia' ,
        'fas fa-allergies',
        'fab fa-amazon',
        'fab fa-amazon-pay',
        'fas fa-ambulance',

    ];
    return [
        'title' => $title,
        'content' => $content,
        'icon' => array_random($icon),
        'status' => 1,

    ];
});
