@extends('layouts.exam')

@section('content')
  <div class="login-panel">
    <h3>Reset Password</h3>

    <form class="login-form" action="{{ route('exam-password.email') }}" method="POST">
      {{ csrf_field() }}
      
      @if (session('status'))
        <div class="alert alert-dismissable alert-success form-group">
          <ul>
            <li>{{ session('status') }}</li>
          </ul>
        </div>
      @endif

      @if (isset($errors) && count($errors) > 0)
        <div class="alert alert-dismissable alert-danger form-group">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9" for="email">Email</label>
        <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" value="{{ old('email') }}"/>
      </div>
      <div class="form-group">
        <div class="form-actions">
          <a href="{{ route('exam.login') }}" class="btn btn-primary btn-outline">Back</a>
          <button type="submit" class="btn btn-login uppercase pull-right">Submit</button>
        </div>
      </div>
    </form>
  </div>
@endsection