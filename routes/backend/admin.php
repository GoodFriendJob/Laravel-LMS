<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\Auth\User\AccountController;
use App\Http\Controllers\Backend\Admin\TimeLimitController;
use App\Http\Controllers\Backend\Auth\User\ProfileController;
use \App\Http\Controllers\Backend\Auth\User\UpdatePasswordController;
use \App\Http\Controllers\Backend\Auth\User\UserPasswordController;
use App\Http\Middleware\LocaleMiddleware;

/*
 * All route names are prefixed with 'admin.'.
 */

//===== General Routes =====//
Route::redirect('/', '/user/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::group(['middleware' => 'role:teacher|administrator'], function () {
    Route::resource('orders', 'Admin\OrderController');
});
Route::group(['middleware' => 'role:administrator'], function () {

    //===== Teachers Routes =====//
    Route::resource('teachers', 'Admin\TeachersController');
    Route::get('get-teachers-data', ['uses' => 'Admin\TeachersController@getData', 'as' => 'teachers.get_data']);
    Route::post('teachers_mass_destroy', ['uses' => 'Admin\TeachersController@massDestroy', 'as' => 'teachers.mass_destroy']);
    Route::post('teachers_restore/{id}', ['uses' => 'Admin\TeachersController@restore', 'as' => 'teachers.restore']);
    Route::delete('teachers_perma_del/{id}', ['uses' =>'Admin\TeachersController@perma_del', 'as' => 'teachers.perma_del']);
    Route::post('teacher/status', ['uses' => 'Admin\TeachersController@updateStatus', 'as' => 'teachers.status']);


    //===== FORUMS Routes =====//
    Route::resource('forums-category', 'Admin\ForumController');
    Route::get('forums-category/status/{id}', 'Admin\ForumController@status')->name('forums-category.status');


    //===== Orders Routes =====//
    Route::get('get-orders-data', ['uses' => 'Admin\OrderController@getData', 'as' => 'orders.get_data']);
    Route::post('orders_mass_destroy', ['uses' => 'Admin\OrderController@massDestroy', 'as' => 'orders.mass_destroy']);
    Route::post('orders/complete', ['uses' => 'Admin\OrderController@complete', 'as' => 'orders.complete']);
    // Route::get('orders/download/{course_id}/{user_id}', ['uses' => 'Admin\OrderController@download'])->name('orders.download');
    Route::get('orders/download/{file}', ['uses' => 'Admin\OrderController@download'])->name('orders.download')->withoutMiddleware([LocaleMiddleware::class]);
    Route::delete('orders_perma_del/{id}', ['uses' => 'Admin\OrderController@perma_del', 'as' => 'orders.perma_del']);

    Route::get('orders/{user_id}/tests/{course_id}', ['uses' => 'Admin\OrderController@courseTest', 'as' => 'orders.tests']);
    Route::get('get-tests-by-course', ['uses' => 'Admin\OrderController@getTestByCourse', 'as' => 'orders.get_tests_by_course']);

    Route::get('orders/{user_id}/tests/{course_id}/{test_id}', ['uses' => 'Admin\OrderController@courseTestQuestion', 'as' => 'orders.questions']);
    
    Route::post('orders/{user_id}/tests/{course_id}/{test_id}/get_answers', ['uses' => 'Admin\OrderController@getAnswersByUser', 'as' => 'orders.answers']);
    Route::post('orders/{user_id}/tests/{course_id}/{test_id}/get_report', ['uses' => 'Admin\OrderController@getReportByUser', 'as' => 'orders.report']);
    Route::post('orders/{user_id}/tests/{course_id}/{test_id}/update_report', ['uses' => 'Admin\OrderController@updateReportByUser', 'as' => 'orders.update-report']);

    Route::post('orders/{user_id}/tests/{course_id}/{test_id}/upload_file', ['uses' => 'Admin\OrderController@uploadFiles', 'as' => 'orders.upload-file']);
    Route::post('orders/{user_id}/tests/{course_id}/{test_id}/delete_file', ['uses' => 'Admin\OrderController@deleteFile', 'as' => 'orders.delete-file']);



    //===== Settings Routes =====//
    Route::get('settings/general', ['uses' => 'Admin\ConfigController@getGeneralSettings', 'as' => 'general-settings']);

    Route::post('settings/general', ['uses' => 'Admin\ConfigController@saveGeneralSettings'])->name('general-settings');

    Route::get('settings/social', ['uses' => 'Admin\ConfigController@getSocialSettings'])->name('social-settings');

    Route::post('settings/social', ['uses' => 'Admin\ConfigController@saveSocialSettings'])->name('social-settings');

    Route::get('contact', ['uses' => 'Admin\ConfigController@getContact'])->name('contact-settings');

    Route::get('footer', ['uses' => 'Admin\ConfigController@getFooter'])->name('footer-settings');

    Route::get('newsletter', ['uses' => 'Admin\ConfigController@getNewsletterConfig'])->name('newsletter-settings');

    Route::post('newsletter/sendgrid-lists', ['uses' => 'Admin\ConfigController@getSendGridLists'])->name('newsletter.getSendGridLists');

    Route::get('settings/zoom', ['uses' => 'Admin\ConfigController@getZoomSettings'])->name('zoom-settings');

    Route::post('settings/zoom', ['uses' => 'Admin\ConfigController@saveZoomSettings'])->name('zoom-settings');


    //===== Slider Routes =====/
    Route::resource('sliders', 'Admin\SliderController');
    Route::get('sliders/status/{id}', 'Admin\SliderController@status')->name('sliders.status', 'id');
    Route::post('sliders/save-sequence', ['uses' => 'Admin\SliderController@saveSequence', 'as' => 'sliders.saveSequence']);
    Route::post('sliders/status', ['uses' => 'Admin\SliderController@updateStatus', 'as' => 'sliders.status']);


    //===== Sponsors Routes =====//
    Route::resource('sponsors', 'Admin\SponsorController');
    Route::get('get-sponsors-data', ['uses' => 'Admin\SponsorController@getData', 'as' => 'sponsors.get_data']);
    Route::post('sponsors_mass_destroy', ['uses' => 'Admin\SponsorController@massDestroy', 'as' => 'sponsors.mass_destroy']);
    Route::get('sponsors/status/{id}', 'Admin\SponsorController@status')->name('sponsors.status', 'id');
    Route::post('sponsors/status', ['uses' => 'Admin\SponsorController@updateStatus', 'as' => 'sponsors.status']);

    //===== Testimonials Routes =====//
    Route::resource('testimonials', 'Admin\TestimonialController');
    Route::get('get-testimonials-data', ['uses' => 'Admin\TestimonialController@getData', 'as' => 'testimonials.get_data']);
    Route::post('testimonials_mass_destroy', ['uses' => 'Admin\TestimonialController@massDestroy', 'as' => 'testimonials.mass_destroy']);
    Route::get('testimonials/status/{id}', 'Admin\TestimonialController@status')->name('testimonials.status', 'id');
    Route::post('testimonials/status', ['uses' => 'Admin\TestimonialController@updateStatus', 'as' => 'testimonials.status']);


    //===== FAQs Routes =====//
    Route::resource('faqs', 'Admin\FaqController');
    Route::get('get-faqs-data', ['uses' => 'Admin\FaqController@getData', 'as' => 'faqs.get_data']);
    Route::post('faqs_mass_destroy', ['uses' => 'Admin\FaqController@massDestroy', 'as' => 'faqs.mass_destroy']);
    Route::get('faqs/status/{id}', 'Admin\FaqController@status')->name('faqs.status');
    Route::post('faqs/status', ['uses' => 'Admin\FaqController@updateStatus', 'as' => 'faqs.status']);


    //====== Contacts Routes =====//
    Route::resource('contact-requests', 'ContactController');
    Route::get('get-contact-requests-data', ['uses' => 'ContactController@getData', 'as' => 'contact_requests.get_data']);


    //====== Tax Routes =====//
    Route::resource('tax', 'TaxController');
    Route::get('tax/status/{id}', 'TaxController@status')->name('tax.status', 'id');
    Route::post('tax/status', 'TaxController@updateStatus')->name('tax.status');


    //====== Coupon Routes =====//
    Route::resource('coupons', 'CouponController');
    Route::get('coupons/status/{id}', 'CouponController@status')->name('coupons.status', 'id');
    Route::post('coupons/status', 'CouponController@updateStatus')->name('coupons.status');


    //==== Remove Locale FIle ====//
    Route::post('delete-locale', function () {
        \Barryvdh\TranslationManager\Models\Translation::where('locale', request('locale'))->delete();

        \Illuminate\Support\Facades\File::deleteDirectory(public_path('../resources/lang/' . request('locale')));
    })->name('delete-locale');


    //==== Update Theme Routes ====//
    Route::get('update-theme', 'UpdateController@index')->name('update-theme');
    Route::post('update-theme', 'UpdateController@updateTheme')->name('update-files');
    Route::post('list-files', 'UpdateController@listFiles')->name('list-files');
    Route::get('backup', 'BackupController@index')->name('backup');
    Route::get('generate-backup', 'BackupController@generateBackup')->name('generate-backup');

    Route::post('backup', 'BackupController@storeBackup')->name('backup.store');


    //===Trouble shoot ====//
    Route::get('troubleshoot', 'Admin\ConfigController@troubleshoot')->name('troubleshoot');


    //==== API Clients Routes ====//
    Route::prefix('api-client')->group(function () {
        Route::get('all', 'Admin\ApiClientController@all')->name('api-client.all');
        Route::post('generate', 'Admin\ApiClientController@generate')->name('api-client.generate');
        Route::post('status', 'Admin\ApiClientController@status')->name('api-client.status');
    });


    //==== Sitemap Routes =====//
    Route::get('sitemap', 'SitemapController@getIndex')->name('sitemap.index');
    Route::post('sitemap', 'SitemapController@saveSitemapConfig')->name('sitemap.config');
    Route::get('sitemap/generate', 'SitemapController@generateSitemap')->name('sitemap.generate');


    Route::post('translations/locales/add', 'LangController@postAddLocale');
    Route::post('translations/locales/remove', 'LangController@postRemoveLocaleFolder')->name('delete-locale-folder');

});


