<?php

namespace App\Console\Commands;

use App\Models\TeacherProfile;
use Illuminate\Console\Command;

class TeacherProfileFix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:teacher-profile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will generate profile for existing teachers';

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
        $teachers = \App\Models\Auth\User::role('teacher')->get();
        foreach ($teachers as $teacher) {
            if (!$teacher->teacherProfile) {
                $profile = new TeacherProfile();
                $profile->user_id = $teacher->id;
                $profile->payment_method = 'paypal';
                $profile->payment_details = '{"bank_name":null,"ifsc_code":null,"account_number":null,"account_name":null,"paypal_email":"'.$teacher->email.'"}';
                $profile->save();
            }
        }
    }
}
