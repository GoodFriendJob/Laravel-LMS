<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseTimeline extends Model
{
    protected $table = "course_timeline";
    protected $guarded = [];

    public function model()
    {
        return $this->morphTo();
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }




}
