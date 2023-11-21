@extends('users.layouts.global')

@section('content')
    <section>
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('show-withdrawal') }}" class="btn btn-info">Show Withdrawals</a>
            <a href="{{ route('show-deposit') }}" class="btn btn-success">Show Deposits</a>
        </div>

        <div class="table-responsive mt-4">
            @if(count($transactions) > 0)
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
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->id }}</td>
                                <td>{{ $transaction->user_id }}</td>
                                <td>{{ $transaction->user->name }}</td>
                                <td>{{ $transaction->amount }}</td>
                                <td>{{ $transaction->fee }}</td>
                                <td>{{ $transaction->user->account_type }}</td>
                                <td>{{ $transaction->transaction_type }}</td>
                                <td>{{ $transaction->date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="bg-light m-5 p-5 text-center text-danger">No transactions have been made.</p>
            @endif
        </div>
    </section>
@endsection
