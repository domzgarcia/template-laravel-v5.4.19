<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InquiryResponse extends Model
{
    protected $table = 'inquiries_response';
	public function user(){
		return $this->hasOne('App\User','id','user_id');
	}
}
