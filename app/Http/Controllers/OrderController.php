<?php

namespace App\Http\Controllers;

use App\Inventory;
use App\Item;
use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request){
    	$validatedData = $request->validate([
	        'guest_id' => 'required',
	        'item_id' => 'required',
	        'quantity' => 'required',
	    ]);

    	$order = new Order;

    	$order->guest_id = $request->guest_id;
    	$order->item_id = $request->item_id;
    	$order->quantity = $request->quantity;

    	/* Get Total Price*/
    	$item = Item::find($request->item_id);
    	if($item){
    		$totalPrice = $item->price * $request->quantity;
    		$order->total_price = $totalPrice;
    	}else {
            session()->flash('order_error', 'Item not found');
            return back();
    	}
        /* Inventory */
        $inventory = Inventory::where('item_id', $item->id)->first();
        if($inventory->quantity < $order->quantity){
            session()->flash('order_error', "Not enough items in inventory, " . $item->name . " left: " . $inventory->quantity);
            return back();
        }


        $inventory->quantity = $inventory->quantity - $order->quantity;

        if(!$inventory){
            session()->flash('order_error', 'Item not found in inventory');
            return back();
        }


        $inventory->save();
    	$order->save();
    	return back();
    }
    public function destroy($id){
    	$order = Order::find($id);
    	if($order){
    		$order->delete();
    	}
    	return back();
    }
}
