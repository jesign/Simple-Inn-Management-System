<?php

namespace App\Http\Controllers;

use App\TrialBalance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TrialBalanceController extends Controller
{
    public function index()
    {
    	return view('trial-balance.index');
    }

    public function store(Request $request)
    {
    	$validatedData = $request->validate([
    		'title' => 'required',
	        'amount' => 'required',
	        'entry' => 'required',
	    ]);

    	$trialBalance = $this->storeTransaction($request);
    	session()->flash('message', 'Added Successfully');
    	return back();
    }

    /* Functions */
    /*
		* return TrialBalanceController
    */
    public function storeTransaction($request)
    {

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
