<?php

namespace App\Models;

use App\Models\Auth\User;
use App\Models\Lesson;
use App\Models\LiveLessonSlot;
use Illuminate\Database\Eloquent\Model;

class LessonSlotBooking extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['live_lesson_slot_id', 'user_id','lesson_id'];


    public function liveLessonSlot()
    {
        return $this->belongsTo(LiveLessonSlot::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
