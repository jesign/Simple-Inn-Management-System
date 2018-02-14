<?php

namespace App\Http\Controllers;

use App\Charge;
use Illuminate\Http\Request;

class ChargeController extends Controller
{
    public function store(Request $request){
    	$validatedData = $request->validate([
	        'guest_id' => 'required',
	        'name' => 'required',
	        'price' => 'required|numeric',
	    ]);

    	$charge = new Charge;

    	$charge->guest_id = $request->guest_id;
    	$charge->name = $request->name;
    	$charge->description = $request->description;
    	$charge->price = $request->price;

    	$charge->save();
    	return back();
    }

    public function destroy($id){
    	$charge = Charge::find($id);
    	if($charge){
    		$charge->delete();
    	}
    	return back();
    }
}
