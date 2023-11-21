@extends('users.layouts.global')

@section('content')
    <section>
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('home') }}" class="btn btn-info">Show All Transactions</a>
            <a href="{{ route('show-deposit-form') }}" class="btn btn-success">Make Deposit</a>
        </div>

        <div class="table-responsive mt-4">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">TxID</th>
                        <th scope="col">UID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Amount</th> 
                        <th scope="col">Transaction Type</th>                     
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($deposits as $deposit)
                        <tr>
                            <td>{{ $deposit->id }}</td>
                            <td>{{ $deposit->user_id }}</td>
                            <td>{{ $deposit->user->name }}</td>
                            <td>{{ $deposit->amount }}</td>      
                            <td>{{ $deposit->transaction_type }}</td>               
                            <td>{{ $deposit->date }}</td>
                        </tr>
                   @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
