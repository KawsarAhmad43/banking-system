@extends('users.layouts.global')

@section('content')
    <section>
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('home') }}" class="btn btn-info">Show All Transactions</a>
            <a href="{{ route('show-withdrawal-form') }}" class="btn btn-success">Make Withdrawals</a>
        </div>

        <div class="table-responsive mt-4">
            @if(count($withdrawals) > 0)
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">TxID</th>
                            <th scope="col">UID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Fee</th>
                            <th scope="col">Account Type</th>
                            <th scope="col">Transaction Type</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($withdrawals as $withdrawal)
                            <tr>
                                <td>{{ $withdrawal->id }}</td>
                                <td>{{ $withdrawal->user_id }}</td>
                                <td>{{ $withdrawal->user->name }}</td>
                                <td>{{ $withdrawal->amount }}</td>
                                <td>{{ $withdrawal->fee }}</td>
                                <td>{{ $withdrawal->user->account_type }}</td>
                                <td>{{ $withdrawal->transaction_type }}</td>
                                <td>{{ $withdrawal->date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="bg-light m-5 p-5 text-center text-danger">No withdrawals have been made.</p>
            @endif
        </div>
    </section>
@endsection
