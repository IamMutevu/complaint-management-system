<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public function staff(){
        return $this->hasMany('App\Staff');
    }

    public function complaints(){
        return $this->belongsToMany('App\Complaint', 'complaint_departments');
    }
}
