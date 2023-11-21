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
        $withdrawalAmount = $request->input('amount');
        $withdrawalFee = $this->calculateWithdrawalFee($user, $withdrawalAmount);
        $totalWithdrawal = $withdrawalAmount + $withdrawalFee;

        if ($totalWithdrawal > $user->balance) {
            return redirect(route('show-withdrawal-form'))->with('error', 'Insufficient funds for withdrawal');
        }

        $user->balance -= $totalWithdrawal;
        $user->save();

        $withdrawal = new Transaction([
            'user_id' => $user->id,
            'transaction_type' => 'withdrawal',
            'amount' => $withdrawalAmount,
            'fee' => $withdrawalFee,
            'date' => now(),
        ]);
        $withdrawal->save();

        return redirect(route('show-withdrawal-form'))->with('success', 'Withdrawal successful');
    }

    private function calculateWithdrawalFee($user, $amount)
    {
        $withdrawalFeeRate = $user->account_type === 'Individual' ? 0.015 : 0.025;

        if ($user->account_type === 'Individual') {
            // Each Friday withdrawal is free
            if (now()->dayOfWeek === Carbon::FRIDAY) {
                return 0;
            }

            // The first 1K withdrawal per transaction is free
            if ($amount <= 1000) {
                return 0;
            }

            // The first 5K withdrawal each month is free
            $withdrawalsThisMonth = $user->withdrawals()
                ->where('transaction_type', 'withdrawal')
                ->whereMonth('created_at', now()->month)
                ->sum('amount');

            if ($withdrawalsThisMonth + $amount <= 5000) {
                return 0;
            }
        }

        // Decrease the withdrawal fee to 0.015% for Business accounts after a total withdrawal of 50K
        if ($user->account_type === 'Business' && $user->withdrawals()->sum('amount') >= 50000) {
            $withdrawalFeeRate = 0.015;
        }

        // Calculate the withdrawal fee based on the provided rate
        $withdrawalFee = $amount * $withdrawalFeeRate;

        return $withdrawalFee;
    }

}
