@extends('layouts.backend')

@section('title')
    Show Attendence Detail
@endsection

@section('content')
    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h1 class="page-title font-green sbold">
                    <i class="fa fa-television font-green"></i> {{$staff->name}}
                    <small class="font-green sbold">Attendence Detail</small>
                </h1>
            </div>
        </div>
    </div>
    <div class="portlet-body">
        <ul class="list-group">
            <li class="list-group-item">
                <strong>English Attendence Date:</strong> {{ $attendence->english_attendence_date }} A.D.
            </li>
            <li class="list-group-item">
                <strong>Nepali Attendence Date:</strong> {{ $attendence->nepali_attendence_date }} B.S.
            </li>
            <li class="list-group-item">
                <strong>Attendence Status:</strong> 
                @if($attendence->has_taken_leave == 1)
                    On Leave
                @elseif($attendence->is_holiday == 1)
                    Holiday
                @else
                    Present
                @endif
            </li>
            @if($attendence->has_taken_leave == 1)
                <li class="list-group-item">
                    <strong>Leave Reason:</strong> {{ $attendence->leave_reason }}
                </li>
            @elseif($attendence->is_holiday == 1)
                <li class="list-group-item">
                    <strong>Holiday Reason:</strong> {{ $attendence->holiday_reason }}
                </li>
            @endif

            @isset($attendence->arrival_time)
                <li class="list-group-item">
                    <strong>Arrival Time:</strong> {{ $attendence->arrival_time }}
                </li>
            @endisset
            @isset($attendence->departure_time)
                <li class="list-group-item">
                    <strong>Departure Time:</strong> {{ $attendence->departure_time }}
                </li>
            @endisset

            @if($attendence->has_taken_gap == 1)
                <li class="list-group-item">
                    <strong>Gap Departure Time:</strong> {{ $attendence->gap_departure_time }}
                </li>

                <li class="list-group-item">
                    <strong>Gap Arrival Time:</strong> {{ $attendence->gap_arrival_time }}
                </li>

                <li class="list-group-item">
                    <strong>Gap Hour:</strong> {{ \Carbon\Carbon::parse($attendence->gap_arrival_time)->diffInHours(\Carbon\Carbon::parse($attendence->gap_departure_time)) }} hr
                </li>

                @isset($attendence->gap_reason))
                    <li class="list-group-item">
                        <strong>Gap Reason:</strong> {{ $attendence->gap_reason }}
                    </li>
                @endisset
            @endif

            <li class="list-group-item">
                <strong>Worked Hour:</strong> {{ $attendence->worked_hour }} hr
            </li>
        </ul>

        <ul class="list-group">
            <li class="list-group-item">
                <strong>Created By:</strong> {{ $attendence->createdBy->name }}
            </li>
            <li class="list-group-item">
                <strong>Updated By:</strong> {{ $attendence->updatedBy->name }}
            </li>
        </ul>
    </div>

    <div class="portlet-footer">
        <div class="form-group">
            <a href="{{ route('attendence.index', $staff->id) }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
            Back</a>
        </div>
    </div>
@endsection

