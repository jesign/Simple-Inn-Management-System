<?php

namespace App;

use App\Services\ChargeService;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
	protected $dates = ['check_in', 'check_out'];
    protected $appends = ['checkout_time', 'checkin_time'];
    /* Attributes */
    public function getCheckinTimeAttribute()
    {   
        return isset($this->check_in) ? $this->check_in->format('M d, h:i A') : '';
    }

    public function getCheckoutTimeAttribute()
    {
        return isset($this->check_out) ? $this->check_out->format('M d, h:i A') : '';
    }


    /* Relationships*/
    public function roomType()
    {
    	return $this->belongsto('App\RoomType');
    }

    public function roomRate()
    {
    	return $this->belongsto('App\RoomRate');
    }


    /* Functions */
    public function getCheckIn()
    {
    	if($this->check_in)
    		return $this->check_in->format('Y-m-d\TH:i'); 	
    	return null;
    }

    public function getCheckOut()
    {
    	if($this->check_out)
    		return $this->check_out->format('Y-m-d\TH:i'); 	
    	return null;
    }

    public function updateTotalBill()
    {
		$orderTotalPrice = OrderService::getTotalPriceFromGuest($this->id);
		$chargeTotalPrice = ChargeService::getTotalPriceFromGuest($this->id);
		$room_price = $this->roomRate->price;

		$this->total_bill = $orderTotalPrice + $chargeTotalPrice + $room_price;
		$this->save();
    }
}
