<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplaintCategory extends Model
{
	public function complaints(){
		return $this->hasMany('App\Complaint');
	}
}
