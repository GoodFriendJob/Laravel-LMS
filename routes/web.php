<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\PdfController;
/*
 * Global Routes
 * Routes that are used between both frontend and backend.
 */
 
// Route::get('/', function(){dd('My Skype Name is live:.cid.325e7b40026bbaf7   .   Lets speak by skype.  I will remove this in 5 minutes.');});


Route::get('/clear-cache', function() {
    $exitCode = \Illuminate\Support\Facades\Artisan::call('cache:clear');
    $exitCode1 = \Illuminate\Support\Facades\Artisan::call('view:clear');
    $exitCode2 = \Illuminate\Support\Facades\Artisan::call('route:clear');
    return "cache cleard";
    // return what you want
 });

// store pdf to server
Route::post('pdf/store', [PdfController::class, 'store']);
Route::post('pdf/generate-pdf', 'PdfController@generatePDF')->name('generate-pdf');




// Switch between the included languages
Route::get('lang/{lang}', [LanguageController::class, 'swap'])->name('languageselect');
;


Route::get('/sitemap-' .str_slug(config('app.name')) . '/{file?}', 'SitemapController@index');


//============ Remove this  while creating zip for Envato ===========//

/*This command is useful in demo site you can go to https://demo.neonlms.com/reset-demo and it will refresh site from this URL. */

Route::get('reset-demo',function (){
    ini_set('memory_limit', '-1');
    ini_set('max_execution_time', 1000);
    try{
        \Illuminate\Support\Facades\Artisan::call('refresh:site');
        return 'Refresh successful!';
    }catch (\Exception $e){
        return $e->getMessage();
    }
});
//===================================================================//




/*
 * Frontend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    include_route_files(__DIR__ . '/frontend/');
});

/*
 * Backend Routes
 * Namespaces indicate folder structure
 */

Route::post('user/questions/store','Backend\Admin\QuestionsController@store')->name('user.questions.store');
Route::post('user/questions/update','Backend\Admin\QuestionsController@update')->name('user.questions.update');
Route::get('user/questions/get_info','Backend\Admin\QuestionsController@get_info');
Route::get('user/questions/order-edit','Backend\Admin\QuestionsController@order_edit')->name('user.questions.order-edit');
Route::post('user/questions/upload-images','Backend\Admin\QuestionsController@upload_images');
Route::post('user/questions/user-upload-images','Backend\Admin\QuestionsController@user_upload_images')->name('user_upload_images');
Route::post('user/questions/get-test-default','Backend\Admin\QuestionsController@get_test_default')->name('get_test_default');

Route::post('user/questions/page-update','Backend\Admin\QuestionsController@page_update')->name('admin.questions.page-update');
Route::any('user/questions/editor_fileupload','Backend\Admin\QuestionsController@editorFileUpload')->name('admin.questions.editor_fileupload');

Route::get('lesson/store_answer','LessonsController@store_answer')->name('lesson.store_answer');
Route::get('lesson/get_answer','LessonsController@get_answer');
Route::post('lesson/get_answers_fill','LessonsController@get_answers_fill');
Route::post('lesson/get_report','LessonsController@get_report');
Route::post('lesson/update_report','LessonsController@update_report');
Route::post('lesson/user-upload-files','LessonsController@user_upload_files')->name('user_upload_files');
Route::post('lesson/updateprofilepic','LessonsController@updateprofilepic');
Route::post('lesson/delete_file', 'LessonsController@delete_file');
Route::get('lesson/get_chart_options','LessonsController@get_chart_options');// add rgc

Route::get('user/textgroups/get_info','Backend\Admin\TextGroupsController@get_info');
Route::post('user/textgroups/store','Backend\Admin\TextGroupsController@store');
Route::post('user/textgroups/update','Backend\Admin\TextGroupsController@update');
// Route::get('user/get-textgroups-data','Backend\Admin\TextGroupsControllers@getData');

Route::get('user/charts/get_info','Backend\Admin\ChartsController@get_info');
Route::get('user/charts/get_table','Backend\Admin\ChartsController@get_table');
Route::get('user/charts/get_score','Backend\Admin\ChartsController@get_score');
Route::get('user/charts/get_chart','Backend\Admin\ChartsController@get_chart');
Route::post('user/charts/save_chart','Backend\Admin\ChartsController@save_chart');// add rgc
Route::get('user/charts/get_chart_options','Backend\Admin\ChartsController@get_chart_options');// add rgc
Route::post('user/charts/chart_store','Backend\Admin\ChartsController@store');//add ckd
Route::post('user/charts/update','Backend\Admin\ChartsController@update');

