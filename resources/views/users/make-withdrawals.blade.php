@extends('users.layouts.global')

@section('content')
    <section class="mt-4">
        <div class="d-flex justify-content-between">
            <a href="{{ route('home') }}" class="btn btn-info">Show All Transactions</a>
            <a href="{{ route('show-withdrawal') }}" class="btn btn-success">Show Withdrawals</a>
        </div>
        
        <div class="mb-3 mt-3 bg-secondary text-white p-2">
            <strong>Balance Remaining:</strong> ${{ auth()->user()->balance }}
        </div> 
  
        @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
    @endif
        <form action="{{ route('store-withdrawal') }}" method="post" class="mt-3">
            @csrf
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">

            <div class="mb-3">
                <label for="amount" class="form-label">Withdrawal Amount:</label>
                <input type="number" name="amount" id="amount" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Withdraw</button>
        </form>
    </section>
@endsection
