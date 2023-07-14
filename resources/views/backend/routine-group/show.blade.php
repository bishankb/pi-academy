@extends('layouts.backend')

@section('title')
    Show Group
@endsection

@section('content')

    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h1 class="page-title font-green sbold">
                    <i class="fa fa-television font-green"></i> Group
                    <small class="font-green sbold">Show</small>
                </h1>
            </div>
        </div>
    </div>
    <div class="portlet-body">
        <ul class="list-group">
            <li class="list-group-item">
                <strong>Name:</strong> {{ $routine_group->name }}
            </li>
            <li class="list-group-item">
                <strong>Shift:</strong> {{ $shifts[$routine_group->shift] }}
            </li>
            @isset($routine_group->description)
                <li class="list-group-item">
                    <strong>Description:</strong> {{ $routine_group->description }}
                </li>
            @endisset
            
        </ul>
        <ul class="list-group">
            <li class="list-group-item">
                <strong>Created By:</strong> {{ $routine_group->createdBy->name }}
            </li>
            <li class="list-group-item">
                <strong>Updated By:</strong> {{ $routine_group->updatedBy->name }}
            </li>
        </ul>
    </div>

    <div class="portlet-footer">
        <div class="form-group">
            <a href="{{ route('routine-groups.index') }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
            Back</a>
        </div>
    </div>
@endsection