Route::get('user/testreports/get_code','Backend\Admin\TestReportsController@get_code');
Route::get('user/testreports/get_info','Backend\Admin\TestReportsController@get_info');
Route::post('user/testreports/store','Backend\Admin\TestReportsController@store');
Route::post('user/testreports/update','Backend\Admin\TestReportsController@update');
Route::get('tests/order-edit','Backend\Admin\TestsController@order_edit')->name('admin.tests.order-edit');
Route::get('user/testreports/studentreport','Backend\Admin\TestReportsController@student_report');

Route::post('ckeditor/image_upload', 'CKEditorController@upload')->name('ckeditor.image-upload');

Route::group(['namespace' => 'Backend', 'prefix' => 'user', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    include_route_files(__DIR__ . '/backend/');    
});

Route::group(['namespace' => 'Backend', 'prefix' => 'user', 'as' => 'admin.', 'middleware' => 'auth'], function () {

//==== Messages Routes =====//
    Route::get('messages', ['uses' => 'MessagesController@index', 'as' => 'messages']);
    Route::post('messages/unread', ['uses' => 'MessagesController@getUnreadMessages', 'as' => 'messages.unread']);
    Route::post('messages/send', ['uses' => 'MessagesController@send', 'as' => 'messages.send']);
    Route::post('messages/reply', ['uses' => 'MessagesController@reply', 'as' => 'messages.reply']);
});


Route::get('category/{category}/blogs', 'BlogController@getByCategory')->name('blogs.category');
Route::get('tag/{tag}/blogs', 'BlogController@getByTag')->name('blogs.tag');
Route::get('blog/{slug?}', 'BlogController@getIndex')->name('blogs.index');
Route::post('blog/{id}/comment', 'BlogController@storeComment')->name('blogs.comment');
Route::get('blog/comment/delete/{id}', 'BlogController@deleteComment')->name('blogs.comment.delete');

Route::get('teachers', 'Frontend\HomeController@getTeachers')->name('teachers.index');
Route::get('teachers/{id}/show', 'Frontend\HomeController@showTeacher')->name('teachers.show');


Route::post('newsletter/subscribe', 'Frontend\HomeController@subscribe')->name('subscribe');

//============Course Routes=================//
Route::get('courses', ['uses' => 'CoursesController@all', 'as' => 'courses.all']);
Route::get('course/{slug}', ['uses' => 'CoursesController@show', 'as' => 'courses.show'])->middleware('subscribed');
// Route::get('coursetest/{slug}', ['uses' => 'CoursesController@showtest', 'as' => 'courses.showtest'])->middleware('subscribed');
//Route::post('course/payment', ['uses' => 'CoursesController@payment', 'as' => 'courses.payment']);
Route::post('course/{course_id}/rating', ['uses' => 'CoursesController@rating', 'as' => 'courses.rating']);
Route::get('courses/order-edit','Backend\Admin\CoursesController@order_edit')->name('admin.courses.order-edit');
Route::get('category/{category}/courses', ['uses' => 'CoursesController@getByCategory', 'as' => 'courses.category']);
Route::post('courses/{id}/review', ['uses' => 'CoursesController@addReview', 'as' => 'courses.review']);
Route::get('courses/review/{id}/edit', ['uses' => 'CoursesController@editReview', 'as' => 'courses.review.edit']);
Route::post('courses/review/{id}/edit', ['uses' => 'CoursesController@updateReview', 'as' => 'courses.review.update']);
Route::get('courses/review/{id}/delete', ['uses' => 'CoursesController@deleteReview', 'as' => 'courses.review.delete']);


//============= Drop All DB data =============//

