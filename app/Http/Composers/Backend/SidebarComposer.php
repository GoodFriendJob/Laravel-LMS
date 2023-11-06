<?php

namespace App\Http\Composers\Backend;

use Illuminate\View\View;
use App\Repositories\Backend\Auth\UserRepository;
use DB;
use App\Models\Test;


/**
 * Class SidebarComposer.
 */
class SidebarComposer
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * SidebarComposer constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param View $view
     *
     * @return bool|mixed
     */
    public function compose(View $view)
    {
        if (config('access.users.requires_approval')) {
            $view->with('pending_approval', $this->userRepository->getUnconfirmedCount());
        } else {
            $view->with('pending_approval', 0);
        }

         // Fetch additional dynamic data for the sidebar


$sidebarData = [];
$courses = auth()->user()->purchasedCourses();
$userTestTestIds = DB::table('user_test')
    ->where('user_id', auth()->user()->id)
    // ->where(function ($query) {
    //     $query->whereNotNull('report_pdf')
    //         ->where('report_pdf', '!=', '');
    // })
    // ->where(function ($query) {
    //     $query->whereNotNull('questions_ans_pdf')
    //         ->where('questions_ans_pdf', '!=', '');
    // })
    ->distinct()
    ->pluck('test_id');

foreach ($courses as $key => $value) {
    $tests = Test::leftJoin('user_test', function ($join) {
            $join->on('tests.id', '=', 'user_test.test_id')
                 ->whereRaw('user_test.id = (select max(id) from user_test where test_id = tests.id and user_id = ' . auth()->user()->id . ')');
        })
        ->where([
            ['tests.course_id', '=', $value->id],
            ['tests.published', '=', 1]
        ])
        ->whereIn('tests.id', $userTestTestIds)
        ->select(
            'tests.title',
            'tests.id',
            'tests.slug',
            'user_test.id as user_test_id',
            'user_test.report_pdf',
            'user_test.questions_ans_pdf'
        )
        // ->whereNotNull('user_test.report_pdf')
        // ->where('user_test.report_pdf', '!=', '')
        // ->whereNotNull('user_test.questions_ans_pdf')
        // ->where('user_test.questions_ans_pdf', '!=', '')
        ->get();

    if ($tests->isNotEmpty()) {
        $sidebarData[$key]['id'] = $value->id;
        $sidebarData[$key]['course_slug'] = $value->slug;
        $sidebarData[$key]['title'] = $value->title;
        $sidebarData[$key]['tests'] = $tests;
    }
}

   // dd($sidebarData);
    // Pass the additional data to the view
    $view->with('sidebarData', $sidebarData);


    }
}
