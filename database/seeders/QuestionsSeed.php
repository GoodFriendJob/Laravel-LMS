<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\QuestionsOption;

class QuestionsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Question::class, 500)->create()->each(function ($question) {
            $question->options()->saveMany(factory(QuestionsOption::class, 4)->create());
            $question->tests()->attach(rand(1,100));
        });
    }
}