Route::get('lesson/drop','LessonsController@drop');
Route::get('lesson/order-edit','Backend\Admin\LessonsController@reorderLesson')->name('admin.lesson.order-edit');
//============Bundle Routes=================//
Route::get('bundles', ['uses' => 'BundlesController@all', 'as' => 'bundles.all']);
Route::get('bundle/{slug}', ['uses' => 'BundlesController@show', 'as' => 'bundles.show']);
//Route::post('course/payment', ['uses' => 'CoursesController@payment', 'as' => 'courses.payment']);
Route::post('bundle/{bundle_id}/rating', ['uses' => 'BundlesController@rating', 'as' => 'bundles.rating']);
Route::get('category/{category}/bundles', ['uses' => 'BundlesController@getByCategory', 'as' => 'bundles.category']);
Route::post('bundles/{id}/review', ['uses' => 'BundlesController@addReview', 'as' => 'bundles.review']);
Route::get('bundles/review/{id}/edit', ['uses' => 'BundlesController@editReview', 'as' => 'bundles.review.edit']);
Route::post('bundles/review/{id}/edit', ['uses' => 'BundlesController@updateReview', 'as' => 'bundles.review.update']);
Route::get('bundles/review/{id}/delete', ['uses' => 'BundlesController@deleteReview', 'as' => 'bundles.review.delete']);


Route::group(['middleware' => 'auth'], function () {
    Route::get('lesson/{course_id}/{slug}/', ['uses' => 'LessonsController@show', 'as' => 'lessons.show']);
    Route::post('lesson/{slug}/test', ['uses' => 'LessonsController@test', 'as' => 'lessons.test']);
    Route::post('lesson/{slug}/retest', ['uses' => 'LessonsController@retest', 'as' => 'lessons.retest']);
    Route::post('video/progress', 'LessonsController@videoProgress')->name('update.videos.progress');
    Route::post('lesson/progress', 'LessonsController@courseProgress')->name('update.course.progress');
    Route::post('lesson/book-slot','LessonsController@bookSlot')->name('lessons.course.book-slot');

    // pdf 
    Route::get('pdf/{course_id}/{slug}/', ['uses' => 'PdfController@show', 'as' => 'pdf.show']);
    Route::post('pdf/get_answers_fill','PdfController@get_answers_fill');

    // reports
    Route::get('pdfreport/{course_id}/{slug}/', ['uses' => 'PdfController@showreport', 'as' => 'pdf.showreport']);
    Route::post('pdfreport/get_answers_fill','PdfController@get_answers_fill_report');
    Route::post('pdfreport/get_report','PdfController@get_report');

});

Route::get('/search', [HomeController::class, 'searchCourse'])->name('search');
Route::get('/search-course', [HomeController::class, 'searchCourse'])->name('search-course');
Route::get('/search-bundle', [HomeController::class, 'searchBundle'])->name('search-bundle');
Route::get('/search-blog', [HomeController::class, 'searchBlog'])->name('blogs.search');


Route::get('/faqs', 'Frontend\HomeController@getFaqs')->name('faqs');


/*=============== Theme blades routes ends ===================*/


Route::get('contact', 'Frontend\ContactController@index')->name('contact');
Route::post('contact/send', 'Frontend\ContactController@send')->name('contact.send');


Route::get('download', ['uses' => 'Frontend\HomeController@getDownload', 'as' => 'download']);

Route::group(['middleware' => 'auth'], function () {
    Route::post('cart/checkout', ['uses' => 'CartController@checkout', 'as' => 'cart.checkout']);
    Route::post('cart/add', ['uses' => 'CartController@addToCart', 'as' => 'cart.addToCart']);
    Route::get('cart', ['uses' => 'CartController@index', 'as' => 'cart.index']);
    Route::get('cart/clear', ['uses' => 'CartController@clear', 'as' => 'cart.clear']);
    Route::get('cart/remove', ['uses' => 'CartController@remove', 'as' => 'cart.remove']);
    Route::post('cart/apply-coupon',['uses' => 'CartController@applyCoupon','as'=>'cart.applyCoupon']);
    Route::post('cart/remove-coupon',['uses' => 'CartController@removeCoupon','as'=>'cart.removeCoupon']);
    Route::post('cart/stripe-payment', ['uses' => 'CartController@stripePayment', 'as' => 'cart.stripe.payment']);
    Route::post('cart/paypal-payment', ['uses' => 'CartController@paypalPayment', 'as' => 'cart.paypal.payment']);
    Route::get('cart/paypal-payment/status', ['uses' => 'CartController@getPaymentStatus'])->name('cart.paypal.status');

    Route::post('cart/instamojo-payment',['uses' => 'CartController@instamojoPayment', 'as' => 'cart.instamojo.payment']);
    Route::get('cart/instamojo-payment/status', ['uses' => 'CartController@getInstamojoStatus'])->name('cart.instamojo.status');

    Route::post('cart/razorpay-payment',['uses' => 'CartController@razorpayPayment', 'as' => 'cart.razorpay.payment']);
    Route::post('cart/razorpay-payment/status', ['uses' => 'CartController@getRazorpayStatus'])->name('cart.razorpay.status');

    Route::post('cart/cashfree-payment',['uses' => 'CartController@cashfreeFreePayment', 'as' => 'cart.cashfree.payment']);
    Route::post('cart/cashfree-payment/status', ['uses' => 'CartController@getCashFreeStatus'])->name('cart.cashfree.status');

    Route::post('cart/payu-payment',['uses' => 'CartController@payuPayment', 'as' => 'cart.payu.payment']);
    Route::post('cart/payu-payment/status', ['uses' => 'CartController@getPayUStatus'])->name('cart.pauy.status');

    Route::match(['GET','POST'],'cart/flutter-payment',['uses' => 'CartController@flatterPayment', 'as' => 'cart.flutter.payment']);
    Route::get('cart/flutter-payment/status',['uses' => 'CartController@getFlatterStatus', 'as' => 'cart.flutter.status']);

    Route::get('status', function () {
        return view('frontend.cart.status');
    })->name('status');
    Route::post('cart/offline-payment', ['uses' => 'CartController@offlinePayment', 'as' => 'cart.offline.payment']);
    Route::post('cart/getnow',['uses'=>'CartController@getNow','as' =>'cart.getnow']);
});

