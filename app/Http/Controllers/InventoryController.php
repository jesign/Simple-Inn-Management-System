<?php

namespace App\Http\Controllers;

use App\Inventory;
use App\Item;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(){
    	$inventory = Inventory::with('item')->get();
    	return view('inventory.index', compact('inventory'));
    }

    public function store(Request $request){
    	$validatedData = $request->validate([
	        'item_id' => 'required',
	        'quantity' => 'required'
	    ]);

	    $checkInventory = Inventory::where('item_id', $request->item_id)->first();
	    if($checkInventory){
	    	session()->flash('message', 'Item Already Existed!');
	    	return back();
	    }

    	$inventory = new Inventory;
    	$inventory->item_id = $request->item_id; 
    	$inventory->quantity = $request->quantity; 
    	$inventory->save();
    	session()->flash('message', 'Added Successfully');

    	return back();
    }
}
