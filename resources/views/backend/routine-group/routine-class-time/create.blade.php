@extends('layouts.backend')

@section('title')
  Add Time
@endsection

@section('content')
    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h1 class="page-title font-green sbold">
                    <i class="fa fa-television font-green"></i> {{ $routine_group->name }}
                    <small class="font-green sbold">Add Time</small>
                </h1>
            </div>
        </div>
    </div>
    {!! Form::model(null, ['method' => 'post', 'route' => ['routine-class-time.store', $routine_group->id]]) !!}
        <div class="portlet-body">
    
            @include('backend.routine-group.routine-class-time._form')
        
        </div>

        <div class="portlet-footer">
            <div class="form-group">
                <a href="{{ route('routine-class-time.index', $routine_group->id) }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
                Back</a>

                <button class="btn btn-primary green" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;Save
                </button>
            </div>
        </div>
    {!! Form::close() !!}
@endsection
