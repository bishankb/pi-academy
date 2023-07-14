@extends('layouts.backend')

@section('title')
  Edit Group
@endsection

@section('content')
    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h1 class="page-title font-green sbold">
                    <i class="fa fa-television font-green"></i> Group
                    <small class="font-green sbold">Edit</small>
                </h1>
            </div>
        </div>
    </div>
    {!! Form::model($routine_group, ['method' => 'PUT', 'route' => ['routine-groups.update',  $routine_group->id ]]) !!}
        <div class="portlet-body">
           
            @include('backend.routine-group._form')

        </div>

        <div class="portlet-footer">
            <div class="form-group">
                <a href="{{ route('routine-groups.index') }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
                Back</a>

                <button class="btn btn-primary green" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;Update
                </button>
            </div>
        </div>
    {!! Form::close() !!}
@endsection