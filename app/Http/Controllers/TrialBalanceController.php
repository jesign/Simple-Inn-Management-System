<?php

namespace App\Http\Controllers;

use App\TrialBalance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TrialBalanceController extends Controller
{
    public function index(){
    	return view('trial-balance.index');
    }

    public function store(Request $request){
    	$validatedData = $request->validate([
    		'title' => 'required',
	        'amount' => 'required',
	        'entry' => 'required',
	    ]);

    	$trialBalance = $this->storeTransaction($request);
    	session()->flash('message', 'Added Successfully');
    	return back();
    }

    /* Using API */
    public function getTransactions(){
    	if(!request()->date){
    	    $dateChosen = Carbon::now()->format('Y-m-d');   
    	}else {
    	    $dateChosen = request()->date;
    	}

    	$transactions = TrialBalance::whereDate('created_at', '=', $dateChosen)->get();

    	return response()->json(compact('transactions', 'dateChosen'));
    }

    public function addTransaction(Request $request){
    	$validatedData = $request->validate([
    		'title' => 'required',
	        'entry' => 'required',
	        'amount' => 'required'
	    ]);

    	$trialBalance = $this->storeTransaction($request);
	    
    	$success = true;

    	return response()->json(compact('trialBalance', 'success'));
    }

    /* Functions */
    /*
		* return TrialBalanceController
    */
    public function storeTransaction($request){

        $previousTrialBalance = TrialBalance::orderBy('created_at', 'desc')->first();
        if($previousTrialBalance){
            $previousCashTotal = $previousTrialBalance->current_total;
        }else {
            $previousCashTotal = 0;
        }

        $trialBalance = new TrialBalance;
	    
	    $trialBalance->title = $request->title;
    	if($request->entry == 'credit'){
    		$trialBalance->credit = $request->amount;
            $trialBalance->current_total = $previousCashTotal - $request->amount;
    	}else {
    		$trialBalance->debit = $request->amount;
            $trialBalance->current_total = $previousCashTotal + $request->amount;
    	}
    	if($request->description){
    		$trialBalance->description = $request->description;
    	}	

    	return $trialBalance->save();
    }
}
