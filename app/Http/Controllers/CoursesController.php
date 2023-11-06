<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Bundle;
use App\Models\Category;
use App\Models\Course;
use App\Models\Review;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer;
use Cart;
use DB;
use App\Models\Test;
use Mail;


class CoursesController extends Controller
{

    private $path;

    public function __construct()
    {
        $path = 'frontend';
        if(session()->has('display_type')){
            if(session('display_type') == 'rtl'){
                $path = 'frontend-rtl';
            }else{
                $path = 'frontend';
            }
        }else if(config('app.display_type') == 'rtl'){
            $path = 'frontend-rtl';
        }
        $this->path = $path;
    }

    public function all()
    {
        if (request('type') == 'popular') {
            $courses = Course::withoutGlobalScope('filter')->canDisableCourse()->where('published', 1)->where('popular', '=', 1)->orderBy('id', 'desc')->paginate(9);

        } else if (request('type') == 'trending') {
            $courses = Course::withoutGlobalScope('filter')->canDisableCourse()->where('published', 1)->where('trending', '=', 1)->orderBy('id', 'desc')->paginate(9);

        } else if (request('type') == 'featured') {
            $courses = Course::withoutGlobalScope('filter')->canDisableCourse()->where('published', 1)->where('featured', '=', 1)->orderBy('id', 'desc')->paginate(9);

        } else {
            $courses = Course::withoutGlobalScope('filter')->canDisableCourse()->where('published', 1)->orderBy('id', 'desc')->paginate(9);
        }
        $purchased_courses = NULL;
        $purchased_bundles = NULL;
        $categories = Category::where('status','=',1)->get();

        if (\Auth::check()) {
            $purchased_courses = Course::withoutGlobalScope('filter')->canDisableCourse()->whereHas('students', function ($query) {
                $query->where('id', \Auth::id());
            })
                ->with('lessons')
                ->orderBy('id', 'desc')
                ->get();
        }
        $featured_courses = Course::withoutGlobalScope('filter')->canDisableCourse()->where('published', '=', 1)
            ->where('featured', '=', 1)->take(8)->get();

        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
        return view( $this->path.'.courses.index', compact('courses', 'purchased_courses', 'recent_news','featured_courses','categories'));
    }

    public function show($course_slug)
    {   
        $continue_course=NULL;
        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
        $course = Course::withoutGlobalScope('filter')->where('slug', $course_slug)->with('publishedLessons')->firstOrFail();
        $course_id = Course::withoutGlobalScope('filter')->where('slug', $course_slug)->with('publishedLessons')->pluck('id');
        // return $course;
        $purchased_course = \Auth::check() && $course->students()->where('user_id', \Auth::id())->count() > 0;
        if(($course->published == 0) && ($purchased_course == false)){
            abort(404);
        }
        $course_rating = 0;
        $total_ratings = 0;
        $completed_lessons = "";
        $is_reviewed = false;
        if(auth()->check() && $course->reviews()->where('user_id','=',auth()->user()->id)->first()){
            $is_reviewed = true;
        }
        if ($course->reviews->count() > 0) {
            $course_rating = $course->reviews->avg('rating');
            $total_ratings = $course->reviews()->where('rating', '!=', "")->get()->count();
        }
        $lessons = $course->courseTimeline()->orderby('sequence','asc')->get();

        // return $lessons;
        if (\Auth::check()) {

            //$completed_lessons = \Auth::user()->chapters()->where('course_id', $course->id)->get()->pluck('model_id')->toArray();
            $completed_lessons = \Auth::user()->chapters()->where('course_id', $course->id)->get()->pluck('model_id')->toArray();
           
            $course_lessons = $course->lessons->pluck('id')->toArray();
            $continue_course  = $course->courseTimeline()
                ->whereIn('model_id',$course_lessons)
                ->orderby('sequence','asc')
                ->whereNotIn('model_id',$completed_lessons)

                ->first();
            if($continue_course == null){
                $continue_course = $course->courseTimeline()
                    ->whereIn('model_id',$course_lessons)
                    ->orderby('sequence','asc')->first();
            }

        }
        $percentage = [];
        // $test_questions = \DB::select("SELECT GROUP_CONCAT(q.id) as questions_id, t.id as testid,count(t.id) as question_count FROM courses c LEFT JOIN tests t ON c.id = t.course_id LEFT JOIN questions q ON t.id = q.test_id WHERE c.slug = '$course_slug' GROUP BY t.id ");
        
        // // dd($test_questions);
        // foreach($test_questions as $q_a){
        //     if(!empty($q_a->questions_id)){
        //         $user_answers = DB::table('user_answer')->where('user_id', \Auth::id())->where('test_id', $q_a->testid)->get();
        //         $first_a;
        //         $answers_count = 0;
        //         foreach ($user_answers as $key => $value) {
        //             if($key == 0 || $value->question_id != $first_a){
        //                 $first_a = $value->question_id;
        //                 $answers_count++;
        //             }
        //         }
        //         $percentage[$q_a->testid]= (($answers_count)/$q_a->question_count)*100;
        // }}
        foreach ($lessons as $lesson) {
            if($lessons[0]->model?->id && isset($lesson->model->id)) {
                $test_id = $lesson->model->id;
                $user_answers = DB::table('user_answer')->where('user_id', \Auth::id())->where('test_id', $test_id)->get();
                $question_count = DB::table('question_test')->where('test_id', $test_id)->count();
                $question_count != 0 ? $all_cnt = $question_count : $all_cnt = 1;
                $first_a;
                $answers_count = 0;
                if($question_count != 0){
                    foreach ($user_answers as $key => $value) {
                        if($key == 0 || $value->question_id != $first_a){
                            $first_a = $value->question_id;
                            $answers_count++;
                        }
                    }
                    $percentage[$test_id] = (($answers_count)/$all_cnt)*100;
                }
            }
        }

        return view( $this->path.'.courses.course', compact('course', 'purchased_course', 'recent_news', 'course_rating', 'completed_lessons','total_ratings','is_reviewed','lessons','continue_course','percentage'));
    }

