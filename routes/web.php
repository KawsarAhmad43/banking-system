<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('home');
    }

    return view('welcome');
})->name('landingPage');

Route::middleware(['auth'])->group(function () {
    Route::get('/user', [HomeController::class, 'index'])->name('home');
    Route::get('/make-deposit', [TransactionController::class, 'showMakeDepositForm'])->name('show-deposit-form');
    Route::post('/make-deposit', [TransactionController::class, 'storeDeposit'])->name('store-deposit');
    Route::get('/show-deposit', [TransactionController::class, 'showDeposit'])->name('show-deposit');
    Route::get('/make-withdrawal', [TransactionController::class, 'showWithdrawalForm'])->name('show-withdrawal-form');
    Route::post('/make-withdrawal', [TransactionController::class, 'storeWithdrawal'])->name('store-withdrawal');
    Route::get('/show-withdrawal', [TransactionController::class, 'showWithdrawal'])->name('show-withdrawal');
});

require __DIR__.'/auth.php';