//Common - Shared Routes for Teacher and Administrator
Route::group(['middleware' => 'role:administrator|teacher'], function () {

    //====== Reports Routes =====//
    Route::get('report/sales', ['uses' => 'ReportController@getSalesReport', 'as' => 'reports.sales']);
    Route::get('report/students', ['uses' => 'ReportController@getStudentsReport', 'as' => 'reports.students']);

    Route::get('get-course-reports-data', ['uses' => 'ReportController@getCourseData', 'as' => 'reports.get_course_data']);
    Route::get('get-bundle-reports-data', ['uses' => 'ReportController@getBundleData', 'as' => 'reports.get_bundle_data']);
    Route::get('get-students-reports-data', ['uses' => 'ReportController@getStudentsData', 'as' => 'reports.get_students_data']);


    //====== Wallet  =====//
    Route::get('payments', ['uses' => 'PaymentController@index', 'as' => 'payments']);
    Route::get('get-earning-data', ['uses' => 'PaymentController@getEarningData', 'as' => 'payments.get_earning_data']);
    Route::get('get-withdrawal-data', ['uses' => 'PaymentController@getwithdrawalData', 'as' => 'payments.get_withdrawal_data']);
    Route::get('payments/withdraw-request', ['uses' => 'PaymentController@createRequest', 'as' => 'payments.withdraw_request']);
    Route::post('payments/withdraw-store', ['uses' => 'PaymentController@storeRequest', 'as' => 'payments.withdraw_store']);
    Route::get('payments-requests', ['uses' => 'PaymentController@paymentRequest', 'as' => 'payments.requests']);
    Route::get('get-payment-request-data', ['uses' => 'PaymentController@getPaymentRequestData', 'as' => 'payments.get_payment_request_data']);
    Route::post('payments-request-update', ['uses' => 'PaymentController@paymentsRequestUpdate', 'as' => 'payments.payments_request_update']);


    Route::get('menu-manager', ['uses' => 'MenuController@index'])->name('menu-manager');

});


