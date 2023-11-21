<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index()
    {
        $user = auth()->user();
        $transactions = $user->transactions()->latest()->limit(10)->get();
        return view('users.home', ['transactions' => $transactions]);
    }
}
