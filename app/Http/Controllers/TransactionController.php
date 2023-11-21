<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TransactionController extends Controller
{
    
        public function showDeposit()
    {
        $user = auth()->user();
        $deposits = $user->transactions()->where('transaction_type', 'deposit')->get();
        return view('users.show-deposit', ['deposits' => $deposits]);
    }

    public function showMakeDepositForm()
    {
        return view('users.make-deposit');
    }
    
    public function storeDeposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);
        $user = auth()->user();
        $deposit = new Transaction([
            'user_id' => $user->id,
            'transaction_type' => 'deposit',
            'amount' => $request->input('amount'),
            'fee' => 0.00,
            'date' => now(),
        ]);
        $deposit->save();

        $user->balance += $request->input('amount');
        $user->save();
        return redirect(route('show-deposit-form'))->with('success', 'Successfully Deposited');
    }


    public function showWithdrawal(){
        $user = auth()->user();
        $withdrawals = $user->transactions()->where('transaction_type', 'withdrawal')->get();
        return view('users.show-withdrawals', ['withdrawals' => $withdrawals]);
    }


    public function showWithdrawalForm()
    {
        return view('users.make-withdrawals');
    }
    

    public function storeWithdrawal(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);
        $user = auth()->user();
    
        $withdrawalFee = $user->account_type === 'Individual' ? 0.015 : 0.025;
        if ($user->account_type === 'Individual') {
            if (now()->dayOfWeek === 5) { 
                $withdrawalFee = 0;
            }
            if ($request->input('amount') <= 1000) {
                $withdrawalFee = 0;
            }
            $withdrawalsThisMonth = $user->withdrawals()
                ->where('transaction_type', 'withdrawal')
                ->whereMonth('created_at', now()->month)
                ->sum('amount');
    
            if ($withdrawalsThisMonth + $request->input('amount') <= 5000) {
                $withdrawalFee = 0;
            }
        }
        if ($user->account_type === 'Business') {
            $totalWithdrawals = $user->withdrawals()
                ->where('transaction_type', 'withdrawal')
                ->sum('amount');
            if ($totalWithdrawals >= 50000) {
                $withdrawalFee = 0.015;
            }
        }  
        $actualWithdrawalAmount = $request->input('amount') * (1 - $withdrawalFee);  
        if ($actualWithdrawalAmount + $withdrawalFee > $user->balance) {
            return redirect(route('show-withdrawal-form'))->with('error', 'Insufficient funds for withdrawal');
        }
        $withdrawal = new Transaction([
            'user_id' => $user->id,
            'transaction_type' => 'withdrawal',
            'amount' => $actualWithdrawalAmount,
            'fee' => $withdrawalFee,
            'date' => now(),
        ]);
        $withdrawal->save();
    
        $user->balance -= $actualWithdrawalAmount + $withdrawalFee;
        $user->save();
        return redirect(route('show-withdrawal-form'))->with('success', 'Withdrawal successful');
    }
    

}