//===== Categories Routes =====//
Route::resource('categories', 'Admin\CategoriesController');
Route::get('get-categories-data', ['uses' => 'Admin\CategoriesController@getData', 'as' => 'categories.get_data']);
Route::post('categories_mass_destroy', ['uses' => 'Admin\CategoriesController@massDestroy', 'as' => 'categories.mass_destroy']);
Route::post('categories_restore/{id}', ['uses' => 'Admin\CategoriesController@restore', 'as' => 'categories.restore']);
Route::delete('categories_perma_del/{id}', ['uses' => 'Admin\CategoriesController@perma_del', 'as' => 'categories.perma_del']);


//===== Courses Routes =====//
Route::resource('courses', 'Admin\CoursesController');
Route::get('get-courses-data', ['uses' => 'Admin\CoursesController@getData', 'as' => 'courses.get_data']);
Route::post('courses_mass_destroy', ['uses' => 'Admin\CoursesController@massDestroy', 'as' => 'courses.mass_destroy']);
Route::get('courses-position-reorder',['uses' => 'Admin\CoursesController@positionReorder', 'as' => 'courses.position-reorder']);
Route::post('courses_restore/{id}', ['uses' => 'Admin\CoursesController@restore', 'as' => 'courses.restore']);
Route::delete('courses_perma_del/{id}', ['uses' => 'Admin\CoursesController@perma_del', 'as' => 'courses.perma_del']);
Route::post('course-save-sequence', ['uses' => 'Admin\CoursesController@saveSequence', 'as' => 'courses.saveSequence']);
Route::get('course-publish/{id}', ['uses' => 'Admin\CoursesController@publish', 'as' => 'courses.publish']);

