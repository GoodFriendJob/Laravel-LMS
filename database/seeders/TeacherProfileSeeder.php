<?php

namespace Database\Seeders;

use App\Models\TeacherProfile;
use Illuminate\Database\Seeder;

class TeacherProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(TeacherProfile::class, 1)->create();
    }
}
