<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;

class VideoProgress extends Model
{
    protected $table = "video_progresses";
    //Relations
    public function user(){
        return $this->belongsTo(User::class);
    }


}