//=============Reorder Lessons & Tests==========//
Route::get('reorder-lesson-test', ['uses' => 'Admin\CoursesController@reorderLessonTest', 'as' => 'courses.reorder_lesson_test']);
Route::get('get-reorder-lesson-test-data', ['uses' => 'Admin\CoursesController@getReorderLessonTestData', 'as' => 'courses.get_reorder_lesson_test_data']);
Route::get('set-reorder-lesson-test', ['uses' => 'Admin\CoursesController@setReorderLessonTest', 'as' => 'courses.set_reorder_lesson_test']);


//===== Bundles Routes =====//
Route::resource('bundles', 'Admin\BundlesController');
Route::get('get-bundles-data', ['uses' => 'Admin\BundlesController@getData', 'as' => 'bundles.get_data']);
Route::post('bundles_mass_destroy', ['uses' => 'Admin\BundlesController@massDestroy', 'as' => 'bundles.mass_destroy']);
Route::post('bundles_restore/{id}', ['uses' => 'Admin\BundlesController@restore', 'as' => 'bundles.restore']);
Route::delete('bundles_perma_del/{id}', ['uses' => 'Admin\BundlesController@perma_del', 'as' => 'bundles.perma_del']);
Route::post('bundle-save-sequence', ['uses' => 'Admin\BundlesController@saveSequence', 'as' => 'bundles.saveSequence']);
Route::get('bundle-publish/{id}', ['uses' => 'Admin\BundlesController@publish', 'as' => 'bundles.publish']);


//===== Lessons Routes =====//
Route::resource('lessons', 'Admin\LessonsController');
Route::get('get-lessons-data', ['uses' => 'Admin\LessonsController@getData', 'as' => 'lessons.get_data']);
Route::post('lessons_mass_destroy', ['uses' => 'Admin\LessonsController@massDestroy', 'as' => 'lessons.mass_destroy']);
Route::post('lessons_restore/{id}', ['uses' => 'Admin\LessonsController@restore', 'as' => 'lessons.restore']);
Route::delete('lessons_perma_del/{id}', ['uses' => 'Admin\LessonsController@perma_del', 'as' => 'lessons.perma_del']);


