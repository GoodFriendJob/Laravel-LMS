<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sponsors = [];
        for($i=1; $i<=6; $i++){
            $sponsor = [
                'name' => 'Dummy '.$i,
                'logo' => 's-1.jpg',
                'link' => '#'
            ];
            $sponsors[] = $sponsor;
        }
        \App\Models\Sponsor::insert($sponsors);

    }
}
