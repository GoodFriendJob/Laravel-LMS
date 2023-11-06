<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function items(){
        return $this->hasMany(OrderItem::class);
    }

    public function invoice(){
        return $this->hasOne(Invoice::class);
    }

    public function coupon(){
        return $this->belongsTo(Coupon::class);
    }


}
