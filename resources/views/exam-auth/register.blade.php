@extends('layouts.exam')

@section('content')
	<div class="login-panel">
	    <h3>Registration</h3>

	    <form class="login-form" action="{{ route('exam.register') }}" method="POST">
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
	            <label class="control-label visible-ie8 visible-ie9" for="username">Name</label>
			    <input  class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" type="text"  autocomplete="off"	placeholder="Name" name="username" value="{{ old('username') }}" required>
			</div>

	        <div class="form-group">
	            <label class="control-label visible-ie8 visible-ie9" for="email">Email</label>
			    <input  class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" type="text"  autocomplete="off"	placeholder="Email" name="email" value="{{ old('email') }}" required>
			</div>

			<div class="form-group required">
	            <label class="control-label visible-ie8 visible-ie9" for="password">Password</label>
			    <input type="password" placeholder="Password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required> 
			</div>

			<div class="form-group required">
	            <label class="control-label visible-ie8 visible-ie9" for="password_confirmation">Confirm Password</label>
			    <input type="password" placeholder="Password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" required> 
			</div>
	       
	        <div class="form-actions">
	            <button type="submit" class="btn btn-primary btn-login">Register</button>
	        </div>
	    </form>
	</div>
@endsection