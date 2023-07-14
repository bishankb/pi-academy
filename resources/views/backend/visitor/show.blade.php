@extends('layouts.backend')

@section('title')
    Show Visitor Information
@endsection

@section('content')
    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h1 class="page-title font-green sbold">
                    <i class="fa fa-television font-green"></i> Visitor Information
                    <small class="font-green sbold">Show</small>
                </h1>
            </div>
        </div>
    </div>
    <div class="portlet-body">
        <ul class="list-group">
            <li class="list-group-item">
                <strong>Name:</strong> {{ $visitor->name }}
            </li>
            @can('view_confidentials')
                @isset($visitor->college_name)
                    <li class="list-group-item">
                        <strong>College Name:</strong> {{ $visitor->college_name }}
                    </li>
                @endisset
            @endcan
            @isset($visitor->marks_obtained)
                <li class="list-group-item">
                    <strong>Grade / Percentage:</strong> {{ $visitor->marks_obtained }}
                </li>
            @endisset
            @isset($visitor->academic_status)
                <li class="list-group-item">
                    <strong>Academic Status:</strong> {{ \App\Visitor::AcademicStatus[$visitor->academic_status] }}
                </li>
            @endisset
            <li class="list-group-item">
                <strong>English Visited Date:</strong> {{ $visitor->english_visited_date }} A.D.
            </li>
            <li class="list-group-item">
                <strong>Nepali Visited Date:</strong> {{ $visitor->nepali_visited_date }} B.S.
            </li>
            <li class="list-group-item">
                <strong>Visited Time:</strong> {{ $visitor->visited_time }}
            </li>
            @isset($visitor->counselled_by)
                <li class="list-group-item">
                    <strong>Counselled By:</strong> {{ $visitor->counselledBy->name }}
                </li>
            @endisset

            <li class="list-group-item">
                <strong>Register Status:</strong> @if($visitor->is_registered == 1)  Registered @else Not Register @endif
            </li>

            <li class="list-group-item">
                <strong>Accompanied:</strong> @if($visitor->is_accompanied == 1)  Yes @else No @endif
            </li>

            @isset($visitor->accompanied_by)
                <li class="list-group-item">
                    <strong>Accompanied By:</strong> {{ $visitor->accompanied_by }}
                </li>
            @endisset

            @isset($visitor->interested_course)
                <li class="list-group-item">
                    <strong>Interested Course:</strong> {{ \App\ScholarshipTest::InterestedCourse[$visitor->interested_course] }}
                </li>
            @endisset
        </ul>

        <ul class="list-group">
            <li class="list-group-item">
                <strong>Created By:</strong> {{ $visitor->createdBy->name }}
            </li>
            <li class="list-group-item">
                <strong>Updated By:</strong> {{ $visitor->updatedBy->name }}
            </li>
        </ul>
    </div>

    <div class="portlet-footer">
        <div class="form-group">
            <a href="{{ route('visitors.index') }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
            Back</a>
        </div>
    </div>
@endsection

