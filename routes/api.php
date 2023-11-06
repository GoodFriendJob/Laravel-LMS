<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::group(['prefix' => 'v1','namespace'=>'v1'],function (){


    Route::group([
        'prefix' => 'auth'
    ], function () {

//    Route::post('login', 'ApiController@login');
        Route::post('signup-form', 'ApiController@signupForm');
        Route::post('signup-save', 'ApiController@signup');

        Route::group([
            'middleware' => 'auth:api'
        ], function() {
            Route::post('logout', 'ApiController@logout');

        });
    });

    Route::group(['middleware' => 'auth:api'],function (){
        Route::post('courses','ApiController@getCourses');
        Route::post('bundles','ApiController@getBundles');
        Route::post('search','ApiController@search');
        Route::post('latest-news','ApiController@getLatestNews');
        Route::post('testimonials','ApiController@getTestimonials');
        Route::post('teachers','ApiController@getTeachers');
        Route::post('single-teacher','ApiController@getSingleTeacher');
        Route::post('teacher-courses','ApiController@getTeacherCourses');
        Route::post('teacher-bundles','ApiController@getTeacherBundles');
        Route::post('get-faqs','ApiController@getFaqs');
        Route::post('why-us','ApiController@getWhyUs');
        Route::post('sponsors','ApiController@getSponsors');
        Route::post('contact-us','ApiController@saveContactUs');
        Route::post('single-course','ApiController@getSingleCourse');
        Route::post('submit-review','ApiController@submitReview');
        Route::post('update-review','ApiController@updateReview');
        Route::post('single-lesson','ApiController@getLesson');
        Route::post('single-live-lesson','ApiController@getLiveLesson');
        Route::post('booked-lesson-slot','ApiController@bookedSlot');
        Route::post('single-test','ApiController@getTest');
        Route::post('save-test','ApiController@saveTest');
        Route::post('video-progress','ApiController@videoProgress');
        Route::post('course-progress','ApiController@courseProgress');
        Route::post('generate-certificate','ApiController@generateCertificate');
        Route::post('single-bundle','ApiController@getSingleBundle');
        Route::post('add-to-cart','ApiController@addToCart');
        Route::post('getnow','ApiController@getNow');
        Route::post('remove-from-cart','ApiController@removeFromCart');
        Route::post('get-cart-data','ApiController@getCartData');
        Route::post('clear-cart','ApiController@clearCart');
        Route::post('payment-status','ApiController@paymentStatus');
        Route::post('get-blog','ApiController@getBlog');
        Route::post('blog-by-category','ApiController@getBlogByCategory');
        Route::post('blog-by-tag','ApiController@getBlogByTag');
        Route::post('add-blog-comment','ApiController@addBlogComment');
        Route::post('delete-blog-comment','ApiController@deleteBlogComment');
        Route::post('forum','ApiController@getForum');
        Route::post('create-discussion','ApiController@createDiscussion');
        Route::post('store-response','ApiController@storeResponse');
        Route::post('update-response','ApiController@updateResponse');
        Route::post('delete-response','ApiController@deleteResponse');
        Route::post('messages','ApiController@getMessages');
        Route::post('compose-message','ApiController@composeMessage');
        Route::post('reply-message','ApiController@replyMessage');
        Route::post('unread-messages','ApiController@getUnreadMessages');
        Route::post('search-messages','ApiController@searchMessages');
        Route::post('my-certificates','ApiController@getMyCertificates');
        Route::post('my-purchases','ApiController@getMyPurchases');
        Route::post('my-account','ApiController@getMyAccount');
        Route::post('update-account','ApiController@updateMyAccount');
        Route::post('update-password','ApiController@updatePassword');
        Route::post('get-page','ApiController@getPage');
        Route::post('subscribe-newsletter','ApiController@subscribeNewsletter');
        Route::post('offers','ApiController@getOffers');
        Route::post('apply-coupon','ApiController@applyCoupon');
        Route::post('remove-coupon','ApiController@removeCoupon');
        Route::post('order-confirmation','ApiController@orderConfirmation');
        Route::post('single-user','ApiController@getSingleUser');
        Route::post('subscription-plans','ApiController@subscriptionsPlans');
        Route::post('my-subscription', 'ApiController@mySubscription');
        Route::post('subscribed','ApiController@subscribeBundleOrCourse');
        Route::post('subscribed','ApiController@subscribeBundleOrCourse');
        Route::post('add-to-wishlist','ApiController@addToWishlist');
        Route::post('wishlist','ApiController@wishlist');
    });
    Route::post('send-reset-link','ApiController');
    Route::post('configs','ApiController@getConfigs');
});

