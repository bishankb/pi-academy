<div class="row">
    <div class="col-md-12">
        <div class="form-group required {{ $errors->has('shift') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('shift', 'Shift', ['class' => 'control-label']) !!}<br>
            <div class="mt-radio-inline">
                @foreach($shifts as $key => $shift)
                    <label class="mt-radio">
                        {!! Form::radio('shift', $key, null, ['class' => 'radio-custom']) !!} {{ $shift }}
                        <span></span>
                    </label>
                @endforeach
            </div>

            @if ($errors->has('shift'))
                <div class="ui pointing red basic label"> {{$errors->first('shift')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('name') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}

            {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Name']) !!}

            @if ($errors->has('name'))
                <div class="ui pointing red basic label"> {{$errors->first('name')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('order') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('order', 'Order', ['class' => 'control-label']) !!}

            {!! Form::number('order', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Order']) !!}

            @if ($errors->has('order'))
                <div class="ui pointing red basic label"> {{$errors->first('order')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('description', 'Description', ['class' => 'control-label']) !!}

            {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder'=>'Description', 'rows' => 4 ]) !!}

            @if ($errors->has('description'))
                <div class="ui pointing red basic label"> {{$errors->first('description')}}</div>
            @endif
        </div>
    </div>
</div>
