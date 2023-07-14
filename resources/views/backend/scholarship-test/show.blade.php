@extends('layouts.backend')

@section('title')
    Show Student Information
@endsection

@section('content')
    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h1 class="page-title font-green sbold">
                    <i class="fa fa-television font-green"></i> Student Information
                    <small class="font-green sbold">Show</small>
                </h1>
            </div>
        </div>
    </div>
    <div class="portlet-body">
        <ul class="list-group">
        <h4 class="show-h4"><i class="fa fa-arrow-right show-i"></i>Personal Detail</h4>
            @isset($scholarship_test->image)
                <li class="list-group-item">
                    <a href="/storage/media/scholarship-test/{{ $scholarship_test->id }}/{{ $scholarship_test->image->filename }}" data-lightbox="image1">
                        <img class="custom-thumbnail selected-img" src="/storage/media/scholarship-test/{{ $scholarship_test->id }}/thumbnail/{{ $scholarship_test->image->filename }}" class="custom-thumbnail">
                    </a>
                </li>
            @endisset
            <li class="list-group-item">
                <strong>Name:</strong> {{ $scholarship_test->first_name }} @isset($scholarship_test->middle_name) {{ $scholarship_test->middle_name }} @endisset {{ $scholarship_test->last_name }}
            </li>
            <li class="list-group-item">
                <strong>Gender:</strong> {{ \App\ScholarshipTest::Gender[$scholarship_test->gender] }}
            </li>
            @isset($scholarship_test->english_dob)
                <li class="list-group-item">
                    <strong>English Date of Birth:</strong> {{ $scholarship_test->english_dob }} A.D.
                </li>
            @endisset
            @isset($scholarship_test->nepali_dob)
                <li class="list-group-item">
                    <strong>Nepali Date of Birth:</strong> {{ $scholarship_test->nepali_dob }} B.S.
                </li>
            @endisset
            @can('view_confidentials')
                @isset($scholarship_test->landline_number)
                    <li class="list-group-item">
                        <strong>Landline Number:</strong> {{ $scholarship_test->landline_number }}
                    </li>
                @endisset
                @isset($scholarship_test->cell_number)
                    <li class="list-group-item">
                        <strong>Cell Number:</strong> {{ $scholarship_test->cell_number }}
                    </li>
                @endisset
            @endcan
            @can('view_confidentials')
                @isset($scholarship_test->email)
                    <li class="list-group-item">
                        <strong>Email:</strong> {{ $scholarship_test->email }}
                    </li>
                @endisset
            @endcan
            @isset($scholarship_test->permanent_address)
                <li class="list-group-item">
                    <strong>Permanent Address:</strong> {{ $scholarship_test->permanent_address }}
                </li>
            @endisset
            @isset($scholarship_test->district)
                <li class="list-group-item">
                    <strong>District:</strong> {{ $scholarship_test->district }}
                </li>
            @endisset
            @isset($scholarship_test->municipality)
                <li class="list-group-item">
                    <strong>Rural / Municipality:</strong> {{ $scholarship_test->municipality }}
                </li>
            @endisset
        </ul>

        @if(isset($scholarship_test->current_address) || isset($scholarship_test->guardian_name) || isset($scholarship_test->guardian_landline_number) || isset($scholarship_test->guardian_cell_number))
            <ul class="list-group">
                <h4 class="show-h4"><i class="fa fa-arrow-right show-i"></i>Contact Address</h4>
                @isset($scholarship_test->current_address)
                    <li class="list-group-item">
                        <strong>Current Address:</strong> {{ $scholarship_test->current_address }}
                    </li>
                @endisset
                @isset($scholarship_test->guardian_name)
                    <li class="list-group-item">
                        <strong>Guardian Name:</strong> {{ $scholarship_test->guardian_name }}
                    </li>
                @endisset
                @can('view_confidentials')
                    @isset($scholarship_test->guardian_landline_number)
                        <li class="list-group-item">
                            <strong>Guradian Landline Number:</strong> {{ $scholarship_test->guardian_landline_number }}
                        </li>
                    @endisset
                    @isset($scholarship_test->guardian_cell_number)
                        <li class="list-group-item">
                            <strong>Guradian Cell Number:</strong> {{ $scholarship_test->guardian_cell_number }}
                        </li>
                    @endisset
                @endcan
            </ul>
        @endisset

        @if(isset($scholarship_test->education_level) ||
                isset($scholarship_test->college_name) ||
                isset($scholarship_test->college_address) ||
                isset($scholarship_test->college_marks_obtained) ||
                isset($scholarship_test->school_name) ||
                isset($scholarship_test->school_address) ||
                isset($scholarship_test->school_marks_obtained))
            <ul class="list-group">
                <h4 class="show-h4"><i class="fa fa-arrow-right show-i"></i>Academic Qualification</h4>
                @isset($scholarship_test->education_level)
                    <li class="list-group-item">
                        <strong>Education Level:</strong> {{  \App\ScholarshipTest::EducationLevel[$scholarship_test->education_level] }}
                    </li>
                @endisset
                @can('view_confidentials')
                    @isset($scholarship_test->college_name)
                        <li class="list-group-item">
                            <strong>College Name (Recent):</strong> {{ $scholarship_test->college_name }}
                        </li>
                    @endcan
                @endcan
                @isset($scholarship_test->college_address)
                    <li class="list-group-item">
                        <strong>Address:</strong> {{ $scholarship_test->college_address }}
                    </li>
                @endisset
                @isset($scholarship_test->college_marks_obtained)
                    <li class="list-group-item">
                        <strong>Grade / Percentage:</strong> {{ $scholarship_test->college_marks_obtained }}
                    </li>
                @endisset
                @can('view_confidentials')
                    @isset($scholarship_test->school_name)
                        <li class="list-group-item">
                            <strong>School Name (SLC):</strong> {{ $scholarship_test->school_name }}
                        </li>
                    @endisset
                    @isset($scholarship_test->school_address)
                        <li class="list-group-item">
                            <strong>Address:</strong> {{ $scholarship_test->school_address }}
                        </li>
                    @endisset
                @endcan
                @isset($scholarship_test->school_marks_obtained)
                    <li class="list-group-item">
                        <strong>Grade / Percentage:</strong> {{ $scholarship_test->school_marks_obtained }}
                    </li>
                @endisset
            </ul>
        @endif

        <ul class="list-group">
            <h4 class="show-h4"><i class="fa fa-arrow-right show-i"></i>PI Academy Reference</h4>
            @isset($scholarship_test->registration_number)
                <li class="list-group-item">
                    <strong>Scholarship Test Reg No:</strong> {{ $scholarship_test->registration_number }}
                </li>
            @endisset
            <li class="list-group-item">
                <strong>Interested Course:</strong> {{  \App\ScholarshipTest::InterestedCourse[$scholarship_test->interested_course] }}
            </li>
            @isset($scholarship_test->shift)
                <li class="list-group-item">
                    <strong>Shift:</strong> {{ \App\ScholarshipTest::Shift[$scholarship_test->shift] }}
                </li>
            @endisset
        </ul>

        <ul class="list-group">
            <li class="list-group-item">
                <strong>Created By:</strong> {{ $scholarship_test->createdBy->name }}
            </li>
            <li class="list-group-item">
                <strong>Updated By:</strong> {{ $scholarship_test->updatedBy->name }}
            </li>
        </ul>
    </div>

    <div class="portlet-footer">
        <div class="form-group">
            <a href="{{ route('scholarship-test.index') }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
            Back</a>
        </div>
    </div>
@endsection

