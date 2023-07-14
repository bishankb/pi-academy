<div class="row">
    <div class="col-md-12">
        <div class="form-group required {{ $errors->has('name') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}

            {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Name']) !!}

            @if ($errors->has('name'))
                <div class="ui pointing red basic label"> {{$errors->first('name')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group {{ $errors->has('college_name') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('college_name', 'College Name', ['class' => 'control-label']) !!}

            {!! Form::text('college_name', null, ['class' => 'form-control', 'placeholder'=>'College Name']) !!}

            @if ($errors->has('college_name'))
                <div class="ui pointing red basic label"> {{$errors->first('college_name')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('marks_obtained') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('marks_obtained', 'Grade / Percentage', ['class' => 'control-label']) !!}

            {!! Form::text('marks_obtained', null, ['class' => 'form-control', 'placeholder'=>'Grade / Percentage']) !!}

            @if ($errors->has('marks_obtained'))
                <div class="ui pointing red basic label"> {{$errors->first('marks_obtained')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('academic_status') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('academic_status', 'Academic Status', ['class' => 'control-label']) !!}<br>
            <div class="mt-radio-inline">
                <label class="mt-radio">
                    {!! Form::radio('academic_status', '0', null, ['class' => 'radio-custom']) !!} +2 Running
                <span></span>
                </label>
                <label class="mt-radio">
                    {!! Form::radio('academic_status', '1', null, ['class' => 'radio-custom']) !!} Passed
                    <span></span>
                </label>
            </div>
            @if ($errors->has('academic_status'))
                <div class="ui pointing red basic label"> {{$errors->first('academic_status')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('english_visited_date') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('english_visited_date', 'English Visited Date', ['class' => 'control-label']) !!}

            {!! Form::text('english_visited_date', isset($visitor) ? $visitor->english_visited_date : \Carbon\Carbon::now()->format('Y-m-d'), ['class' => 'form-control', 'placeholder'=>'English Visited Date', 'id' => 'english_date_picker', 'data-conversion-type' => 'english-nepali']) !!}

            @if ($errors->has('english_visited_date'))
                <div class="ui pointing red basic label"> {{$errors->first('english_visited_date')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group {{ $errors->has('nepali_visited_date') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('nepali_visited_date', 'Nepali Visited Date', ['class' => 'control-label']) !!}

            {!! Form::text('nepali_visited_date', isset($visitor) ? $visitor->nepali_visited_date : $current_nepali_date, ['class' => 'form-control', 'placeholder'=>'Nepali Visited Date', 'id' => 'nepali_date_picker', 'data-conversion-type' => 'nepali-english']) !!}

            @if ($errors->has('nepali_visited_date'))
                <div class="ui pointing red basic label"> {{$errors->first('nepali_visited_date')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group {{ $errors->has('visited_time') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('visited_time', 'Visited Time', ['class' => 'control-label']) !!}

            {!! Form::text('visited_time', isset($visitor) ? $visitor->visited_time : \Carbon\Carbon::now()->format('h:i a'), ['class' => 'form-control custom-time', 'placeholder'=>'Visited Time']) !!}

            @if ($errors->has('visited_time'))
                <div class="ui pointing red basic label"> {{$errors->first('visited_time')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group {{ $errors->has('counselled_by') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('counselled_by', 'Counselled By', ['class' => 'control-label']) !!}

            {!! Form::select('counselled_by', $counsellers, null,['id'=>'counselled_by', 'class' => 'form-control custom-select', 'placeholder' => 'Select the counserller / teacher']) !!}

            @if ($errors->has('counselled_by'))
                <div class="ui pointing red basic label"> {{$errors->first('counselled_by')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="form-group {{ $errors->has('is_registered') ? ' has-error' : '' }} clearfix ">
    {!! Form::label('is_registered', 'Registration/Pre-Booking Done', ['class' => 'control-label']) !!}
    <div>
        <label class="toggle-switch">
            
            {!! Form::checkbox('is_registered', null) !!}

            <span class="toggle-slider round"></span>
        </label>
    </div>
    
    @if ($errors->has('is_registered'))
        <div class="ui pointing red basic label"> {{$errors->first('is_registered')}}</div>
    @endif
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('is_accompanied') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('is_accompanied', 'Is Accompanied', ['class' => 'control-label']) !!}
            <div>
                <label class="toggle-switch">
                    
                    {!! Form::checkbox('is_accompanied', null, null, ['id' => 'is_accompanied']) !!}

                    <span class="toggle-slider round"></span>
                </label>
            </div>
            
            @if ($errors->has('is_accompanied'))
                <div class="ui pointing red basic label"> {{$errors->first('is_accompanied')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6 required" id="accompaniedBy_div">
        <div class="form-group {{ $errors->has('accompanied_by') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('accompanied_by', 'Accompanied By', ['class' => 'control-label']) !!}

            {!! Form::text('accompanied_by', null, ['class' => 'form-control', 'placeholder'=>'Accompanied By', 'id' => 'accompanied_by']) !!}

            @if ($errors->has('accompanied_by'))
                <div class="ui pointing red basic label"> {{$errors->first('accompanied_by')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('interested_course') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('interested_course', 'Interested Course', ['class' => 'control-label']) !!}

            {!! Form::select('interested_course', $interested_courses, null, ['id'=>'interested_course', 'class' => 'form-control custom-select', 'placeholder' => 'Select the course']) !!}

            @if ($errors->has('interested_course'))
                <div class="ui pointing red basic label"> {{$errors->first('interested_course')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('interested_stream') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('interested_stream', 'Interested Stream', ['class' => 'control-label']) !!}

            {!! Form::text('interested_stream', null, ['class' => 'form-control', 'placeholder'=>'Interested Stream']) !!}

            @if ($errors->has('interested_stream'))
                <div class="ui pointing red basic label"> {{$errors->first('interested_stream')}}</div>
            @endif
        </div>
    </div>
</div>