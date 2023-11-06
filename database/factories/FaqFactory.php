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
$factory->define(App\Models\Faq::class, function (Faker\Generator $faker) {
    $question = $faker->sentence($nbWords = 6, $variableNbWords = true) . '?';
    $answer = $faker->paragraph($nbSentences = 3, $variableNbSentences = true);
    return [
        'category_id' => rand(1, 6),
        'question' => $question,
        'answer' => $answer
    ];
});
