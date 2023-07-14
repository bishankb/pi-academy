@extends('layouts.backend')

@section('title')
  Push Notification
@endsection

@section('content')
    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h1 class="page-title font-green sbold">
                    <i class="fa fa-television font-green"></i> Push Notification
                    <small class="font-green sbold">Create</small>
                </h1>
            </div>
        </div>
    </div>
    {!! Form::model(null, ['method' => 'post', 'route' => ['push-notification.store']]) !!}
        <div class="portlet-body">
    
            @include('backend.push-notification._form')
        
        </div>

        <div class="portlet-footer">
            <div class="form-group">
                <button class="btn btn-primary green" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;Send
                </button>
            </div>
        </div>
    {!! Form::close() !!}
@endsection