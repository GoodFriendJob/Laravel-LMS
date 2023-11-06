<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class V213Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $config = \App\Models\Config::where('key','=','lesson_timer')->first();
       if($config == null){
           $config = new \App\Models\Config();
           $config->key = 'lesson_timer';
           $config->value = 0;
           $config->save();
       }
    }
}
