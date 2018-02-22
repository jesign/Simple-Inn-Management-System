<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TransactionService;
use App\TrialBalance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TrialBalanceController extends Controller
{
    
    /* Using API */
    public function transactions()
    {
    	if(!request()->date){
    	    $dateChosen = Carbon::now()->format('Y-m-d');   
    	}else {
    	    $dateChosen = request()->date;
    	}

    	$transactions = TrialBalance::whereDate('created_at', '=', $dateChosen)->get();

    	return response()->json(compact('transactions', 'dateChosen'));
    }

    public function addTransaction(Request $request)
    {
    	$validatedData = $request->validate([
    		'title' => 'required',
	        'entry' => 'required',
	        'amount' => 'required'
	    ]);

    	$trialBalance = $this->storeTransaction($request);
	    
    	$success = true;

    	return response()->json(compact('trialBalance', 'success'));
    }

    public function updateTransaction(Request $request, $id)
    { 
        $validatedData = $request->validate([
            'title' => 'required',
            'entry' => 'required',
            'amount' => 'required'
        ]);

        

        $trialBalance = TrialBalance::find($id);

        $oldTotalBill = $trialBalance->current_total;

        /* Previous row's Total Bill */
        $previousTrialBalance = TrialBalance::where('created_at', '<', $trialBalance->created_at)->orderBy('created_at', 'desc')->first();
        if($previousTrialBalance){
            $previousCashTotal = $previousTrialBalance->current_total;
        }else {
            $previousCashTotal = 0;
        }

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

        $trialBalance->save();

        $success = true;

        TransactionService::updateSucceedingTransaction($trialBalance, $oldTotalBill);

        return response()->json(compact('trialBalance', 'success'));   
    }

    public function deleteTransaction(Request $request, $id){
        $trialBalance = TrialBalance::find($id);
        if($trialBalance){

            $transactionDate = $trialBalance->created_at->format('Y-m-d');
            $trialBalance->delete();

            if(TransactionService::reComputeTransaction($transactionDate)){
                $success = true;
                return response()->json(compact('success'));   
            }else {
                return response('Something went wrong, Try refreshing the page. If the problem persist please contact the tech guy.', 403);
            }
            
        }else {
            return response('Transaction not found.');
        }
    }
    
    /*
		* return TrialBalance
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

    public function reCompute(Request $request){
        if(!request()->date){
            $dateChosen = null;
        }else {
            $dateChosen = request()->date;
        }

        if(TransactionService::reComputeTransaction($dateChosen)){
            $success = true;
            return response()->json(compact('success'));   
        }else {
            return response('Something went wrong, Try refreshing the page. If the problem persist please contact the tech guy.', 403);
        }
    }
}
