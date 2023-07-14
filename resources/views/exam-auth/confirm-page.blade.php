@extends('layouts.exam')

@section('content')
	<div class="login-panel">
	    <h3>
        	@if (request('old_user') == 'yes')
                Account activation is pending !!
            @else
                Please confirm your registration.
            @endif
        </h3>

	    <p>
			Confirmation link has been sent to your email address.<br>
			Please check your inbox and verify your registration.
		</p>

		<hr>
		
		<h3>Not getting email?</h3>
		<p>Please check your bulk mail or spam folder first. 
			<form action="{{ route('email.reverify') }}" method="POST">
				@csrf
				<input type="hidden" name="email" value="{{request('email')}}">
				<span>Click the button to resend the email. (It may take a few minutes to arrive.)</span><br><br>
				<button type="submit" class="btn btn-primary btn-login">Resend</button>
			</form>
		</p>
	</div>
@endsection