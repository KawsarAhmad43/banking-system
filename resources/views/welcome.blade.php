@extends('layouts.global')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header text-center">
                <h2>Banking System</h2>
            </div>
            <div class="card-body text-center">
                <div class="d-flex justify-content-center mt-3">

                    <a href="{{ route('login') }}" class="btn btn-primary mr-2">Login</a>

                    <a href="{{ route('register') }}" class="btn btn-success">Register</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection