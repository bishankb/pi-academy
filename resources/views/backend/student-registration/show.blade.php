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
            <li class="list-group-item">
                <strong>Name:</strong> {{ $student_registration->first_name }} @isset($student_registration->middle_name) {{ $student_registration->middle_name }} @endisset {{ $student_registration->last_name }}
            </li>
            <li class="list-group-item">
                <strong>Gender:</strong> {{ \App\ScholarshipTest::Gender[$student_registration->gender] }}
            </li>
            @isset($student_registration->english_dob)
                <li class="list-group-item">
                    <strong>English Date of Birth:</strong> {{ $student_registration->english_dob }} A.D.
                </li>
            @endisset
            @isset($student_registration->nepali_dob)
                <li class="list-group-item">
                    <strong>Nepali Date of Birth:</strong> {{ $student_registration->nepali_dob }} B.S.
                </li>
            @endisset
            @can('view_confidentials')
                @isset($student_registration->landline_number)
                    <li class="list-group-item">
                        <strong>Landline Number:</strong> {{ $student_registration->landline_number }}
                    </li>
                @endisset
                @isset($student_registration->cell_number)
                    <li class="list-group-item">
                        <strong>Cell Number:</strong> {{ $student_registration->cell_number }}
                    </li>
                @endisset
            @endcan
            @can('view_confidentials')
                @isset($student_registration->email)
                    <li class="list-group-item">
                        <strong>Email:</strong> {{ $student_registration->email }}
                    </li>
                @endisset
            @endcan
            @isset($student_registration->permanent_address)
                <li class="list-group-item">
                    <strong>Permanent Address:</strong> {{ $student_registration->permanent_address }}
                </li>
            @endisset
            @isset($student_registration->district)
                <li class="list-group-item">
                    <strong>District:</strong> {{ $student_registration->district }}
                </li>
            @endisset
            @isset($student_registration->municipality)
                <li class="list-group-item">
                    <strong>Rural / Municipality:</strong> {{ $student_registration->municipality }}
                </li>
            @endisset
        </ul>

        @if(isset($student_registration->current_address) || isset($student_registration->guardian_name) || isset($student_registration->guardian_landline_number) || isset($student_registration->guardian_cell_number))
            <ul class="list-group">
                <h4 class="show-h4"><i class="fa fa-arrow-right show-i"></i>Contact Address</h4>
                @isset($student_registration->current_address)
                    <li class="list-group-item">
                        <strong>Current Address:</strong> {{ $student_registration->current_address }}
                    </li>
                @endisset
                @isset($student_registration->guardian_name)
                    <li class="list-group-item">
                        <strong>Guardian Name:</strong> {{ $student_registration->guardian_name }}
                    </li>
                @endisset
                @can('view_confidentials')
                    @isset($student_registration->guardian_landline_number)
                        <li class="list-group-item">
                            <strong>Guradian Landline Number:</strong> {{ $student_registration->guardian_landline_number }}
                        </li>
                    @endisset
                    @isset($student_registration->guardian_cell_number)
                        <li class="list-group-item">
                            <strong>Guradian Cell Number:</strong> {{ $student_registration->guardian_cell_number }}
                        </li>
                    @endisset
                @endcan
            </ul>
        @endisset

        @if(isset($student_registration->education_level) ||
                isset($student_registration->college_name) ||
                isset($student_registration->college_address) ||
                isset($student_registration->college_marks_obtained) ||
                isset($student_registration->school_name) ||
                isset($student_registration->school_address) ||
                isset($student_registration->school_marks_obtained))
            <ul class="list-group">
                <h4 class="show-h4"><i class="fa fa-arrow-right show-i"></i>Academic Qualification</h4>
                @isset($student_registration->education_level)
                    <li class="list-group-item">
                        <strong>Education Level:</strong> {{  \App\ScholarshipTest::EducationLevel[$student_registration->education_level] }}
                    </li>
                @endisset
                @can('view_confidentials')
                    @isset($student_registration->college_name)
                        <li class="list-group-item">
                            <strong>College Name (Recent):</strong> {{ $student_registration->college_name }}
                        </li>
                    @endcan
                @endcan
                @isset($student_registration->college_address)
                    <li class="list-group-item">
                        <strong>Address:</strong> {{ $student_registration->college_address }}
                    </li>
                @endisset
                @isset($student_registration->college_marks_obtained)
                    <li class="list-group-item">
                        <strong>Grade / Percentage:</strong> {{ $student_registration->college_marks_obtained }}
                    </li>
                @endisset
                @can('view_confidentials')
                    @isset($student_registration->school_name)
                        <li class="list-group-item">
                            <strong>School Name (SLC):</strong> {{ $student_registration->school_name }}
                        </li>
                    @endisset
                    @isset($student_registration->school_address)
                        <li class="list-group-item">
                            <strong>Address:</strong> {{ $student_registration->school_address }}
                        </li>
                    @endisset
                @endcan
                @isset($student_registration->school_marks_obtained)
                    <li class="list-group-item">
                        <strong>Grade / Percentage:</strong> {{ $student_registration->school_marks_obtained }}
                    </li>
                @endisset
            </ul>
        @endif

        <ul class="list-group">
            <h4 class="show-h4"><i class="fa fa-arrow-right show-i"></i>PI Academy Reference</h4>
            <li class="list-group-item">
                <strong>Photo 1:</strong> {{ ($student_registration->has_student_image_1 == 1) ? 'Submitted' : 'Not Submitted' }}
            </li>
            <li class="list-group-item">
                <strong>Photo 2:</strong> {{ ($student_registration->has_student_image_2 == 1) ? 'Submitted' : 'Not Submitted' }}
            </li>
            <li class="list-group-item">
                <strong>Character Certificate:</strong> {{ ($student_registration->has_character_certificate == 1) ? 'Submitted' : 'Not Submitted' }}
            </li>
            <li class="list-group-item">
                <strong>Scholarship Supporting Recommendation:</strong> {{ ($student_registration->has_scholarship_recommendation == 1) ? 'Submitted' : 'Not Submitted' }}
            </li>
            <li class="list-group-item">
                <strong>Marksheet:</strong> {{ ($student_registration->has_marksheet == 1) ? 'Submitted' : 'Not Submitted' }}
            </li>
            @isset($student_registration->image1)
                <li class="list-group-item">
                    <strong>Photo 1</strong><br>
                    <a href="/storage/media/student-registration-image1/{{ $student_registration->id }}/{{ $student_registration->image1->filename }}" data-lightbox="image1">
                        <img class="custom-thumbnail selected-img" src="/storage/media/student-registration-image1/{{ $student_registration->id }}/thumbnail/{{ $student_registration->image1->filename }}" class="custom-thumbnail">
                    </a>
                </li>
            @endisset
            @isset($student_registration->image2)
                <li class="list-group-item">
                    <strong>Photo 2</strong><br>
                    <a href="/storage/media/student-registration-image2/{{ $student_registration->id }}/{{ $student_registration->image2->filename }}" data-lightbox="image2">
                        <img class="custom-thumbnail selected-img" src="/storage/media/student-registration-image2/{{ $student_registration->id }}/thumbnail/{{ $student_registration->image2->filename }}" class="custom-thumbnail">
                    </a>
                </li>
            @endisset
            @isset($student_registration->characterCertificate)
                <li class="list-group-item">
                    <strong>Character Certificate</strong><br>
                    <a href="/storage/media/student-registration-characterCertificate/{{ $student_registration->id }}/{{ $student_registration->characterCertificate->filename }}" data-lightbox="characterCertificate">
                        <img class="custom-thumbnail selected-img" src="/storage/media/student-registration-characterCertificate/{{ $student_registration->id }}/thumbnail/{{ $student_registration->characterCertificate->filename }}" class="custom-thumbnail">
                    </a>
                </li>
            @endisset
            @isset($student_registration->scholarshipRecommendation)
                <li class="list-group-item">
                    <strong>Scholarship Recommendation</strong><br>
                    <a href="/storage/media/student-registration-scholarshipRecommendation/{{ $student_registration->id }}/{{ $student_registration->scholarshipRecommendation->filename }}" data-lightbox="scholarshipRecommendation">
                        <img class="custom-thumbnail selected-img" src="/storage/media/student-registration-scholarshipRecommendation/{{ $student_registration->id }}/thumbnail/{{ $student_registration->scholarshipRecommendation->filename }}" class="custom-thumbnail">
                    </a>
                </li>
            @endisset
            @isset($student_registration->marksheetData)
                <li class="list-group-item">
                    <strong>Marksheet</strong><br>
                    <a href="/storage/media/student-registration-marksheet/{{ $student_registration->id }}/{{ $student_registration->marksheetData->filename }}" data-lightbox="scholarshipRecommendation">
                        <img class="custom-thumbnail selected-img" src="/storage/media/student-registration-marksheet/{{ $student_registration->id }}/thumbnail/{{ $student_registration->marksheetData->filename }}" class="custom-thumbnail">
                    </a>
                </li>
            @endisset
            <li class="list-group-item">
                <strong>Total Fee:</strong> {{ $student_registration->total_fee }}
            </li>
            @isset($student_registration->scholarship)
                <li class="list-group-item">
                    <strong>Scholarship:</strong> {{ $student_registration->scholarship }}%
                </li>
            @endisset
            <li class="list-group-item">
                <strong>Fee After Scholarship:</strong> {{ $student_registration->fee_after_scholarship }}
            </li>
            @isset($student_registration->english_due_clearance_date)
                <li class="list-group-item">
                    <strong>English Due Clearance Date:</strong> {{ $student_registration->english_due_clearance_date }} A.D.
                </li>
            @endisset
            @isset($student_registration->nepali_due_clearance_date)
                <li class="list-group-item">
                    <strong>Nepali Due Clearance Date:</strong> {{ $student_registration->nepali_due_clearance_date }} B.S.
                </li>
            @endisset
            @isset($student_registration->registration_number)
                <li class="list-group-item">
                    <strong>Reg No:</strong> {{ $student_registration->registration_number }}
                </li>
            @endisset
            <li class="list-group-item">
                <strong>Interested Course:</strong> {{  \App\ScholarshipTest::InterestedCourse[$student_registration->interested_course] }}
            </li>
            @isset($student_registration->shift)
                <li class="list-group-item">
                    <strong>Shift:</strong> {{ \App\ScholarshipTest::Shift[$student_registration->shift] }}
                </li>
            @endisset
            @isset($student_registration->interest_eng_stream)
                <li class="list-group-item">
                    <strong>Interest Engg. Stream:</strong> {{ $student_registration->interest_eng_stream }}
                </li>
            @endisset
            @isset($student_registration->english_final_admission_date)
                <li class="list-group-item">
                    <strong>English Final Admission Date:</strong> {{ $student_registration->english_final_admission_date }} A.D.
                </li>
            @endisset
            @isset($student_registration->nepali_final_admission_date)
                <li class="list-group-item">
                    <strong>Nepali Final Admission Date:</strong> {{ $student_registration->nepali_final_admission_date }} B.S.
                </li>
            @endisset
            @isset($student_registration->approved_by)
                <li class="list-group-item">
                    <strong>Approved By:</strong> {{ $student_registration->approved_by }}
                </li>
            @endisset
            @isset($student_registration->known_from)
                <li class="list-group-item">
                    <strong>Known From:</strong> {{ \App\StudentRegistration::KnownFrom[$student_registration->known_from] }}
                </li>
            @endisset
            @if(isset($student_registration->known_from) && ($student_registration->known_from_other) && \App\StudentRegistration::KnownFrom[$student_registration->known_from] == 'Others')
                <li class="list-group-item">
                    <strong>Others:</strong> {{ $student_registration->known_from_other }}
                </li>
            @endisset
        </ul>

        <ul class="list-group">
            <li class="list-group-item">
                <strong>Created By:</strong> {{ $student_registration->createdBy->name }}
            </li>
            <li class="list-group-item">
                <strong>Updated By:</strong> {{ $student_registration->updatedBy->name }}
            </li>
        </ul>
    </div>

    <div class="portlet-footer">
        <div class="form-group">
            <a href="{{ route('student-registration.index') }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
            Back</a>
        </div>
    </div>
@endsection

