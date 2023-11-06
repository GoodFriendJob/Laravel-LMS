<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatterCategory extends Model
{
    protected $guarded = [];

    public function parent(){

        return ChatterCategory::where('id','=',$this->parent_id)->first();
    }
}
