@extends('layouts.exam')

@section('content')
	<div class="login-panel">
	    <h3>Login</h3>

	    <form class="login-form" action="{{ route('exam.login') }}" method="POST">
	        {{ csrf_field() }}

	        @if(session()->has('error_message'))
	            <div class="alert alert-danger alert-dismissable">
	            	<ul>
	            		<li>{{ session()->get('error_message') }}</li>
	            	</ul>
	            </div>
	        @endif

	        @if (isset($errors) && count($errors) > 0)
	            <div class="alert alert-danger alert-dismissable">
	                <ul>
	                    @foreach ($errors->all() as $error)
	                    	<li>{{ $error }}</li>
	                    @endforeach
	                </ul>
	            </div>
	        @endif

	        <div class="form-group">
	            <label class="control-label visible-ie8 visible-ie9" for="email">Email</label>
			    <input  class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} @if(config('pi-academy.virtual_keyboard') == 'on') virtual-keyboard @endif" type="text"  autocomplete="off"	placeholder="Email" name="email" value="{{ old('email') }}" required>
			</div>

			<div class="form-group required">
	            <label class="control-label visible-ie8 visible-ie9" for="email">IP Address</label>
			    <input type="password" placeholder="Password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} @if(config('pi-academy.virtual_keyboard') == 'on') virtual-keyboard @endif" name="password" required> 
			</div>
	       
	        <div class="form-actions">
	            <button type="submit" class="btn btn-primary btn-login">Login</button>
	            <a class="forget-password" href="{{ route('exam-password.request') }}">
	                Forgot Password?
	            </a>
	        </div>
	        <hr>
	        <div class="text-center">
	        	<h5>Don't have an account? <a class="signup-btn" href="{{ route('exam.show-register') }}">Sign Up</a></h5>
	        </div>
	    </form>
	</div>
@endsection

@section('exam-script')

    @include('exam-auth._login-js')
    
@endsection