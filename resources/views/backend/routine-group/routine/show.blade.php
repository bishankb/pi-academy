@extends('layouts.backend')

@section('title')
    Show Routine
@endsection

@section('content')

    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h1 class="page-title font-green sbold">
                    <i class="fa fa-television font-green"></i> {{ $routine_group->name }}
                    <small class="font-green sbold">Show</small>
                </h1>
            </div>
        </div>
    </div>
    <div class="portlet-body">
        <ul class="list-group">
            <li class="list-group-item">
                <strong>English Routine Date:</strong> {{ $routine->english_routine_date }} A.D.
            </li>
            <li class="list-group-item">
                <strong>Nepali Routine Date:</strong> {{ $routine->nepali_routine_date }} B.S.
            </li>
        </ul>

        @foreach($routine_class_times as $key => $routine_class_time)
            <ul class="list-group">
                <li class="list-group-item">
                    <strong>{{ $loop->iteration }}) Class Time:</strong> {{ \Carbon\Carbon::parse($routine_class_time->class_start_time)->format('h:i:s a') }} - {{ \Carbon\Carbon::parse($routine_class_time->class_end_time)->format('h:i:s a') }}
                </li>
                <li class="list-group-item">
                    <strong>Teacher:</strong> {{ $routine->routineClass->where('class_time_id', $routine_class_time->id)->first()->teacher->name }}
                </li>
                <li class="list-group-item">
                    <strong>Subject:</strong> {{ $subjects[$routine->routineClass->where('class_time_id', $routine_class_time->id)->first()->subject] }}
                </li>
                <li class="list-group-item">
                    <strong>Topic Taught:</strong> {{ $routine->routineClass->where('class_time_id', $routine_class_time->id)->first()->topic_taught }}
                </li>
            </ul>
        @endforeach
        
        <ul class="list-group">
            <li class="list-group-item">
                <strong>Created By:</strong> {{ $routine->createdBy->name }}
            </li>
            <li class="list-group-item">
                <strong>Updated By:</strong> {{ $routine->updatedBy->name }}
            </li>
        </ul>
    </div>

    <div class="portlet-footer">
        <div class="form-group">
            <a href="{{ route('routines.index', $routine_group->id) }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
            Back</a>
        </div>
    </div>
@endsection

