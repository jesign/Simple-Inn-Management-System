<?php 
namespace App\Services;

use App\TrialBalance;
use Carbon\Carbon;

class TransactionService{
    public static function addTransaction($data)
    {
        $previousTrialBalance = TrialBalance::orderBy('created_at', 'desc')->first();
        if($previousTrialBalance){
            $previousCashTotal = $previousTrialBalance->current_total;
        }else {
            $previousCashTotal = 0;
        }

        $trialBalance = new TrialBalance;
	    
	    $trialBalance->title = $data['title'];
    	if($data['entry'] == 'credit'){
    		$trialBalance->credit = $data['amount'];
            $trialBalance->current_total = $previousCashTotal - $data['amount'];
    	}else {
    		$trialBalance->debit = $data['amount'];
            $trialBalance->current_total = $previousCashTotal + $data['amount'];
    	}
    	if($data['description']){
    		$trialBalance->description = $data['description'];
    	}	

    	return $trialBalance->save();
    }  

    /*
    * update all succeeding transaction to compute each of its current_total field
    */

    public static function updateSucceedingTransaction(TrialBalance $trialBalance, $oldTotalBill)
    {
        /* New Total Bill - Old Total Bill*/
    	$difference = $trialBalance->current_total - $oldTotalBill;
        if($difference != 0){
            $transactions = TrialBalance::where('created_at', '>', $trialBalance->created_at)->get();
            foreach ($transactions as $transaction) {
                $transaction->current_total = $transaction->current_total + $difference;
                $transaction->save();
            }    
        }
        
        return;
    }

    public static function reComputeTransaction($date = null){
        if ($date) {
            $date = Carbon::createFromFormat('Y-m-d', $date)->setTime(0,0,0);
            // dd($date);
            $previousTotalBill = TrialBalance::where('created_at', '<', $date)->orderBy('created_at', 'desc')->first()->current_total;
            $transactions = TrialBalance::where('created_at', '>', $date)->get();
        } else {
            $transactions = TrialBalance::all();
        }

        $totalBill = $date ? $previousTotalBill : 0;
    
        foreach ($transactions as $transaction) {
            $oldTotal = $transaction->current_total;
            if($transaction->debit != 0) {
                $newTotal = $totalBill + $transaction->debit;
            } else {
                $newTotal = $totalBill - $transaction->credit;
            }
            
            $transaction->current_total = $newTotal;
            $totalBill = $transaction->current_total;

            /* Only trigger update query when there's a difference*/
            if($oldTotal != $newTotal){
                $transaction->save();
            }
        }
        return true;
    }
}