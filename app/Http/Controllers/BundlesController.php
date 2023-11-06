<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Bundle;
use App\Models\Category;
use App\Models\Course;
use App\Models\Review;
use Illuminate\Http\Request;

class BundlesController extends Controller
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
            $bundles = Bundle::withoutGlobalScope('filter')->canDisableBundle()->where('published', 1)->where('popular', '=', 1)->orderBy('id', 'desc')->paginate(9);

        } else if (request('type') == 'trending') {
            $bundles = Bundle::withoutGlobalScope('filter')->canDisableBundle()->where('published', 1)->where('trending', '=', 1)->orderBy('id', 'desc')->paginate(9);

        } else if (request('type') == 'featured') {
            $bundles = Bundle::withoutGlobalScope('filter')->canDisableBundle()->where('published', 1)->where('featured', '=', 1)->orderBy('id', 'desc')->paginate(9);

        } else {
            $bundles = Bundle::withoutGlobalScope('filter')->canDisableBundle()->where('published', 1)->orderBy('id', 'desc')->paginate(9);
        }
        $categories = Category::where('status','=',1)->get();

        $purchased_bundles = NULL;
        if (\Auth::check()) {
            $purchased_bundles = Bundle::withoutGlobalScope('filter')->whereHas('students', function ($query) {
                $query->where('id', \Auth::id());
            })
                ->with('courses')
                ->orderBy('id', 'desc')
                ->get();
        }
        $featured_courses = Course::withoutGlobalScope('filter')->canDisableCourse()->where('published', '=', 1)
            ->where('featured', '=', 1)->take(8)->get();

        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
        return view( $this->path.'.bundles.index', compact('bundles', 'purchased_bundles', 'recent_news','featured_courses','categories'));
    }

    public function show($bundle_slug)
    {
        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
        $bundle = Bundle::withoutGlobalScope('filter')->where('slug', $bundle_slug)->first();
        $purchased_bundle = \Auth::check() && $bundle->students()->where('user_id', \Auth::id())->count() > 0;
        if(($bundle->published == 0) && ($purchased_bundle == false)){
            abort(404);
        }
        $bundle_rating = 0;
        $total_ratings = 0;
        $is_reviewed = false;
        if(auth()->check() && $bundle->reviews()->where('user_id','=',auth()->user()->id)->first()){
            $is_reviewed = true;
        }
        if ($bundle->reviews->count() > 0) {
            $bundle_rating = $bundle->reviews->avg('rating');
            $total_ratings = $bundle->reviews()->where('rating', '!=', "")->get()->count();
        }
        $courses = $bundle->courses()->orderby('id','asc')->get();


        return view( $this->path.'.bundles.show', compact('bundle', 'purchased_bundle', 'recent_news', 'bundle_rating','bundle_rating','courses','total_ratings','is_reviewed'));
    }


    public function rating($course_id, Request $request)
    {
        $bundle = Bundle::findOrFail($course_id);
        $bundle->students()->updateExistingPivot(\Auth::id(), ['rating' => $request->get('rating')]);

        return redirect()->back()->with('success', 'Thank you for rating.');
    }

    public function getByCategory(Request $request)
    {
        $category = Category::where('slug', '=', $request->category)->first();
        if ($category != "") {
            $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
            $featured_courses = Course::where('published', '=', 1)
                ->where('featured', '=', 1)->take(8)->get();

            $courses = $category->courses()->where('published', '=', 1)->paginate(9);
            return view( $this->path.'.courses.index', compact('courses', 'category', 'recent_news','featured_courses'));
        }
        return abort(404);
    }

    public function addReview(Request $request)
    {
        $this->validate($request, [
            'review' => 'required'
        ]);
        $bundle = Bundle::findORFail($request->id);
        $review = new Review();
        $review->user_id = auth()->user()->id;
        $review->reviewable_id = $bundle->id;
        $review->reviewable_type = Bundle::class;
        $review->rating = $request->rating;
        $review->content = $request->review;
        $review->save();

        return back();
    }

    public function editReview(Request $request)
    {
        $review = Review::where('id', '=', $request->id)->where('user_id', '=', auth()->user()->id)->first();
        if ($review) {
            $bundle = $review->reviewable;
            $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
            $purchased_bundle= \Auth::check() && $bundle->students()->where('user_id', \Auth::id())->count() > 0;
            $bundle_rating = 0;
            $total_ratings = 0;

            if ($bundle->reviews->count() > 0) {
                $bundle_rating = $bundle->reviews->avg('rating');
                $total_ratings = $bundle->reviews()->where('rating', '!=', "")->get()->count();
            }

            return view( $this->path.'.bundles.show', compact('bundle', 'purchased_bundle', 'recent_news', 'bundle_rating', 'total_ratings', 'review'));
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

            return redirect()->route('bundles.show', ['slug' => $review->reviewable->slug]);
        }
        return abort(404);

    }

    public function deleteReview(Request $request)
    {
        $review = Review::where('id', '=', $request->id)->where('user_id', '=', auth()->user()->id)->first();
        if ($review) {
            $slug = $review->reviewable->slug;
            $review->delete();
            return redirect()->route('bundles.show', ['slug' => $slug]);
        }
        return abort(404);
    }
}
