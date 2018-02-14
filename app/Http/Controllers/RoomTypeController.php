<?php

namespace App\Http\Controllers;

use App\RoomRate;
use App\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    public function index(){
    	$roomTypes = RoomType::all();
    	return view('roomtypes.index', compact('roomTypes'));
    }

    public function show($id){
        $roomType = RoomType::find($id);
        if(!$roomType){
            return abort(404);
        }

        return view('roomtypes.show', compact('roomType'));   
    }

    public function store(Request $request){
    	$validatedData = $request->validate([
	        'name' => 'required',
	    ]);

    	$roomType = new RoomType;
    	$roomType->name = $request->name; 
    	$roomType->save();
    	session()->flash('message', 'Added Successfully');

    	return back();
    }

    public function edit($id){
    	$roomType = RoomType::find($id);
    	
    	return view('roomtypes.edit', compact('roomType'));
    }

    public function update(Request $request, $id){
    	$validatedData = $request->validate([
	        'name' => 'required',
	    ]);

    	$roomType = RoomType::find($id);
    	if($roomType){
    		$roomType->name = $request->name;
    		$roomType->save();
    		session()->flash('message', 'Updated Successfully');
    	}else{
    		session()->flash('message', 'Room Type Not Found');	
    	}
    	return redirect('/room-types/');
    }

    public function destroy($id){
    	$roomType = RoomType::find($id);
    	if($roomType){
    		$roomType->delete();
    		session()->flash('message', 'Deleted Successfully');
    	}
    	return back();
    }

    public function addRoomRate(Request $request){
        $validatedData = $request->validate([
            'name' => 'required',
            'hours' => 'required',
            'price' => 'required',
            'room_type_id' => 'required'
        ]);

        $roomRate = new RoomRate;
        $roomRate->name = $request->name;
        $roomRate->hours = $request->hours;
        $roomRate->price = $request->price;
        $roomRate->room_type_id = $request->room_type_id;
        $roomRate->save();

        session()->flash('message', 'Room Rate added');
        return back();
    }

    public function editRoomRate(Request $request, $id){
        $roomRate = RoomRate::find($id);
        if(!$roomRate){
            return abort(404);
        }
        return view('roomtypes.room-rate-edit', compact('roomRate'));
    }

    public function updateRoomRate(Request $request, $id){
        $validatedData = $request->validate([
            'name' => 'required',
            'price' => 'required'
        ]);

        $roomRate = RoomRate::find($id);
        if($roomRate){
            $roomRate->name = $request->name;
            $roomRate->price = $request->price;
            $roomRate->save();
            session()->flash('message', 'Updated Successfully');
        }else{
            session()->flash('message', 'Room Rate Not Found'); 
        }

        return back();
    }
}
