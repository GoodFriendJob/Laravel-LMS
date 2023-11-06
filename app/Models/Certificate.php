<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $guarded =[];
    protected $appends = ['certificate_link'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function getCertificateLinkAttribute(){
        if ($this->url != null) {
            return url('storage/certificates/'.$this->url);
        }
        return NULL;
    }
}
