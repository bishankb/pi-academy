@extends('layouts.backend')

@section('title')
    Show Class Time Detail
@endsection

@section('content')

    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h1 class="page-title font-green sbold">
                    <i class="fa fa-television font-green"></i> {{ $routine_group->name }}
                    <small class="font-green sbold">Class Time</small>
                </h1>
            </div>
        </div>
    </div>
    <div class="portlet-body">
        <ul class="list-group">
            <li class="list-group-item">
                <strong>Class Start Time:</strong> {{ $routine_class_time->class_start_time }}
            </li>
            <li class="list-group-item">
                <strong>Class End Time:</strong> {{ $routine_class_time->class_end_time }}
            </li>
            <li class="list-group-item">
                <strong>Order:</strong> {{ $routine_class_time->order }}
            </li>
        </ul>
        <ul class="list-group">
            <li class="list-group-item">
                <strong>Created By:</strong> {{ $routine_class_time->createdBy->name }}
            </li>
            <li class="list-group-item">
                <strong>Updated By:</strong> {{ $routine_class_time->updatedBy->name }}
            </li>
        </ul>
    </div>

    <div class="portlet-footer">
        <div class="form-group">
            <a href="{{ route('routine-class-time.index', $routine_group->id) }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
            Back</a>
        </div>
    </div>
@endsection

