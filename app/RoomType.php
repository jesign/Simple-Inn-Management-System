<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    public function roomRates(){
    	return $this->hasMany('App\RoomRate');
    }
}
