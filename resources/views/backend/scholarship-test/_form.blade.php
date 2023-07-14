<h4 class="scholarship-h4">1) Personal Detail</h4>
<div class="row">
    <div class="col-md-4">
        <div class="form-group required {{ $errors->has('first_name') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('first_name', 'First Name', ['class' => 'control-label']) !!}

            {!! Form::text('first_name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'First Name']) !!}

            @if ($errors->has('first_name'))
                <div class="ui pointing red basic label"> {{$errors->first('first_name')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group {{ $errors->has('middle_name') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('middle_name', 'Middle Name', ['class' => 'control-label']) !!}

            {!! Form::text('middle_name', null, ['class' => 'form-control', 'placeholder'=>'Middle Name']) !!}

            @if ($errors->has('middle_name'))
                <div class="ui pointing red basic label"> {{$errors->first('middle_name')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group required {{ $errors->has('last_name') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('last_name', 'Last Name', ['class' => 'control-label']) !!}

            {!! Form::text('last_name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Last Name']) !!}

            @if ($errors->has('last_name'))
                <div class="ui pointing red basic label"> {{$errors->first('last_name')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('english_dob') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('english_dob', 'English Date of Birth', ['class' => 'control-label']) !!}

            {!! Form::text('english_dob', null, ['class' => 'form-control', 'placeholder'=>'English Date of Birth', 'id' => 'english_date_picker', 'data-conversion-type' => 'english-nepali']) !!}

            @if ($errors->has('english_dob'))
                <div class="ui pointing red basic label"> {{$errors->first('english_dob')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('nepali_dob') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('nepali_dob', 'Nepali Date of Birth', ['class' => 'control-label']) !!}

            {!! Form::text('nepali_dob', null, ['class' => 'form-control', 'placeholder'=>'Nepali Date of Birth', 'id' => 'nepali_date_picker', 'data-conversion-type' => 'nepali-english']) !!}

            @if ($errors->has('nepali_dob'))
                <div class="ui pointing red basic label"> {{$errors->first('nepali_dob')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('gender') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('gender', 'Gender', ['class' => 'control-label']) !!}<br>
            <div class="mt-radio-inline">
                <label class="mt-radio">
                    {!! Form::radio('gender', '0', null, ['class' => 'radio-custom']) !!} Male
                    <span></span>
                </label>
                <label class="mt-radio">
                    {!! Form::radio('gender', '1', null, ['class' => 'radio-custom']) !!} Female
                    <span></span>
                </label>
            </div>
            @if ($errors->has('gender'))
                <div class="ui pointing red basic label"> {{$errors->first('gender')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('landline_number') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('landline_number', 'Landline Number', ['class' => 'control-label']) !!}

            {!! Form::text('landline_number', null, ['class' => 'form-control', 'placeholder'=>'Landline Number']) !!}

            @if ($errors->has('landline_number'))
                <div class="ui pointing red basic label"> {{$errors->first('landline_number')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('cell_number') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('cell_number', 'Cell Number', ['class' => 'control-label']) !!}

            {!! Form::text('cell_number', null, ['class' => 'form-control', 'placeholder'=>'Cell Number']) !!}

            @if ($errors->has('cell_number'))
                <div class="ui pointing red basic label"> {{$errors->first('cell_number')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}

            {!! Form::email('email', null, ['class' => 'form-control', 'placeholder'=>'Email']) !!}

            @if ($errors->has('email'))
                <div class="ui pointing red basic label"> {{$errors->first('email')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group {{ $errors->has('permanent_address') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('permanent_address', 'Permanent Address', ['class' => 'control-label']) !!}

            {!! Form::text('permanent_address', null, ['class' => 'form-control', 'placeholder'=>'Permanent Address']) !!}

            @if ($errors->has('permanent_address'))
                <div class="ui pointing red basic label"> {{$errors->first('permanent_address')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
   <div class="col-md-6">
        <div class="form-group {{ $errors->has('district') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('district', 'District', ['class' => 'control-label']) !!}

            {!! Form::text('district', null, ['class' => 'form-control', 'placeholder'=>'District']) !!}

            @if ($errors->has('district'))
                <div class="ui pointing red basic label"> {{$errors->first('district')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('municipality') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('municipality', 'Rural / Municipality', ['class' => 'control-label']) !!}

            {!! Form::text('municipality', null, ['class' => 'form-control', 'placeholder'=>'Rural/Municipality']) !!}

            @if ($errors->has('municipality'))
                <div class="ui pointing red basic label"> {{$errors->first('municipality')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        {!! Form::label('student_image_id', 'Student Image', ['class' => 'control-label']) !!}
        <div class="form-group {{ $errors->has('student_image_id') ? 'has-error' :'' }}">
            <div class="fileinput {{isset($scholarship_test) ? ((!$scholarship_test->image) ? 'fileinput-new':'fileinput-exists') :
                    'fileinput-new'}}" data-provides="fileinput">
                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px; display: none;">
                    <img src="" alt="" style="width: 150px; height: 140px;"/>
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail"  style="max-width: 200px; max-height: 150px;">
                    <a href="@if(isset($scholarship_test->image)) /storage/media/scholarship-test/{{ $scholarship_test->id }}/{{ $scholarship_test->image->filename }} @endif" data-lightbox="image">
                        <img src="@if(isset($scholarship_test->image)) /storage/media/scholarship-test/{{ $scholarship_test->id }}/thumbnail/{{ $scholarship_test->image->filename }} @endif" alt=""/>
                    </a>
                </div>
                <div>
                    <span class="btn default btn-file">
                        <span class="fileinput-new"> Select image </span>
                        <span class="fileinput-exists"> Change </span>
                        <input type="file" name="student_image_id" accept="image/*">
                    </span>
                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput" @isset($scholarship_test) id="deleteImage" data-target-id = "{{ $scholarship_test->student_image_id }}" @endisset> Remove </a>
                </div>
                
                @if($errors->first('student_image_id'))
                  <div class="ui pointing red basic label"> {{ $errors->first('student_image_id') }}</div>
                @endif
            </div>
        </div>
    </div>
</div>

<hr>
<h4 class="scholarship-h4">2) Contact Address</h4>
<div class="row">
    <div class="col-md-12">
        <div class="form-group {{ $errors->has('current_address') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('current_address', 'Current Address', ['class' => 'control-label']) !!}

            {!! Form::text('current_address', null, ['class' => 'form-control', 'placeholder'=>'Current Address']) !!}

            @if ($errors->has('current_address'))
                <div class="ui pointing red basic label"> {{$errors->first('current_address')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group {{ $errors->has('guardian_name') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('guardian_name', 'Guardian Name', ['class' => 'control-label']) !!}

            {!! Form::text('guardian_name', null, ['class' => 'form-control', 'placeholder'=>'Guardian Name']) !!}

            @if ($errors->has('guardian_name'))
                <div class="ui pointing red basic label"> {{$errors->first('guardian_name')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('guardian_landline_number') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('guardian_landline_number', 'Guardian Landline Number', ['class' => 'control-label']) !!}

            {!! Form::text('guardian_landline_number', null, ['class' => 'form-control', 'placeholder'=>'Guardian Landline Number']) !!}

            @if ($errors->has('guardian_landline_number'))
                <div class="ui pointing red basic label"> {{$errors->first('guardian_landline_number')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('guardian_cell_number') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('guardian_cell_number', 'Guardian Cell Number', ['class' => 'control-label']) !!}

            {!! Form::text('guardian_cell_number', null, ['class' => 'form-control', 'placeholder'=>'Guardian Cell Number']) !!}

            @if ($errors->has('guardian_cell_number'))
                <div class="ui pointing red basic label"> {{$errors->first('guardian_cell_number')}}</div>
            @endif
        </div>
    </div>
</div>

<hr>
<h4 class="scholarship-h4">3) Academic Qualification</h4>
<div class="row">
    <div class="col-md-12">
        <div class="form-group {{ $errors->has('education_level') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('education_level', 'Education Level', ['class' => 'control-label']) !!}

            {!! Form::select('education_level', $education_levels, null,['id'=>'education_level', 'class' => 'form-control custom-select', 'placeholder' => 'Select the education level']) !!}

            @if ($errors->has('education_level'))
                <div class="ui pointing red basic label"> {{$errors->first('education_level')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group {{ $errors->has('college_name') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('college_name', 'Name of College (Recent)', ['class' => 'control-label']) !!}

            {!! Form::text('college_name', null, ['class' => 'form-control', 'placeholder'=>'Name of College (Recent)']) !!}

            @if ($errors->has('college_name'))
                <div class="ui pointing red basic label"> {{$errors->first('college_name')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('college_address') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('college_address', 'Address', ['class' => 'control-label']) !!}

            {!! Form::text('college_address', null, ['class' => 'form-control', 'placeholder'=>'Address']) !!}

            @if ($errors->has('college_address'))
                <div class="ui pointing red basic label"> {{$errors->first('college_address')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('college_marks_obtained') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('college_marks_obtained', 'Grade / Percentage', ['class' => 'control-label']) !!}

            {!! Form::text('college_marks_obtained', null, ['class' => 'form-control', 'placeholder'=>'Grade / Percentage']) !!}

            @if ($errors->has('college_marks_obtained'))
                <div class="ui pointing red basic label"> {{$errors->first('college_marks_obtained')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group {{ $errors->has('school_name') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('school_name', 'Name of School (SLC)', ['class' => 'control-label']) !!}

            {!! Form::text('school_name', null, ['class' => 'form-control', 'placeholder'=>'Name of School (SLC)']) !!}

            @if ($errors->has('school_name'))
                <div class="ui pointing red basic label"> {{$errors->first('school_name')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('school_address') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('school_address', 'Address', ['class' => 'control-label']) !!}

            {!! Form::text('school_address', null, ['class' => 'form-control', 'placeholder'=>'Address']) !!}

            @if ($errors->has('school_address'))
                <div class="ui pointing red basic label"> {{$errors->first('school_address')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('school_marks_obtained') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('school_marks_obtained', 'Grade / Percentage', ['class' => 'control-label']) !!}

            {!! Form::text('school_marks_obtained', null, ['class' => 'form-control', 'placeholder'=>'Grade / Percentage']) !!}

            @if ($errors->has('school_marks_obtained'))
                <div class="ui pointing red basic label"> {{$errors->first('school_marks_obtained')}}</div>
            @endif
        </div>
    </div>
</div>

<hr>
<h4 class="scholarship-h4">4) PI Academic Reference</h4>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('registration_number') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('registration_number', 'Scholarship Test Registration Number', ['class' => 'control-label']) !!}

            {!! Form::text('registration_number', null, ['class' => 'form-control', 'placeholder'=>'Scholarship Test Registration Number']) !!}

            @if ($errors->has('registration_number'))
                <div class="ui pointing red basic label"> {{$errors->first('registration_number')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('interested_course') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('interested_course', 'Courses', ['class' => 'control-label']) !!}

            {!! Form::select('interested_course', $interested_courses, (isset($scholarship_test) ? $scholarship_test->interested_course : 0),['id'=>'interested_course', 'class' => 'form-control custom-select', 'placeholder' => 'Select the course']) !!}

            @if ($errors->has('interested_course'))
                <div class="ui pointing red basic label"> {{$errors->first('interested_course')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="form-group {{ $errors->has('shift') ? ' has-error' : '' }} clearfix ">
    {!! Form::label('shift', 'Shift', ['class' => 'control-label']) !!}<br>
    <div class="mt-radio-inline">
        <label class="mt-radio">
            {!! Form::radio('shift', '0', null, ['class' => 'radio-custom']) !!} Morning
            <span></span>
        </label>
        <label class="mt-radio">
            {!! Form::radio('shift', '1', null, ['class' => 'radio-custom']) !!} Day
            <span></span>
        </label>
        <label class="mt-radio">
            {!! Form::radio('shift', '2', null, ['class' => 'radio-custom']) !!} Evening
            <span></span>
        </label>
    </div>
    @if ($errors->has('shift'))
        <div class="ui pointing red basic label"> {{$errors->first('shift')}}</div>
    @endif
</div>
