<?php 
namespace App\Services;

use App\Charge;

class ChargeService{
	public static function getChargesFromGuest($guest_id){
		$charges = Charge::where('guest_id', $guest_id)->get();
		return $charges;
	}

	public static function getTotalPriceFromGuest($guest_id){
		$totalPrice = 0;
		$charges = Charge::where('guest_id', $guest_id)->get();
		foreach ($charges as $charge) {
			$totalPrice += $charge->price;
		}
		return $totalPrice;
	}
}