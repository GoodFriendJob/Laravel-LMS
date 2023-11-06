<?php

namespace App\Models;

use App\Models\Auth\User;
use App\Models\VideoProgress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Media extends Model
{
    protected $table = "media";
    protected $guarded = [];

    public function model()
    {
        return $this->morphTo();
    }

    //Fetch Progress
    public function getProgress($user_id){
        $progress = null;
        $user = User::find($user_id);
        if($user){
            $progress = VideoProgress::where('user_id','=',$user_id)->where('media_id','=',$this->id)->first();
        }
        if($progress == null){
            $progress = new VideoProgress();
        }
        return $progress;
    }

    public function getProgressPercentage($user_id){
        $progress = $this->getProgress($user_id);
        if($progress->progress){
            $percentage = ($progress->progress / $progress->duration)* 100;
        }else{
            $percentage = 0;
        }
        return round($percentage,2);
    }

}
