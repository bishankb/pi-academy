<div class="row">
    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('username') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('username', 'Username', ['class' => 'control-label']) !!}

            {!! Form::text('username', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Username']) !!}

            @if ($errors->has('username'))
                <div class="ui pointing red basic label"> {{$errors->first('username')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('email') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}

            {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Email' ]) !!}

            @if ($errors->has('email'))
                <div class="ui pointing red basic label"> {{$errors->first('email')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('password') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('password', 'Password', ['class' => 'control-label']) !!}

            <input type="text" name="password" class="form-control">

            @if ($errors->has('password'))
                <div class="ui pointing red basic label"> {{$errors->first('password')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('registration_number') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('registration_number', 'Registration Number', ['class' => 'control-label']) !!}

            {!! Form::text('registration_number', null, ['class' => 'form-control','required' => 'required', 'placeholder'=>'Registration Number']) !!}

            @if ($errors->has('registration_number'))
                <div class="ui pointing red basic label"> {{$errors->first('registration_number')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="form-group {{ $errors->has('active') ? ' has-error' : '' }} clearfix ">
    {!! Form::label('active', 'Active', ['class' => 'control-label']) !!}
    <div>
        <label class="toggle-switch">
            @if(isset($examination_credential->active))
                <input type="checkbox" name="active" @if($examination_credential->active == 1) checked @endif>
            @else
                <input type="checkbox" name="active">
            @endif
            <span class="toggle-slider round"></span>
        </label>
    </div>
    
    @if ($errors->has('active'))
        <div class="ui pointing red basic label"> {{$errors->first('active')}}</div>
    @endif
</div>