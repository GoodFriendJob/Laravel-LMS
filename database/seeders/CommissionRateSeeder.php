<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CommissionRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $config = \App\Models\Config::where('key','=','commission_rate')->first();
       if($config == null){
           $config = new \App\Models\Config();
           $config->key = 'commission_rate';
           $config->value = 0;
           $config->save();
       }
    }
}
