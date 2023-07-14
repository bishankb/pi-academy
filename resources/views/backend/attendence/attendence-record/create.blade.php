@extends('layouts.backend')

@section('title')
  {{$staff->name}} Add Attendence
@endsection

@section('backend-style')
    <style>
        #leaveReason_div, #holidayReason_div, #gapDepartureTime_div, #gapArrivalTime_div, #gapReason_div {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h1 class="page-title font-green sbold">
                    <i class="fa fa-television font-green"></i> {{$staff->name}}
                    <small class="font-green sbold">Add Attendence</small>
                </h1>
            </div>
        </div>
    </div>
    {!! Form::model(null, ['method' => 'post', 'route' => ['attendence.store', $staff->id]]) !!}
        <div class="portlet-body">
    
            @include('backend.attendence.attendence-record._form')
        
        </div>

        <div class="portlet-footer">
            <div class="form-group">
                <a href="{{ route('attendence.index', $staff->id) }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
                Back</a>

                <button class="btn btn-primary green" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;Save
                </button>
            </div>
        </div>
    {!! Form::close() !!}
@endsection

@section('backend-script')
  <script type="text/javascript">
    $(document).ready(function() {
        @if(!empty(old('has_taken_leave')) && old('has_taken_leave') == true)
            $('#leaveReason_div').show();
            hidePresentField();
            $('#is_holiday').attr("disabled", true);
        @else
            $('#leaveReason_div').hide();
        @endif

        @if(!empty(old('is_holiday')) && old('is_holiday') == true)
            $('#holidayReason_div').show();
            hidePresentField();
            $('#has_taken_leave').attr("disabled", true);
        @else
            $('#is_holiday').hide();
        @endif

        @if(!empty(old('has_taken_gap')) && old('has_taken_gap') == true)
            showGapField();
        @else
            hideGapField();
        @endif
    });

    $('#has_taken_leave').click(function () {
        if($(this).prop("checked") == true){
            $('#leaveReason_div').show();
            hidePresentField();
            clearPresentField();
            $('#is_holiday').attr("disabled", true);
            $('#has_taken_gap').attr('checked', false);
            hideGapField();
            clearGapField();
        }
        else if($(this).prop("checked") == false){
            $('#leaveReason_div').hide();
            $('#leave_reason').val('');
            showPresentField();
            $('#is_holiday').attr("disabled", false);
            $('#has_taken_gap').attr('checked', false);
        }
    });

    $('#is_holiday').click(function () {
        if($(this).prop("checked") == true){
            $('#holidayReason_div').show();
            hidePresentField();
            clearPresentField();
            $('#has_taken_leave').attr("disabled", true);
            $('#has_taken_gap').attr('checked', false);
            hideGapField();
            clearGapField();
        }
        else if($(this).prop("checked") == false){
            $('#holidayReason_div').hide();
            $('#holiday_reason').val('');
            showPresentField();
            $('#has_taken_leave').attr("disabled", false);
        }
    });

    $('#has_taken_gap').click(function () {
        if($(this).prop("checked") == true){
            showGapField();
        }
        else if($(this).prop("checked") == false){
            hideGapField();
            clearGapField();
        }
    });

    function hidePresentField() {
        $('#arrivalTime_div').hide();
        $('#departureTime_div').hide();
        $('#hasTakenGap_div').hide();
    }

    function clearPresentField() {
        $('#arrival_time').val('');
        $('#departure_time').val('');
        $('#has_taken_gap').val('');
    }

    function showPresentField() {
        $('#arrivalTime_div').show();
        $('#departureTime_div').show();
        $('#hasTakenGap_div').show();
    }

    function hideGapField() {
        $('#gapDepartureTime_div').hide();
        $('#gapArrivalTime_div').hide();
        $('#gapReason_div').hide();
    }

    function clearGapField() {
        $('#gap_departure_time').val('');
        $('#gap_arrival_time').val('');
        $('#gap_reason').val('');
    }

    function showGapField() {
        $('#gapDepartureTime_div').show();
        $('#gapArrivalTime_div').show();
        $('#gapReason_div').show();
    }
  </script>
@endsection
