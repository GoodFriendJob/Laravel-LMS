<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Test;

class CourseSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {

        //Adding Categories
        factory(\App\Models\Category::class, 10)->create()->each(function ($cat) {
            $cat->blogs()->saveMany(factory(\App\Models\Blog::class, 4)->create());

        });

        //Creating Course
        factory(Course::class, 50)->create()->each(function ($course) {

            $course->teachers()->sync([2]);
            $course->lessons()->saveMany(factory(Lesson::class, 10)->create());
            foreach ($course->lessons()->where('published', '=', 1)->get() as $key => $lesson) {
                $key++;
                $timeline = new \App\Models\CourseTimeline();
                $timeline->course_id = $course->id;
                $timeline->model_id = $lesson->id;
                $timeline->model_type = Lesson::class;
                $timeline->sequence = $key;
                $timeline->save();
            };

            $course->tests()->saveMany(factory(Test::class, 2)->create());
            foreach ($course->tests as $key => $test) {
                $key += 11;
                $timeline = new \App\Models\CourseTimeline();
                $timeline->course_id = $course->id;
                $timeline->model_id = $test->id;
                $timeline->model_type = Test::class;
                $timeline->sequence = $key;
                $timeline->save();
            };
        });

        $courses = Course::get()->take(3);

        foreach ($courses as $course) {
            $lesson_id = $course->courseTimeline->where('sequence', '=', 1)->first()->model_id;
            $lesson = Lesson::find($lesson_id);
            $media = \App\Models\Media::where('type', '=', 'upload')
                ->where('model_type', '=', 'App\Models\Lesson')
                ->where('model_id', '=', $lesson->id)
                ->first();
            $filename = 'placeholder-video.mp4';
            $url = asset('storage/uploads/' . $filename);

            if ($media == null) {
                $media = new \App\Models\Media();
                $media->model_type = Lesson::class;
                $media->model_id = $lesson->id;
                $media->name = $filename;
                $media->url = $url;
                $media->type = 'upload';
                $media->file_name = $filename;
                $media->size = 0;
                $media->save();
            }

            $order = new \App\Models\Order();
            $order->user_id = 3;
            $order->reference_no = str_random(8);
            $order->amount = $course->price;
            $order->status = 1;
            $order->save();

            $order->items()->create([
                'item_id' => $course->id,
                'item_type' => get_class($course),
                'price' => $course->price
            ]);
            generateInvoice($order);

            foreach ($order->items as $orderItem) {
                $orderItem->item->students()->attach(3);
            }
        }


        //Creating Bundles
        factory(\App\Models\Bundle::class, 10)->create()->each(function ($bundle) {
            $bundle->user_id = 2;
            $bundle->save();
            $bundle->courses()->sync([ rand(1,50) , rand(1,50) , rand(1,50)  ]);
        });


        $bundles = \App\Models\Bundle::get()->take(2);

        foreach ($bundles as $bundle){
            $order = new \App\Models\Order();
            $order->user_id = 3;
            $order->reference_no = str_random(8);
            $order->amount = $bundle->price;
            $order->status = 1;
            $order->save();

            $order->items()->create([
                'item_id' => $bundle->id,
                'item_type' => get_class($bundle),
                'price' => $bundle->price
            ]);
            generateInvoice($order);

            foreach ($order->items as $orderItem) {
                //Bundle Entries
                if($orderItem->item_type == \App\Models\Bundle::class){
                    foreach ($orderItem->item->courses as $course){
                        $course->students()->attach($order->user_id);
                    }
                }
                $orderItem->item->students()->attach($order->user_id);
            }
        }
    }
}
