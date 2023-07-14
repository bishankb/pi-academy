@extends('layouts.backend')

@section('title')
    Show Routine
@endsection

@section('content')

    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h1 class="page-title font-green sbold">
                    <i class="fa fa-television font-green"></i> {{ $teacher->name }}
                    <small class="font-green sbold">Show</small>
                </h1>
            </div>
        </div>
    </div>
    <div class="portlet-body">
        <ul class="list-group">
            <li class="list-group-item">
                <strong>English Routine Date:</strong> {{ $routine_class->routine->english_routine_date }} A.D.
            </li>
            <li class="list-group-item">
                <strong>Nepali Routine Date:</strong> {{ $routine_class->routine->nepali_routine_date }} B.S.
            </li>
        </ul>

        <ul class="list-group">
            <li class="list-group-item">           
                <strong>Routine Group:</strong> {{ $routine_class->routineClassTime->routineGroup->name }}
            </li>
            <li class="list-group-item">
                <strong>Start Time:</strong> {{ \Carbon\Carbon::parse($routine_class->routineClassTime->class_start_time)->format('h:i:s a')}}
            </li>
            <li class="list-group-item">
                <strong>End Time:</strong>
                {{ \Carbon\Carbon::parse($routine_class->routineClassTime->class_start_time)->format('h:i:s a')}}
            </li>
            <li class="list-group-item">
                <strong>Subject:</strong> {{ $subjects[$routine_class->subject] }}
            </li>
            <li class="list-group-item">
                <strong>Topic Taught:</strong> {{ $routine_class->topic_taught }}
            </li>
        </ul>
        
        <ul class="list-group">
            <li class="list-group-item">
                <strong>Created By:</strong> {{ $routine_class->createdBy->name }}
            </li>
            <li class="list-group-item">
                <strong>Updated By:</strong> {{ $routine_class->updatedBy->name }}
            </li>
        </ul>
    </div>

    <div class="portlet-footer">
        <div class="form-group">
            <a href="{{ route('teacher-routine.index', $teacher->id) }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
            Back</a>
        </div>
    </div>
@endsection

