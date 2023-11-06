<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;

class Earning extends Model
{
    protected $guarded = [];

    /**
    * Get the teacher that owns earning.
    */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
    * Get the order that owns earning.
    */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
    * Get the course that owns earning.
    */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

}
