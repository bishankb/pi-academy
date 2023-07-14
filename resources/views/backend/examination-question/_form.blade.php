<div class="row">
    <div class="col-md-12">
        <div class="form-group required {{ $errors->has('subject') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('subject', 'Subject', ['class' => 'control-label']) !!}

            {!! Form::select('subject', $subjects, null,['class' => 'form-control custom-select subject', 'placeholder' => 'Select the subject', 'id' => 'subject', 'requried' => 'required']) !!}

            @if ($errors->has('subject'))
                <div class="ui pointing red basic label"> {{$errors->first('subject')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group required {{ $errors->has('marks') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('marks', 'Marks', ['class' => 'control-label']) !!}<br>
            <div class="mt-radio-inline">
                @foreach($marks as $key => $mark)
                    <label class="mt-radio">
                        {!! Form::radio('marks', $key, null, ['class' => 'radio-custom marks']) !!} {{ $mark }}
                        <span></span>
                    </label>
                @endforeach
            </div>

            @if ($errors->has('marks'))
                <div class="ui pointing red basic label"> {{$errors->first('marks')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group required {{ $errors->has('question') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('question', 'Question', ['class' => 'control-label']) !!}

            {!! Form::textarea('question', null, ['class' => 'form-control custom-textarea', 'required' => 'required', 'placeholder'=>'Question', 'rows' => 4 ]) !!}

            @if ($errors->has('question'))
                <div class="ui pointing red basic label"> {{$errors->first('question')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('option1') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('option1', 'Option 1', ['class' => 'control-label']) !!}

            {!! Form::textarea('option1', null, ['class' => 'form-control custom-textarea', 'required' => 'required', 'placeholder'=>'Option 1', 'rows' => 4 ]) !!}

            @if ($errors->has('option1'))
                <div class="ui pointing red basic label"> {{$errors->first('option1')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('option2') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('option2', 'Option 2', ['class' => 'control-label']) !!}

            {!! Form::textarea('option2', null, ['class' => 'form-control custom-textarea', 'required' => 'required', 'placeholder'=>'Option 2', 'rows' => 4 ]) !!}

            @if ($errors->has('option2'))
                <div class="ui pointing red basic label"> {{$errors->first('option2')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('option3') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('option3', 'Option 3', ['class' => 'control-label']) !!}

            {!! Form::textarea('option3', null, ['class' => 'form-control custom-textarea', 'required' => 'required', 'placeholder'=>'Option 3', 'rows' => 4 ]) !!}

            @if ($errors->has('option3'))
                <div class="ui pointing red basic label"> {{$errors->first('option3')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('option4') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('option4', 'Option 4', ['class' => 'control-label']) !!}

            {!! Form::textarea('option4', null, ['class' => 'form-control custom-textarea', 'required' => 'required', 'placeholder'=>'Option 4', 'rows' => 4 ]) !!}

            @if ($errors->has('option4'))
                <div class="ui pointing red basic label"> {{$errors->first('option4')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group required {{ $errors->has('correct_answer') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('correct_answer', 'Correct Answer', ['class' => 'control-label']) !!}<br>
            <div class="mt-radio-inline">
                @foreach($options as $key => $option)
                    <label class="mt-radio">
                        {!! Form::radio('correct_answer', $key, null, ['class' => 'radio-custom']) !!} {{ $option }}
                        <span></span>
                    </label>
                @endforeach
            </div>

            @if ($errors->has('correct_answer'))
                <div class="ui pointing red basic label"> {{$errors->first('correct_answer')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group {{ $errors->has('solution') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('solution', 'Solution', ['class' => 'control-label']) !!}

            {!! Form::textarea('solution', null, ['class' => 'form-control custom-textarea', 'placeholder'=>'Solution', 'rows' => 4 ]) !!}

            @if ($errors->has('solution'))
                <div class="ui pointing red basic label"> {{$errors->first('solution')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row" id="paragraph_div">
    <div class="col-md-12">
        <div class="form-group {{ $errors->has('paragraph') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('paragraph', 'Paragraph', ['class' => 'control-label']) !!}

            {!! Form::textarea('paragraph', $paragraph, ['class' => 'form-control custom-textarea', 'id' => 'paragraph', 'placeholder'=>'Paragraph', 'rows' => 4 ]) !!}

            @if ($errors->has('paragraph'))
                <div class="ui pointing red basic label"> {{$errors->first('paragraph')}}</div>
            @endif
        </div>
    </div>
</div>