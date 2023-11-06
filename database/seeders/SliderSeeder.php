<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $slide_1 = [
            'name' => 'Slide 1',
            'content' => '{"hero_text":"Inventive Solution for Education","sub_text":"Education and Training Organization","buttons":[{"label":"Our Courses","link":"http://laravel-lms.test/courses"}]}',
            'bg_image' => 'slider-1.jpg',
            'sequence' => 1,
            'status' => 1,
            'overlay' => 0,
        ];

        $slide_2 = [
            'name' => 'Slide 2',
            'content' => '{"hero_text":"Browse The Best Courses","sub_text":"Education and Training Organization","widget":{"type":1}}',
            'bg_image' => 'slider-2.jpg',
            'sequence' => 2,
            'status' => 1,
            'overlay' => 0,
        ];

        $slide_3 = [
            'name' => 'Slide 3',
            'content' => '{"hero_text":"Mobile Application Experiences : Mobile App Design","sub_text":"","widget":{"type":2,"timer":"2019/02/15 11:01"},"buttons":[{"label":"About Us","link":"http://laravel-lms.test/about-us"},{"label":"Contact Us","link":"http://laravel-lms.test/contact-us"}]}',
            'bg_image' => 'slider-3.jpg',
            'sequence' => 3,
            'status' => 1,
            'overlay' => 0,
        ];

      \App\Models\Slider::firstOrCreate($slide_1);
      \App\Models\Slider::firstOrCreate($slide_2);
      \App\Models\Slider::firstOrCreate($slide_3);
    }
}