//============= Menu  Manager Routes ===============//
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'middleware' => config('menu.middleware')], function () {
    //Route::get('wmenuindex', array('uses'=>'\Harimayco\Menu\Controllers\MenuController@wmenuindex'));
    Route::post('add-custom-menu', 'MenuController@addcustommenu')->name('haddcustommenu');
    Route::post('delete-item-menu', 'MenuController@deleteitemmenu')->name('hdeleteitemmenu');
    Route::post('delete-menug', 'MenuController@deletemenug')->name('hdeletemenug');
    Route::post('create-new-menu', 'MenuController@createnewmenu')->name('hcreatenewmenu');
    Route::post('generate-menu-control', 'MenuController@generatemenucontrol')->name('hgeneratemenucontrol');
    Route::post('update-item', 'MenuController@updateitem')->name('hupdateitem');
    Route::post('save-custom-menu', 'MenuController@saveCustomMenu')->name('hcustomitem');
    Route::post('change-location', 'MenuController@updateLocation')->name('update-location');
});

Route::get('certificate-verification','Backend\CertificateController@getVerificationForm')->name('frontend.certificates.getVerificationForm');
Route::post('certificate-verification','Backend\CertificateController@verifyCertificate')->name('frontend.certificates.verify');
Route::get('certificates/download', ['uses' => 'Backend\CertificateController@download', 'as' => 'certificates.download']);


if(config('show_offers') == 1){
    Route::get('offers',['uses' => 'CartController@getOffers', 'as' => 'frontend.offers']);
}

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth','role:teacher|administrator']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::group(['prefix' => 'subscription'], function(){
    Route::get('plans', 'SubscriptionController@plans')->name('subscription.plans');
    Route::get('/{plan}/{name}', 'SubscriptionController@showForm')->name('subscription.form');
    Route::post('subscribe/{plan}', 'SubscriptionController@subscribe')->name('subscription.subscribe');
    Route::post('update/{plan}', 'SubscriptionController@updateSubscription')->name('subscription.update');
    Route::get('status','SubscriptionController@status')->name('subscription.status');
    Route::post('subscribe','SubscriptionController@courseSubscribed')->name('subscription.course_subscribe');
});


// wishlist
Route::post('add-to-wishlist','Backend\WishlistController@store')->name('add-to-wishlist');

Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    Route::get('/{page?}', [HomeController::class, 'index'])->name('index');
});



// Route::post('add-to-wishlist','Backend\Admin\QuestionsController@store')->name('add-to-wishlist');
Route::get('/pp', function(){dd('Hello World');});
Route::get('user/questions-help','LessonsController@getUserHelp')->name('user.get-help');
Route::get('user/questions-model-help','LessonsController@getUserForModelHelp')->name('user.get-help-model');
Route::any('user/ckeditor_fileupload','Backend\Admin\DashboardController@CKEditorFileUpload')->name('admin.ckeditor_fileupload');
Route::get('user/questions-graph','LessonsController@getQustionGraph')->name('user.get-graph');


