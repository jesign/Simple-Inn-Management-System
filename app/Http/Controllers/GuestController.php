<?php

namespace App\Http\Controllers;

use App\Guest;
use App\RoomRate;
use App\RoomType;
use App\Services\ChargeService;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GuestController extends Controller
{
	public function index(){

        $roomTypes = RoomType::with('roomRates')->get()->toArray();
        $roomTypes = json_encode($roomTypes);
    	
    	return view('guest.index', compact('roomTypes'));
    }

    public function store(Request $request){
    	$validatedData = $request->validate([
	        'room_number' => 'required',
            'room_type' => 'required',
	        'room_rate_id' => 'required'
	    ]);

        $roomRate = RoomRate::find($request->room_rate_id);

    	$guest = new Guest;
    	$guest->room_number = $request->room_number;
        $guest->room_type_id = $request->room_type;
    	$guest->room_rate_id = $request->room_rate_id;
    	$guest->name = $request->name;
    	$guest->phone = $request->phone;
        $guest->check_in = Carbon::now();
    	$guest->check_out = Carbon::now()->addHour($roomRate->hours);
    	$guest->status = 'Check In';
    	$guest->save();

    	return back();
    }

    public function edit($id){
    	$guest = Guest::find($id);
		$guest->updateTotalBill();

    	$orders = OrderService::getOrdersFromGuest($guest->id);
    	$orderTotalPrice = OrderService::getTotalPriceFromGuest($guest->id);

    	$charges = ChargeService::getChargesFromGuest($guest->id);
    	$chargeTotalPrice = ChargeService::getTotalPriceFromGuest($guest->id);

    	if(!$guest){
    		return abort(404);
    	}

    	return view('guest.manage', compact('guest', 'orders', 'charges', 'orderTotalPrice', 'chargeTotalPrice'));
    }

    public function update(Request $request, $id){
    	$validatedData = $request->validate([
	        'room_number' => 'required',
	        'room_type' => 'required'
	    ]);

    	$guest = Guest::find($id);
    	$guest->name = $request->name;
    	$guest->phone = $request->phone;
    	$guest->room_type_id = $request->room_type;
    	$guest->room_number = $request->room_number;
    	$guest->check_in = !empty($request->check_in) ? Carbon::createFromFormat('Y-m-d\TH:i', $request->check_in)->format('Y-m-d H:i:s') : null;
    	$guest->check_out = !empty($request->check_out) ? Carbon::createFromFormat('Y-m-d\TH:i', $request->check_out)->format('Y-m-d H:i:s') : null;

    	if($guest->check_out){
    		$guest->status = "Check Out";
    	}else {
    		$guest->status = "Check In";
    	}

    	$guest->save();

    	session()->flash('updated', 'Updated Successfully.');
    	return back();
	}

	public function destroy(Request $request, $id){
		$guest = Guest::find($id);
		if($guest){
			$guest->delete();
			session()->flash('message', 'Guest Successfully Deleted.');
		}
		return back();
	}

	public function checkOut(Request $request, $id){
		$guest = Guest::find($id);

		if(!$guest){

		}
		$guest->check_out = Carbon::now();
		$guest->status = 'Check Out';
		session()->flash('message', 'Room ' . $guest->room_number . ' has checked out.');
		$guest->save();
		return back();
	}

    public function getGuests(){

        if(!request()->date){
            $dateChosen = Carbon::now()->format('Y-m-d');   
        }else {
            $dateChosen = request()->date;
        }

        $guests = Guest::with('roomType')->whereDate('created_at', '=', $dateChosen)->get();

        
        return response()->json(compact('guests' ,'dateChosen'));
    }
}
