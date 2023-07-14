@extends('layouts.exam')

@section('content')
    <div class="login-panel">
        <div class=" login-right">
            <h3>
               Activated
            </h3>
            <i class="fa fa-envelope fa-4x" aria-hidden="true"></i><br><br><br>
            <p>Your account has been activated !!!</p>
            <p>Please login to continue.</p>
            <p>Click <a href="{{ route('exam.login') }}" style="color: #ac143b;">here</a> to go to login page.</p>
        </div>   
    </div>
@endsection