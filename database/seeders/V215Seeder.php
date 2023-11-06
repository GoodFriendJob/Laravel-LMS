<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class V215Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ini_set('memory_limit', '-1');

        $configData = \App\Models\Config::where('key','=','sitemap.chunk')->first();
        if($configData == null){
            $configData = new \App\Models\Config();
        }
        $configData->key = 'sitemap.chunk';
        $configData->value = 100;
        $configData->save();

        $configData = \App\Models\Config::where('key','=','sitemap.schedule')->first();
        if($configData == null){
            $configData = new \App\Models\Config();
        }
        $configData->key = 'sitemap.schedule';
        $configData->value = 3;
        $configData->save();

        $configData = \App\Models\Config::where('key','=','show_offers')->first();
        if($configData == null){
            $configData = new \App\Models\Config();
        }
        $configData->key = 'show_offers';
        $configData->value = 0;
        $configData->save();

        $chunk = (config('sitemap.chunk') ? config('sitemap.chunk') : 100);
        \Illuminate\Support\Facades\Artisan::call('generate:sitemap', ['--chunk' => $chunk]);
    }
}
