<?php

namespace App\Console\Commands;

use App\Models\Lesson;
use App\Models\Test;
use Illuminate\Console\Command;

class LessonTestChaterStudentsFix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:lesson-test-course';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lessons and Tests remove chapter student table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $lessons = Lesson::onlyTrashed()->get();
        foreach ($lessons as $lesson){
            $lesson->chapterStudents()->where('course_id', $lesson->course_id)->forceDelete();
        }

        $tests = Test::onlyTrashed()->get();
        foreach ($tests as $test){
            $tests->chapterStudents()->where('course_id', $test->course_id)->forceDelete();
        }
    }
}
