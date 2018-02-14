<?php 
namespace App\Services;

use App\Order;

class OrderService{
	public static function getOrdersFromGuest($guest_id){
		$orders = Order::where('guest_id', $guest_id)->with('item')->get();
		return $orders;
	}

	public static function getTotalPriceFromGuest($guest_id){
		$totalPrice = 0;
		$orders = Order::where('guest_id', $guest_id)->get();
		foreach ($orders as $order) {
			$totalPrice += $order->total_price;
		}
		return $totalPrice;
	}
}