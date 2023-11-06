<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

/**
 * Class Course
 *
 * @package App
 * @property string $title
 * @property string $slug
 * @property text $description
 * @property decimal $price
 * @property string $course_image
 * @property string $start_date
 * @property tinyInteger $published
 */
class Course extends Model
{
    use SoftDeletes;

    protected $fillable = ['category_id', 'title', 'slug', 'description', 'price', 'course_image','course_video', 'start_date', 'published', 'free','position','featured', 'trending', 'popular', 'meta_title', 'meta_description', 'meta_keywords', 'expire_at','strike'];

    protected $appends = ['image'];

//    protected $dates = ['expire_at'];


    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        if (auth()->check()) {
            if (auth()->user()->hasRole('teacher')) {
                static::addGlobalScope('filter', function (Builder $builder) {
                    $builder->whereHas('teachers', function ($q) {
                        $q->where('course_user.user_id', '=', auth()->user()->id);
                    });
                });
            }
        }

        static::deleting(function ($course) { // before delete() method call this
            if ($course->isForceDeleting()) {
                if (File::exists(public_path('/storage/uploads/' . $course->course_image))) {
                    File::delete(public_path('/storage/uploads/' . $course->course_image));
                    File::delete(public_path('/storage/uploads/thumb/' . $course->course_image));
                }
            }
        });


    }


    public function getImageAttribute()
    {
        if ($this->course_image != null) {
            return url('storage/uploads/'.$this->course_image);
        }
        return NULL;
    }

    public function getPriceAttribute()
    {
        if (($this->attributes['price'] == null)) {
            return round(0.00);
        }
        return $this->attributes['price'];
    }


    /**
     * Set attribute to money format
     * @param $input
     */
    public function setPriceAttribute($input)
    {
        $this->attributes['price'] = $input ? $input : null;
    }

    /**
     * Set attribute to date format
     * @param $input
     */
    public function setStartDateAttribute($input)
    {
        if ($input != null && $input != '') {
            $this->attributes['start_date'] = Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
        } else {
            $this->attributes['start_date'] = null;
        }
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getStartDateAttribute($input)
    {
        $zeroDate = str_replace(['Y', 'm', 'd'], ['0000', '00', '00'], config('app.date_format'));

        if ($input != $zeroDate && $input != null) {
            return Carbon::createFromFormat('Y-m-d', $input)->format(config('app.date_format'));
        } else {
            return '';
        }
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'course_user')->withPivot('user_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'course_student')->withTimestamps()->withPivot(['rating']);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('lessonorders');
    }

    public function publishedLessons()
    {
        return $this->hasMany(Lesson::class)->where('published', 1);
    }

    public function scopeOfTeacher($query)
    {
        if (!Auth::user()->isAdmin()) {
            return $query->whereHas('teachers', function ($q) {
                $q->where('user_id', Auth::user()->id);
            });
        }
        return $query;
    }

    public function getRatingAttribute()
    {
        return $this->reviews->avg('rating');
    }

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tests()
    {
        return $this->hasMany('App\Models\Test');
    }

    public function courseTimeline()
    {
        return $this->hasMany(CourseTimeline::class);
    }

    public function getIsAddedToCart(){
        if(auth()->check() && (auth()->user()->hasRole('student')) && (\Cart::session(auth()->user()->id)->get( $this->id))){
            return true;
        }
        return false;
    }


    public function reviews()
    {
        return $this->morphMany('App\Models\Review', 'reviewable');
    }

    public function progress()
    {
        $main_chapter_timeline = $this->lessons()->where('published',1)->pluck('id')->merge($this->tests()->pluck('id'));
        if(is_null(auth()->user())) return 0;
        $completed_lessons = auth()->user()->chapters()->where('course_id', $this->id)->pluck('model_id');
        if ($completed_lessons->count() > 0) {
            return intval($completed_lessons->count() / $main_chapter_timeline->count() * 100);
        } else {
            return 0;
        }
    }

    public function isUserCertified()
    {
        $status = false;
        $certified = auth()->user()->certificates()->where('course_id', '=', $this->id)->first();
        if ($certified != null) {
            $status = true;
        }
        return $status;
    }

    public function item()
    {
        return $this->morphMany(OrderItem::class, 'item');
    }

    public function bundles()
    {
        return $this->belongsToMany(Bundle::class, 'bundle_courses');
    }

    public function chapterCount()
    {
        $timeline = $this->courseTimeline;
        $chapters = 0;
        foreach ($timeline as $item) {
            if (isset($item->model) && ($item->model->published == 1)) {
                $chapters++;
            }
        }
        return $chapters;
    }

    public function mediaVideo()
    {
        $types = ['youtube', 'vimeo', 'upload', 'embed'];
        return $this->morphOne(Media::class, 'model')
            ->whereIn('type', $types);

    }

    // scope for disable course if course expire date is less than tomorrow date
    public function scopeCanDisableCourse($query)
    {
        return $query->where(function($q){
                $q->whereNull('expire_at')->orWhereDate('expire_at', '>=', Carbon::now()->format('Y-m-d'));
        });
    }

    public function getStrikePriceAttribute()
    {
        if($this->strike) {
            return '<strike class="text-secondary">' . getCurrency(config('app.currency'))['symbol'] . ' ' . $this->strike . '</strike>';
        }
        return;
    }

    public function getCoursePageStrikePriceAttribute()
    {
        if($this->strike) {
            return '<div class="h6">'.trans('labels.frontend.course.original_price').'<span> '.$this->strikePrice .'</span></div>';
        }
        return ;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function wishlist()
    {
        return $this->hasMany(WishList::class);
    }


}
