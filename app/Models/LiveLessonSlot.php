<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LiveLessonSlot extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'start_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['lesson_id', 'meeting_id', 'topic', 'description', 'start_at', 'duration', 'password', 'student_limit', 'start_url', 'join_url'];


    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function lessonSlotBookings()
    {
        return $this->hasMany(LessonSlotBooking::class);
    }
}
