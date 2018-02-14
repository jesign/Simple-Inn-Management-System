<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
        public function index(){
        	$items = Item::all();
        	return view('items.index', compact('items'));
        }

        public function store(Request $request){
        	$validatedData = $request->validate([
    	        'name' => 'required',
    	        'price' => 'required'
    	    ]);

        	$item = new Item;
        	$item->name = $request->name; 
        	$item->price = $request->price; 
        	$item->save();
        	session()->flash('message', 'Added Successfully');

        	return back();
        }

        public function edit($id){
        	$item = Item::find($id);
        	
        	return view('items.edit', compact('item'));
        }

        public function update(Request $request, $id){
        	$validatedData = $request->validate([
    	        'name' => 'required',
    	        'price' => 'required'
    	    ]);

        	$item = Item::find($id);
        	if($item){
        		$item->name = $request->name;
        		$item->price = $request->price;
        		$item->save();
        		session()->flash('message', 'Updated Successfully');
        	}else{
        		session()->flash('message', 'Room Type Not Found');	
        	}
        	return redirect('/room-types/');
        }

        public function destroy($id){
        	$item = Item::find($id);
        	if($item){
        		$item->delete();
        		session()->flash('message', 'Deleted Successfully');
        	}
        	return back();
        }
}
