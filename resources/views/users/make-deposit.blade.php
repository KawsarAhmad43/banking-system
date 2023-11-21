@extends('users.layouts.global')

@section('content')
    <section class="mt-4">
        <div class="d-flex justify-content-between">
            <a href="{{ route('home') }}" class="btn btn-info">Show All Transactions</a>
            <a href="{{ route('show-deposit') }}" class="btn btn-success">Show Deposits</a>
        </div>

        {{-- Display success message if it exists --}}
        @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        {{-- Form for making a deposit --}}
        <form action="{{ route('store-deposit') }}" method="post" class="mt-3">
            @csrf
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">

            <div class="mb-3">
                <label for="amount" class="form-label">Amount:</label>
                <input type="number" name="amount" id="amount" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-warning">Make Deposit</button>
        </form>
    </section>
@endsection