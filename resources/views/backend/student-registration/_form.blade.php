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

            {!! Form::text('english_dob', null, ['class' => 'form-control', 'placeholder'=>'English Date of Birth', 'id' => 'english_dob', 'data-conversion-type' => 'english-nepali']) !!}

            @if ($errors->has('english_dob'))
                <div class="ui pointing red basic label"> {{$errors->first('english_dob')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('nepali_dob') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('nepali_dob', 'Nepali Date of Birth', ['class' => 'control-label']) !!}

            {!! Form::text('nepali_dob', null, ['class' => 'form-control', 'placeholder'=>'Nepali Date of Birth', 'id' => 'nepali_dob', 'data-conversion-type' => 'nepali-english']) !!}

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
    <div class="col-md-8">
        <div class="form-group {{ $errors->has('known_from') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('submitted_documents', 'Submitted Douments', ['class' => 'control-label']) !!}

            <div class="mt-checkbox-list">
                @isset($student_registration)
                    @php
                        $submittedDocuments = explode(",", $student_registration->submitted_documents);
                    @endphp
                @endisset
                @foreach($submitted_documents as $key=>$submitted_document)
                    <div class="col-md-6 col-sm-6">
                        <label class="mt-checkbox">
                            @if(isset($student_registration->submitted_documents))
                                {!! Form::checkbox("submitted_documents[]", $key, in_array($key, $submittedDocuments)) !!} {{ $submitted_document }}
                            @else
                                {!! Form::checkbox("submitted_documents[]", $key) !!} {{ $submitted_document }}
                            @endif
                            <span></span>
                        </label>
                    </div>
                @endforeach
            </div>

            @if ($errors->has('submitted_documents'))
                <div class="ui pointing red basic label"> {{$errors->first('submitted_documents')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 col-sm-4">
        {!! Form::label('student_image_1', 'Photo 1', ['class' => 'control-label']) !!}
        <div class="form-group {{ $errors->has('student_image_1') ? 'has-error' :'' }}">
            <div class="fileinput {{isset($student_registration) ? ((!$student_registration->image1) ? 'fileinput-new':'fileinput-exists') : 'fileinput-new'}}" data-provides="fileinput">
                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px; display: none;">
                    <img src="" alt="" style="width: 150px; height: 140px;"/>
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                    <a href="@if(isset($student_registration->image1)) /storage/media/student-registration-image1/{{ $student_registration->id }}/{{ $student_registration->image1->filename }}  @endif" data-lightbox="image1">
                        <img src="@if(isset($student_registration->image1)) /storage/media/student-registration-image1/{{ $student_registration->id }}/thumbnail/{{ $student_registration->image1->filename }}  @endif" alt=""/>
                    </a>
                </div>
                <div>
                    <span class="btn default btn-file">
                        <span class="fileinput-new"> Select image </span>
                        <span class="fileinput-exists"> Change </span>
                        <input type="file" name="student_image_1" accept="image/*">
                    </span>
                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput" @isset($student_registration) id="deleteImage1" data-target-id = "{{ $student_registration->student_image_1 }}" data-target-type = "student_image_1" @endisset> Remove </a>
                </div>

                @if($errors->first('student_image_1'))
                  <div class="ui pointing red basic label"> {{ $errors->first('student_image_1') }}</div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4 col-sm-4">
        {!! Form::label('student_image_2', 'Photo 2', ['class' => 'control-label']) !!}
        <div class="form-group {{ $errors->has('student_image_2') ? 'has-error' :'' }}">
            <div class="fileinput {{isset($student_registration) ? ((!$student_registration->image2) ? 'fileinput-new':'fileinput-exists') :
                    'fileinput-new'}}" data-provides="fileinput">
                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px; display: none;">
                    <img src="" alt="" style="width: 150px; height: 140px;"/>
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                    <a href="@if(isset($student_registration->image2)) /storage/media/student-registration-image2/{{ $student_registration->id }}/{{ $student_registration->image2->filename }}  @endif" data-lightbox="image2">
                        <img src="@if(isset($student_registration->image2)) /storage/media/student-registration-image2/{{ $student_registration->id }}/thumbnail/{{ $student_registration->image2->filename }} @endif" alt=""/>
                    </a>
                </div>
                <div>
                    <span class="btn default btn-file">
                        <span class="fileinput-new"> Select image </span>
                        <span class="fileinput-exists"> Change </span>
                        <input type="file" name="student_image_2" accept="image/*">
                    </span>
                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput" @isset($student_registration) id="deleteImage2" data-target-id = "{{ $student_registration->student_image_2 }}" data-target-type = "student_image_2" @endisset> Remove </a>
                </div>

                @if($errors->first('student_image_2'))
                  <div class="ui pointing red basic label"> {{ $errors->first('student_image_2') }}</div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4 col-sm-4">
        {!! Form::label('character_certificate', 'Character Certificate', ['class' => 'control-label']) !!}
        <div class="form-group {{ $errors->has('character_certificate') ? 'has-error' :'' }}">
            <div class="fileinput {{isset($student_registration) ? ((!$student_registration->characterCertificate) ? 'fileinput-new':'fileinput-exists') :
                    'fileinput-new'}}" data-provides="fileinput">
                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px; display: none;">
                    <img src="" alt="" style="width: 150px; height: 140px;"/>
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                    <a href="@if(isset($student_registration->characterCertificate)) /storage/media/student-registration-characterCertificate/{{ $student_registration->id }}/{{ $student_registration->characterCertificate->filename }}  @endif" data-lightbox="characterCertificate">
                        <img src="@if(isset($student_registration->characterCertificate)) /storage/media/student-registration-characterCertificate/{{ $student_registration->id }}/thumbnail/{{ $student_registration->characterCertificate->filename }} @endif" alt=""/>
                    </a>
                </div>
                <div>
                    <span class="btn default btn-file">
                        <span class="fileinput-new"> Select image </span>
                        <span class="fileinput-exists"> Change </span>
                        <input type="file" name="character_certificate" accept="image/*">
                    </span>
                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput" @isset($student_registration) id="deleteCharacterCertificate" data-target-id = "{{ $student_registration->character_certificate }}" data-target-type = "character_certificate" @endisset> Remove </a>
                </div>

                @if($errors->first('character_certificate'))
                  <div class="ui pointing red basic label"> {{ $errors->first('character_certificate') }}</div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 col-sm-4">
        {!! Form::label('scholarship_recommendation', 'Scholarship Recommendation', ['class' => 'control-label']) !!}
        <div class="form-group {{ $errors->has('scholarship_recommendation') ? 'has-error' :'' }}">
            <div class="fileinput {{isset($student_registration) ? ((!$student_registration->scholarshipRecommendation) ? 'fileinput-new':'fileinput-exists') :
                    'fileinput-new'}}" data-provides="fileinput">
                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px; display: none;">
                    <img src="" alt="" style="width: 150px; height: 140px;"/>
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail"  style="max-width: 200px; max-height: 150px;">
                    <a href="@if(isset($student_registration->scholarshipRecommendation)) /storage/media/student-registration-scholarshipRecommendation/{{ $student_registration->id }}/{{ $student_registration->scholarshipRecommendation->filename }}  @endif" data-lightbox="scholarshipRecommendation">
                        <img src="@if(isset($student_registration->scholarshipRecommendation)) /storage/media/student-registration-scholarshipRecommendation/{{ $student_registration->id }}/thumbnail/{{ $student_registration->scholarshipRecommendation->filename }} @endif" alt=""/>
                    </a>
                </div>
                <div>
                    <span class="btn default btn-file">
                    <span class="fileinput-new"> Select image </span>
                    <span class="fileinput-exists"> Change </span>
                        <input type="file" name="scholarship_recommendation" accept="image/*">
                    </span>
                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput" @isset($student_registration) id="deleteScholarshipRecommendation" data-target-id = "{{ $student_registration->scholarship_recommendation }}" data-target-type = "scholarship_recommendation" @endisset> Remove </a>
                </div>

                @if($errors->first('scholarship_recommendation'))
                  <div class="ui pointing red basic label"> {{ $errors->first('scholarship_recommendation') }}</div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4 col-sm-4">
        {!! Form::label('marksheet', 'Marksheet', ['class' => 'control-label']) !!}
        <div class="form-group {{ $errors->has('marksheet') ? 'has-error' :'' }}">
            <div class="fileinput {{isset($student_registration) ? ((!$student_registration->marksheetData) ? 'fileinput-new':'fileinput-exists') :
                    'fileinput-new'}}" data-provides="fileinput">
                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px; display: none;">
                    <img src="" alt="" style="width: 150px; height: 140px;"/>
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                    <a href="@if(isset($student_registration->marksheetData)) /storage/media/student-registration-marksheet/{{ $student_registration->id }}/{{ $student_registration->marksheetData->filename }}  @endif" data-lightbox="marksheetData">
                        <img src="@if(isset($student_registration->marksheetData)) /storage/media/student-registration-marksheet/{{ $student_registration->id }}/thumbnail/{{ $student_registration->marksheetData->filename }} @endif" alt=""/>
                    </a>
                </div>
                <div>
                    <span class="btn default btn-file">
                        <span class="fileinput-new"> Select image </span>
                        <span class="fileinput-exists"> Change </span>
                        <input type="file" name="marksheet" accept="image/*">
                    </span>
                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput" @isset($student_registration) id="deleteMarksheet" data-target-id = "{{ $student_registration->marksheet }}" data-target-type = "marksheet" @endisset> Remove </a>
                </div>
                
                @if($errors->first('marksheet'))
                  <div class="ui pointing red basic label"> {{ $errors->first('marksheet') }}</div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('total_fee') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('total_fee', 'Total Fee', ['class' => 'control-label']) !!}

            {!! Form::text('total_fee', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Total Fee', 'id' => 'total_fee']) !!}

            @if ($errors->has('total_fee'))
                <div class="ui pointing red basic label"> {{$errors->first('total_fee')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('scholarship') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('scholarship', 'Scholarship %', ['class' => 'control-label']) !!}

            {!! Form::text('scholarship', null, ['class' => 'form-control', 'placeholder'=>'Scholarship %', 'id' => 'scholarship']) !!}

            @if ($errors->has('scholarship'))
                <div class="ui pointing red basic label"> {{$errors->first('scholarship')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('fee_after_scholarship') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('fee_after_scholarship', 'Fee After Scholarship', ['class' => 'control-label']) !!}

            {!! Form::text('fee_after_scholarship', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Add Total Fee First', 'id' => 'fee_after_scholarship']) !!}

            @if ($errors->has('fee_after_scholarship'))
                <div class="ui pointing red basic label"> {{$errors->first('fee_after_scholarship')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('english_due_clearance_date') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('english_due_clearance_date', 'English Due Clearance Date', ['class' => 'control-label']) !!}

            {!! Form::text('english_due_clearance_date', null, ['class' => 'form-control', 'placeholder'=>'English Due Clearance Date', 'id' => 'english_due_clearance_date', 'data-conversion-type' => 'english-nepali']) !!}

            @if ($errors->has('english_due_clearance_date'))
                <div class="ui pointing red basic label"> {{$errors->first('english_due_clearance_date')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('nepali_due_clearance_date') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('nepali_due_clearance_date', 'Nepali Due Clearance Date', ['class' => 'control-label']) !!}

            {!! Form::text('nepali_due_clearance_date', null, ['class' => 'form-control', 'placeholder'=>'Nepali Due Clearance Date', 'id' => 'nepali_due_clearance_date', 'data-conversion-type' => 'nepali-english']) !!}

            @if ($errors->has('nepali_due_clearance_date'))
                <div class="ui pointing red basic label"> {{$errors->first('nepali_due_clearance_date')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('registration_number') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('registration_number', 'Registration Number', ['class' => 'control-label']) !!}

            {!! Form::text('registration_number', null, ['class' => 'form-control', 'placeholder'=>'Registration Number']) !!}

            @if ($errors->has('registration_number'))
                <div class="ui pointing red basic label"> {{$errors->first('registration_number')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('interested_course') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('interested_course', 'Courses', ['class' => 'control-label']) !!}

            {!! Form::select('interested_course', $interested_courses, (isset($student_registration) ? $student_registration->interested_course : 0),['id'=>'interested_course', 'class' => 'form-control custom-select', 'placeholder' => 'Select the course', 'required' => 'required']) !!}

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

<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('interested_stream') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('interested_stream', 'Interested Stream', ['class' => 'control-label']) !!}

            {!! Form::text('interested_stream', null, ['class' => 'form-control', 'placeholder'=>'Interested Stream']) !!}

            @if ($errors->has('interested_stream'))
                <div class="ui pointing red basic label"> {{$errors->first('interested_stream')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('approved_by') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('approved_by', 'Approved By', ['class' => 'control-label']) !!}

            {!! Form::text('approved_by', null, ['class' => 'form-control', 'placeholder'=>'Approved By']) !!}

            @if ($errors->has('approved_by'))
                <div class="ui pointing red basic label"> {{$errors->first('approved_by')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('english_final_admission_date') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('english_final_admission_date', 'English Final Admission Date', ['class' => 'control-label']) !!}

            {!! Form::text('english_final_admission_date', null, ['class' => 'form-control', 'placeholder'=>'English Final Admission Date', 'id' => 'english_final_admission_date', 'data-conversion-type' => 'english-nepali']) !!}

            @if ($errors->has('english_final_admission_date'))
                <div class="ui pointing red basic label"> {{$errors->first('english_final_admission_date')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('nepali_final_admission_date') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('nepali_final_admission_date', 'Nepali Final Admission Date', ['class' => 'control-label']) !!}

            {!! Form::text('nepali_final_admission_date', null, ['class' => 'form-control', 'placeholder'=>'Nepali Final Admission Date', 'id' => 'nepali_final_admission_date', 'data-conversion-type' => 'nepali-english']) !!}

            @if ($errors->has('nepali_final_admission_date'))
                <div class="ui pointing red basic label"> {{$errors->first('nepali_final_admission_date')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('known_from') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('known_from', 'Known From', ['class' => 'control-label']) !!}

            {!! Form::select('known_from', $known_froms, null, ['id'=>'known_from', 'class' => 'form-control custom-select', 'placeholder' => 'Known From', 'id' => 'known_from']) !!}

            @if ($errors->has('known_from'))
                <div class="ui pointing red basic label"> {{$errors->first('known_from')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6" id="knownFromOther_div">
        <div class="form-group {{ $errors->has('known_from_other') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('known_from_other', 'Specify', ['class' => 'control-label']) !!}

            {!! Form::text('known_from_other', null, ['class' => 'form-control', 'placeholder'=>'Specify']) !!}

            @if ($errors->has('known_from_other'))
                <div class="ui pointing red basic label"> {{$errors->first('known_from_other')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('known_from') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('books', 'Materials Taken', ['class' => 'control-label']) !!}

            <div class="mt-checkbox-list">
                @isset($student_registration)
                    @php
                        $selectedBooks = explode(",", $student_registration->books_taken);
                    @endphp
                @endisset
                @foreach($books as $key=>$book)
                    <div class="col-md-6 col-sm-6">
                        <label class="mt-checkbox">
                            @if(isset($student_registration->books_taken))
                                {!! Form::checkbox("books_taken[]", $key, in_array($key, $selectedBooks)) !!} {{ $book }}
                            @else
                                {!! Form::checkbox("books_taken[]", $key) !!} {{ $book }}
                            @endif
                            <span></span>
                        </label>
                    </div>
                @endforeach
            </div>

            @if ($errors->has('known_from'))
                <div class="ui pointing red basic label"> {{$errors->first('known_from')}}</div>
            @endif
        </div>
    </div>
</div>
