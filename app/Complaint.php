<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    public function complaint_category(){
        return $this->belongsTo('App\ComplaintCategory');
    }

    public function complaint_attachments(){
        return $this->hasMany('App\ComplaintAttachment');
    }

    public function complaint_updates(){
        return $this->hasMany('App\ComplaintUpdate');
    }

    public function complainant(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function staff(){
        return $this->belongsToMany('App\Staff');
    }

    public function departments(){
        return $this->belongsToMany('App\Department', 'complaint_departments');
    }
}