    public function rating($course_id, Request $request)
    {
        $course = Course::findOrFail($course_id);
        $course->students()->updateExistingPivot(\Auth::id(), ['rating' => $request->get('rating')]);

        return redirect()->back()->with('success', 'Thank you for rating.');
    }

    public function getByCategory(Request $request)
    {
        $category = Category::where('slug', '=', $request->category)
            ->where('status','=',1)
            ->first();
        $categories = Category::where('status','=',1)->get();

        if ($category != "") {
            $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
            $featured_courses = Course::where('published', '=', 1)
                ->where('featured', '=', 1)->take(8)->get();

            if (request('type') == 'popular') {
                $courses = $category->courses()->withoutGlobalScope('filter')->where('published', 1)->where('popular', '=', 1)->orderBy('id', 'desc')->paginate(9);

            } else if (request('type') == 'trending') {
                $courses = $category->courses()->withoutGlobalScope('filter')->where('published', 1)->where('trending', '=', 1)->orderBy('id', 'desc')->paginate(9);

            } else if (request('type') == 'featured') {
                $courses = $category->courses()->withoutGlobalScope('filter')->where('published', 1)->where('featured', '=', 1)->orderBy('id', 'desc')->paginate(9);

            } else {
                $courses = $category->courses()->withoutGlobalScope('filter')->where('published', 1)->orderBy('id', 'desc')->paginate(9);
            }


            return view( $this->path.'.courses.index', compact('courses', 'category', 'recent_news','featured_courses','categories'));
        }
        return abort(404);
    }

    public function addReview(Request $request)
    {
        $this->validate($request, [
            'review' => 'required'
        ]);
        $course = Course::findORFail($request->id);
        $review = new Review();
        $review->user_id = auth()->user()->id;
        $review->reviewable_id = $course->id;
        $review->reviewable_type = Course::class;
        $review->rating = $request->rating;
        $review->content = $request->review;
        $review->save();

        return back();
    }

    public function editReview(Request $request)
    {
        $review = Review::where('id', '=', $request->id)->where('user_id', '=', auth()->user()->id)->first();
        if ($review) {
            $course = $review->reviewable;
            $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
            $purchased_course = \Auth::check() && $course->students()->where('user_id', \Auth::id())->count() > 0;
            $course_rating = 0;
            $total_ratings = 0;
            $lessons = $course->courseTimeline()->orderby('sequence','asc')->get();

            if ($course->reviews->count() > 0) {
                $course_rating = $course->reviews->avg('rating');
                $total_ratings = $course->reviews()->where('rating', '!=', "")->get()->count();
            }
            if (\Auth::check()) {

                $completed_lessons = \Auth::user()->chapters()->where('course_id', $course->id)->get()->pluck('model_id')->toArray();
                $continue_course  = $course->courseTimeline()->orderby('sequence','asc')->whereNotIn('model_id',$completed_lessons)->first();
                if($continue_course == ""){
                    $continue_course = $course->courseTimeline()->orderby('sequence','asc')->first();
                }

            }
            return view( $this->path.'.courses.course', compact('course', 'purchased_course', 'recent_news','completed_lessons','continue_course', 'course_rating', 'total_ratings','lessons', 'review'));
        }
        return abort(404);

    }


    public function updateReview(Request $request)
    {
        $review = Review::where('id', '=', $request->id)->where('user_id', '=', auth()->user()->id)->first();
        if ($review) {
            $review->rating = $request->rating;
            $review->content = $request->review;
            $review->save();

            return redirect()->route('courses.show', ['slug' => $review->reviewable->slug]);
        }
        return abort(404);

    }

    public function deleteReview(Request $request)
    {
        $review = Review::where('id', '=', $request->id)->where('user_id', '=', auth()->user()->id)->first();
        if ($review) {
            $slug = $review->reviewable->slug;
            $review->delete();
            return redirect()->route('courses.show', ['slug' => $slug]);
        }
        return abort(404);
    }


}