//===== Questions Routes =====//
Route::resource('questions', 'Admin\QuestionsController');
Route::get('get-questions-data', ['uses' => 'Admin\QuestionsController@getData', 'as' => 'questions.get_data']);
//Route::get('questions/{id}/edit', ['uses' => 'Admin\QuestionsController@edit', 'as' => 'questions.edit']);
Route::get('user/questions/{id}/edit', ['uses' => 'Admin\QuestionsController@edit', 'as' => 'user.questions.edit']);
Route::post('questions_mass_destroy', ['uses' => 'Admin\QuestionsController@massDestroy', 'as' => 'questions.mass_destroy']);
Route::post('questions_restore/{id}', ['uses' => 'Admin\QuestionsController@restore', 'as' => 'questions.restore']);

Route::delete('questions_perma_del/{id}', ['uses' => 'Admin\QuestionsController@perma_del', 'as' => 'questions.perma_del']);
// Route::post('questions_store/{id}', ['uses' => 'Admin\QuestionsController@store', 'as' => 'questions.store']);

//===== textgroups Routes =====//
Route::resource('textgroups', 'Admin\TextGroupsController');
Route::get('get-textgroups-data', ['uses' => 'Admin\TextGroupsController@getData', 'as' => 'textgroups.get_data']);
Route::post('textgroups', ['uses' => 'Admin\TextGroupsController@massDestroy', 'as' => 'textgroups.mass_destroy']);
Route::post('textgroups/{id}', ['uses' => 'Admin\TextGroupsController@restore', 'as' => 'textgroups.restore']);
Route::delete('textgroups_perma_del/{id}', ['uses' => 'Admin\TextGroupsController@perma_del', 'as' => 'textgroups.perma_del']);
// Route::post('questions_store/{id}', ['uses' => 'Admin\QuestionsController@store', 'as' => 'questions.store']);

//===== Charts Routes =====//
Route::resource('charts', 'Admin\ChartsController');
Route::get('get-charts-data', ['uses' => 'Admin\ChartsController@getData', 'as' => 'charts.get_data']);
Route::post('charts', ['uses' => 'Admin\ChartsController@massDestroy', 'as' => 'charts.mass_destroy']);
Route::post('charts/{id}', ['uses' => 'Admin\ChartsController@restore', 'as' => 'charts.restore']);
Route::delete('charts_perma_del/{id}', ['uses' => 'Admin\ChartsController@perma_del', 'as' => 'charts.perma_del']);
// Route::post('questions_store/{id}', ['uses' => 'Admin\QuestionsController@store', 'as' => 'questions.store']);

//===== TestReports Routes =====//
Route::resource('testreports', 'Admin\TestReportsController');
Route::get('get-testreports-data', ['uses' => 'Admin\TestReportsController@getData', 'as' => 'testreports.get_data']);
Route::post('testreports', ['uses' => 'Admin\TestReportsController@massDestroy', 'as' => 'testreports.mass_destroy']);
Route::post('testreports/{id}', ['uses' => 'Admin\TestReportsController@restore', 'as' => 'testreports.restore']);
Route::delete('testreports_perma_del/{id}', ['uses' => 'Admin\TestReportsController@perma_del', 'as' => 'testreports.perma_del']);
// Route::post('questions_store/{id}', ['uses' => 'Admin\QuestionsController@store', 'as' => 'questions.store']);


//===== Questions Options Routes =====//
Route::resource('questions_options', 'Admin\QuestionsOptionsController');
Route::get('get-qo-data', ['uses' => 'Admin\QuestionsOptionsController@getData', 'as' => 'questions_options.get_data']);
Route::post('questions_options_mass_destroy', ['uses' => 'Admin\QuestionsOptionsController@massDestroy', 'as' => 'questions_options.mass_destroy']);
Route::post('questions_options_restore/{id}', ['uses' => 'Admin\QuestionsOptionsController@restore', 'as' => 'questions_options.restore']);
Route::delete('questions_options_perma_del/{id}', ['uses' => 'Admin\QuestionsOptionsController@perma_del', 'as' => 'questions_options.perma_del']);


