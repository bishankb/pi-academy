<div class="row">
    <div class="col-md-6" id="arrivalTime_div">
        <div class="form-group required {{ $errors->has('class_start_time') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('class_start_time', 'Start Time', ['class' => 'control-label']) !!}

            {!! Form::text('class_start_time', null, ['class' => 'form-control custom-time', 'placeholder'=>'Start Time', 'requried' => 'required']) !!}
            

            @if ($errors->has('class_start_time'))
                <div class="ui pointing red basic label"> {{$errors->first('class_start_time')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6" id="departureTime_div">
        <div class="form-group required {{ $errors->has('class_end_time') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('class_end_time', 'End Time', ['class' => 'control-label']) !!}

            {!! Form::text('class_end_time', null, ['class' => 'form-control custom-time', 'placeholder'=>'End Time', 'requried' => 'required']) !!}
            

            @if ($errors->has('class_end_time'))
                <div class="ui pointing red basic label"> {{$errors->first('class_end_time')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
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
