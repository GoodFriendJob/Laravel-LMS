<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ReviewController extends Controller
{
    /**
     * Display a listing of Category.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.reviews.index');
    }

    /**
     * Display a listing of Courses via ajax DataTable.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request)
    {
        $reviews = "";
        $courses_id = auth()->user()->courses()->has('reviews')->pluck('id')->toArray();
        $reviews = Review::where('reviewable_type','=','App\Models\Course')
            ->whereIn('reviewable_id',$courses_id)
            ->orderBy('created_at', 'desc')
            ->get();


        return DataTables::of($reviews)
            ->addIndexColumn()
            ->editColumn('created_at', function ($q) {
                return $q->created_at->format('d M, Y | H:i A');
            })
            ->addColumn('course', function ($q) {
               $course_name = $q->reviewable->title;
               $course_slug = $q->reviewable->slug;
               $link = "<a href='".route('courses.show', [$course_slug])."' target='_blank'>".$course_name."</a>";
               return $link;
            })
            ->addColumn('user',function ($q){
                return $q->user->full_name;
            })
            ->rawColumns(['course'])
            ->make();
    }
}