//===== Tests Routes =====//
Route::resource('tests', 'Admin\TestsController');
Route::get('get-tests-data', ['uses' => 'Admin\TestsController@getData', 'as' => 'tests.get_data']);
Route::post('tests_mass_destroy', ['uses' => 'Admin\TestsController@massDestroy', 'as' => 'tests.mass_destroy']);
Route::post('tests_restore/{id}', ['uses' => 'Admin\TestsController@restore', 'as' => 'tests.restore']);
Route::delete('tests_perma_del/{id}', ['uses' => 'Admin\TestsController@perma_del', 'as' => 'tests.perma_del']);


//===== Media Routes =====//
Route::post('media/remove', ['uses' => 'Admin\MediaController@destroy', 'as' => 'media.destroy']);


//===== User Account Routes =====//
Route::group(['middleware' => ['auth', 'password_expires']], function () {
    Route::get('account', [AccountController::class, 'index'])->name('account');
    Route::get('time-limit-create', [TimeLimitController::class, 'create'])->name('time_limit_crate');
    Route::get('time-limit', [TimeLimitController::class, 'index'])->name('time_limit');
    Route::get('time-limit-get-data', [TimeLimitController::class, 'getData'])->name('timelimit.getData');
    Route::post('add_time_limit', [TimeLimitController::class, 'store'])->name('add_time_limit');
    Route::patch('account/{email?}', [UserPasswordController::class, 'update'])->name('account.post');
    Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update');
});


Route::group(['middleware' => 'role:teacher'], function () {
//====== Review Routes =====//
    Route::resource('reviews', 'ReviewController');
    Route::get('get-reviews-data', ['uses' => 'ReviewController@getData', 'as' => 'reviews.get_data']);
});


Route::group(['middleware' => 'role:student'], function () {

//==== Certificates ====//
    Route::get('certificates', 'CertificateController@getCertificates')->name('certificates.index');
    Route::get('certificates/generate', 'CertificateController@generateCertificate')->name('certificates.generate');
    Route::get('certificates/download', ['uses' => 'CertificateController@download', 'as' => 'certificates.download']);
});


//==== Messages Routes =====//
Route::get('messages', ['uses' => 'MessagesController@index', 'as' => 'messages']);
Route::post('messages/unread', ['uses' => 'MessagesController@getUnreadMessages', 'as' => 'messages.unread']);
Route::post('messages/send', ['uses' => 'MessagesController@send', 'as' => 'messages.send']);
Route::post('messages/reply', ['uses' => 'MessagesController@reply', 'as' => 'messages.reply']);


//=== Invoice Routes =====//
Route::get('invoice/download/{order}', ['uses' => 'Admin\InvoiceController@getInvoice', 'as' => 'invoice.download']);
Route::get('invoices/view/{code}', ['uses' => 'Admin\InvoiceController@showInvoice', 'as' => 'invoices.view']);
Route::get('invoices', ['uses' => 'Admin\InvoiceController@getIndex', 'as' => 'invoices.index']);


//======= Blog Routes =====//
Route::group(['prefix' => 'blog'], function () {
    Route::get('/create', 'Admin\BlogController@create');
    Route::post('/create', 'Admin\BlogController@store');
    Route::get('delete/{id}', 'Admin\BlogController@destroy')->name('blogs.delete');
    Route::get('edit/{id}', 'Admin\BlogController@edit')->name('blogs.edit');
    Route::post('edit/{id}', 'Admin\BlogController@update');
    Route::get('view/{id}', 'Admin\BlogController@show');
    Route::get('download/{courseid}', 'Admin\BlogController@show');
//        Route::get('{blog}/restore', 'BlogController@restore')->name('blog.restore');
    Route::post('{id}/storecomment', 'Admin\BlogController@storeComment')->name('storeComment');
});
Route::resource('blogs', 'Admin\BlogController');
Route::get('get-blogs-data', ['uses' => 'Admin\BlogController@getData', 'as' => 'blogs.get_data']);
Route::post('blogs_mass_destroy', ['uses' => 'Admin\BlogController@massDestroy', 'as' => 'blogs.mass_destroy']);


