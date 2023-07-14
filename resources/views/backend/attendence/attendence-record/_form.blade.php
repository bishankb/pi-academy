<div class="row">
    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('english_attendence_date') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('english_attendence_date', 'English Attendence Date', ['class' => 'control-label']) !!}

            {!! Form::text('english_attendence_date', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'English Attendence Date', 'id' => 'english_date_picker', 'data-conversion-type' => 'english-nepali']) !!}

            @if ($errors->has('english_attendence_date'))
                <div class="ui pointing red basic label"> {{$errors->first('english_attendence_date')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('nepali_attendence_date') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('nepali_attendence_date', 'Nepali Attendence Date', ['class' => 'control-label']) !!}

            {!! Form::text('nepali_attendence_date', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Nepali Attendence Date', 'id' => 'nepali_date_picker', 'data-conversion-type' => 'nepali-english']) !!}

            @if ($errors->has('nepali_attendence_date'))
                <div class="ui pointing red basic label"> {{$errors->first('nepali_attendence_date')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6" id="hasTakenLeave_div">
        <div class="form-group {{ $errors->has('has_taken_leave') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('has_taken_leave', 'Taken Leave', ['class' => 'control-label']) !!}
            <div>
                <label class="toggle-switch">
                    
                    {!! Form::checkbox('has_taken_leave', null, null, ['id' => 'has_taken_leave']) !!}

                    <span class="toggle-slider round"></span>
                </label>
            </div>
            
            @if ($errors->has('has_taken_leave'))
                <div class="ui pointing red basic label"> {{$errors->first('has_taken_leave')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6" id="leaveReason_div">
        <div class="form-group {{ $errors->has('leave_reason') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('leave_reason', 'Leave Reason', ['class' => 'control-label']) !!}

            {!! Form::text('leave_reason', null, ['class' => 'form-control', 'placeholder'=>'Leave Reason', 'id' => 'leave_reason']) !!}

            @if ($errors->has('leave_reason'))
                <div class="ui pointing red basic label"> {{$errors->first('leave_reason')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6" id="hasTakenHoliday_div">
        <div class="form-group {{ $errors->has('is_holiday') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('is_holiday', 'Holiday', ['class' => 'control-label']) !!}
            <div>
                <label class="toggle-switch">
                    
                    {!! Form::checkbox('is_holiday', null, null, ['id' => 'is_holiday']) !!}

                    <span class="toggle-slider round"></span>
                </label>
            </div>
            
            @if ($errors->has('is_holiday'))
                <div class="ui pointing red basic label"> {{$errors->first('is_holiday')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6" id="holidayReason_div">
        <div class="form-group {{ $errors->has('holiday_reason') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('holiday_reason', 'Holiday Ocassion', ['class' => 'control-label']) !!}

            {!! Form::text('holiday_reason', null, ['class' => 'form-control', 'placeholder'=>'Holiday Ocassion', 'id' => 'holiday_reason']) !!}

            @if ($errors->has('holiday_reason'))
                <div class="ui pointing red basic label"> {{$errors->first('holiday_reason')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6" id="arrivalTime_div">
        <div class="form-group {{ $errors->has('arrival_time') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('arrival_time', 'Arrival Time', ['class' => 'control-label']) !!}

            {!! Form::text('arrival_time', null, ['class' => 'form-control arrival-time', 'placeholder'=>'Arrival Time', 'id' => 'arrival_time']) !!}
            

            @if ($errors->has('arrival_time'))
                <div class="ui pointing red basic label"> {{$errors->first('arrival_time')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6" id="departureTime_div">
        <div class="form-group {{ $errors->has('departure_time') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('departure_time', 'Departure Time', ['class' => 'control-label']) !!}

            {!! Form::text('departure_time', null, ['class' => 'form-control departure-time', 'placeholder'=>'Departure Time', 'id' => 'departure_time']) !!}
            

            @if ($errors->has('departure_time'))
                <div class="ui pointing red basic label"> {{$errors->first('departure_time')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6" id="hasTakenGap_div">
        <div class="form-group {{ $errors->has('has_taken_gap') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('has_taken_gap', 'Taken Gap', ['class' => 'control-label']) !!}
            <div>
                <label class="toggle-switch">
                    
                    {!! Form::checkbox('has_taken_gap', null, null, ['id' => 'has_taken_gap']) !!}

                    <span class="toggle-slider round"></span>
                </label>
            </div>
            
            @if ($errors->has('has_taken_gap'))
                <div class="ui pointing red basic label"> {{$errors->first('has_taken_gap')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6" id="gapDepartureTime_div">
        <div class="form-group {{ $errors->has('gap_departure_time') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('gap_departure_time', 'Gap Departure Time', ['class' => 'control-label']) !!}

            {!! Form::text('gap_departure_time', null, ['class' => 'form-control custom-time', 'placeholder'=>'Gap Departure Time', 'id' => 'gap_departure_time']) !!}
            

            @if ($errors->has('gap_departure_time'))
                <div class="ui pointing red basic label"> {{$errors->first('gap_departure_time')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6" id="gapArrivalTime_div">
        <div class="form-group {{ $errors->has('gap_arrival_time') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('gap_arrival_time', 'Gap Arrival Time', ['class' => 'control-label']) !!}

            {!! Form::text('gap_arrival_time', null, ['class' => 'form-control custom-time', 'placeholder'=>'Gap Arrival Time', 'id' => 'gap_arrival_time']) !!}
            

            @if ($errors->has('gap_arrival_time'))
                <div class="ui pointing red basic label"> {{$errors->first('gap_arrival_time')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6" id="gapReason_div">
            <div class="form-group {{ $errors->has('gap_reason') ? ' has-error' : '' }} clearfix ">
                {!! Form::label('gap_reason', 'Gap Reason', ['class' => 'control-label']) !!}

                {!! Form::text('gap_reason', null, ['class' => 'form-control', 'placeholder'=>'Gap Reason', 'id' => 'gap_reason']) !!}

                @if ($errors->has('gap_reason'))
                    <div class="ui pointing red basic label"> {{$errors->first('gap_reason')}}</div>
                @endif
            </div>
        </div>
    </div>
</div>