<?php

namespace App\Http\Controllers\Api;

use App\Guest;
use App\Http\Controllers\Controller;
use App\RoomRate;
use App\RoomType;
use App\Services\ChargeService;
use App\Services\OrderService;
use App\Services\TransactionService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function guests(){

        if(!request()->date){
            $dateChosen = Carbon::now()->format('Y-m-d');   
        }else {
            $dateChosen = request()->date;
        }

        $guests = Guest::with('roomType')->whereDate('created_at', '=', $dateChosen)->get();
        $success = true;
        
        return response()->json(compact('guests' ,'dateChosen', 'success'));
    }

	public function checkout(Request $request, $id){
		$guest = Guest::find($id);

		if(!$guest){
            return response('Guest not found', 404);
		}
        if($guest->status == 'Check Out'){
            return response('Guest already checked out', 403);
        }

		$guest->status = 'Check Out';
		$guest->save();

        $description = 'Room ' . $guest->room_number . ' ' . $guest->roomType->name . ' type ';

        $transactionData = [
            'title' => 'Guest Checkout',
            'entry' => 'debit' ,
            'amount' => $guest->total_bill,
            'description' => $description
        ];

        TransactionService::addTransaction($transactionData);

        $success = true;
		return response()->json(compact('guest', 'success'));
	}
}