//======= Pages Routes =====//
Route::resource('pages', 'Admin\PageController');
Route::get('get-pages-data', ['uses' => 'Admin\PageController@getData', 'as' => 'pages.get_data']);
Route::post('pages_mass_destroy', ['uses' => 'Admin\PageController@massDestroy', 'as' => 'pages.mass_destroy']);
Route::post('pages_restore/{id}', ['uses' => 'Admin\PageController@restore', 'as' => 'pages.restore']);
Route::delete('pages_perma_del/{id}', ['uses' => 'Admin\PageController@perma_del', 'as' => 'pages.perma_del']);


//==== Reasons Routes ====//
Route::resource('reasons', 'Admin\ReasonController');
Route::get('get-reasons-data', ['uses' => 'Admin\ReasonController@getData', 'as' => 'reasons.get_data']);
Route::post('reasons_mass_destroy', ['uses' => 'Admin\ReasonController@massDestroy', 'as' => 'reasons.mass_destroy']);
Route::get('reasons/status/{id}', 'Admin\ReasonController@status')->name('reasons.status');
Route::post('reasons/status', ['uses' => 'Admin\ReasonController@updateStatus', 'as' => 'reasons.status']);

//==== Live Lessons ====//
Route::group(['prefix'=> 'live-lessons'], function () {
    Route::get('data', ['uses' => 'LiveLessonController@getData', 'as' => 'live-lessons.get_data']);
    Route::post('restore/{id}', ['uses' => 'LiveLessonController@restore', 'as' => 'live-lessons.restore']);
    Route::delete('permanent/{id}', ['uses' => 'LiveLessonController@permanent', 'as' => 'live-lessons.perma_del']);
});
Route::resource('live-lessons', 'LiveLessonController');


//==== Live Lessons Slot ====//
Route::group(['prefix'=> 'live-lesson-slots'], function () {
    Route::get('data', ['uses' => 'LiveLessonSlotController@getData', 'as' => 'live-lesson-slots.get_data']);
    Route::post('restore/{id}', ['uses' => 'LiveLessonSlotController@restore', 'as' => 'live-lesson-slots.restore']);
    Route::delete('permanent/{id}', ['uses' => 'LiveLessonSlotController@permanent', 'as' => 'live-lesson-slots.perma_del']);
});
Route::resource('live-lesson-slots', 'LiveLessonSlotController');

Route::group(['namespace' => 'Admin\Stripe', 'prefix' => 'stripe', 'as' => 'stripe.'], function () {
    //==== Stripe Plan Controller ====//
    Route::group(['prefix' => 'plans'], function() {
        Route::get('data', ['uses' => 'StripePlanController@getData', 'as' => 'plans.get_data']);
        Route::post('restore/{id}', ['uses' => 'StripePlanController@restore', 'as' => 'plans.restore']);
        Route::delete('permanent/{id}', ['uses' => 'StripePlanController@permanent', 'as' => 'plans.perma_del']);
    });
    Route::resource('plans', 'StripePlanController');
});

Route::get('subscriptions', 'SubscriptionController')->name('subscriptions');
Route::get('subscription/invoice/{invoice}', 'SubscriptionController@downloadInvoice')->name('subscriptions.download_invoice');
Route::get('subscriptions/cancel','SubscriptionController@deleteSubscription')->name('subscriptions.delete');

// Wishlist Route
Route::get('wishlist/data',['uses' => 'WishlistController@getData', 'as' => 'wishlist.get_data']);
Route::resource('wishlist','WishlistController');
