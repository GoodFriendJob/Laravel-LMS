<?php

use Faker\Generator as Faker;

$factory->define(App\Models\TeacherProfile::class, function (Faker $faker) {
    $paymentDetails = '{"bank_name":"","ifsc_code":"","account_number":"","account_name":"","paypal_email":"adminteacher@demo.com"}';
    return [
        'user_id' => 2,
        'facebook_link' => $faker->url,
        'twitter_link' => $faker->url,
        'linkedin_link' => $faker->url,
        'payment_method' => 'paypal',
        'payment_details' => $paymentDetails
    ];
});
