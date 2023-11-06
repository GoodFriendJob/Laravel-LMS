<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    protected $guarded = [];

    /**
    * Get the teacher profile that owns the user.
    */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
