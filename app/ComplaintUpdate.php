<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplaintUpdate extends Model
{
    public function complaint(){
        return $this->belongsTo('App\Complaint');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
