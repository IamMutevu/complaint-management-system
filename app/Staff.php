<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    public function department(){
        return $this->belongsTo('App\Department');
    }

    public function complaint(){
        return $this->belongsToMany('App\Complaint');
    }
}
