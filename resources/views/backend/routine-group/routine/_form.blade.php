<div class="row">
    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('english_routine_date') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('english_routine_date', 'English routine Date', ['class' => 'control-label']) !!}

            {!! Form::text('english_routine_date', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'English routine Date', 'id' => 'english_date_picker', 'data-conversion-type' => 'english-nepali']) !!}

            @if ($errors->has('english_routine_date'))
                <div class="ui pointing red basic label"> {{$errors->first('english_routine_date')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('nepali_routine_date') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('nepali_routine_date', 'Nepali routine Date', ['class' => 'control-label']) !!}

            {!! Form::text('nepali_routine_date', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Nepali routine Date', 'id' => 'nepali_date_picker', 'data-conversion-type' => 'nepali-english']) !!}

            @if ($errors->has('nepali_routine_date'))
                <div class="ui pointing red basic label"> {{$errors->first('nepali_routine_date')}}</div>
            @endif
        </div>
    </div>    
</div>

@foreach($routine_class_times as $key => $routine_class_time)
    <h4>
        {{ $loop->iteration }}) 
        Time: {{ \Carbon\Carbon::parse($routine_class_time->class_start_time)->format('h:i:s a') }} - {{ \Carbon\Carbon::parse($routine_class_time->class_end_time)->format('h:i:s a') }}
    </h4>

    <input type="hidden" name="class_time_id[]" value="{{ $routine_class_time->id }}">
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group required {{ $errors->has('teacher_id.'.$key) ? ' has-error' : '' }} clearfix ">
                {!! Form::label("teacher_id[$key]", 'Teacher', ['class' => 'control-label']) !!}

                {!! Form::select("teacher_id[$key]", $teachers, isset($routine) ? $routine->routineClass->where('class_time_id', $routine_class_time->id)->first()->teacher_id : null, ['class' => 'form-control custom-select', 'placeholder' => 'Select the teacher', 'requried' => 'required']) !!}

                @if ($errors->has('teacher_id.'.$key))
                    <div class="ui pointing red basic label"> {{$errors->first('teacher_id.'.$key)}}</div>
                @endif
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group required {{ $errors->has('subject.'.$key) ? ' has-error' : '' }} clearfix ">
                {!! Form::label("subject[$key]", 'Subject', ['class' => 'control-label']) !!}

                {!! Form::select("subject[$key]", $subjects, isset($routine) ? $routine->routineClass->where('class_time_id', $routine_class_time->id)->first()->subject : null, ['class' => 'form-control custom-select', 'placeholder' => 'Select the subject', 'requried' => 'required']) !!}

                @if ($errors->has('subject.'.$key))
                    <div class="ui pointing red basic label"> {{$errors->first('subject.'.$key)}}</div>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group required {{ $errors->has('topic_taught.'.$key) ? ' has-error' : '' }} clearfix ">
                {!! Form::label("topic_taught[$key]", 'Topic Taught', ['class' => 'control-label']) !!}
                {!! Form::textarea("topic_taught[$key]", isset($routine) ? $routine->routineClass->where('class_time_id', $routine_class_time->id)->first()->topic_taught : null, ['class' => 'form-control', 'placeholder'=>'Topic Taught', 'rows' => 4, 'requried' => 'required' ]) !!}

                @if ($errors->has('topic_taught.'.$key))
                    <div class="ui pointing red basic label"> {{$errors->first('topic_taught.'.$key)}}</div>
                @endif
            </div>
        </div>
    </div>
@endforeach
