<div class="row">
    <div class="col-md-12">
        <div class="form-group required {{ $errors->has('title') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('title', 'Title', ['class' => 'control-label']) !!}

            {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Title']) !!}

            @if ($errors->has('title'))
                <div class="ui pointing red basic label"> {{$errors->first('title')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('description', 'Description', ['class' => 'control-label']) !!}

            {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder'=>'Description']) !!}

            @if ($errors->has('description'))
                <div class="ui pointing red basic label"> {{$errors->first('description')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group required {{ $errors->has('message') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('message', 'Message', ['class' => 'control-label']) !!}

            {!! Form::textarea('message', null, ['class' => 'form-control custom-textarea', 'required' => 'required', 'placeholder'=>'Message']) !!}

            @if ($errors->has('message'))
                <div class="ui pointing red basic label"> {{$errors->first('message')}}</div>
            @endif
        </div>
    </div>
</div>