<?php

namespace App\Models;
use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Time_limit extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'time_limit'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
