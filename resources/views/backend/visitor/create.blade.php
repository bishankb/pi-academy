@extends('layouts.backend')

@section('title')
  Create Visitor
@endsection

@section('backend-style')
    <style>
        #accompaniedBy_div {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h1 class="page-title font-green sbold">
                    <i class="fa fa-television font-green"></i> Visitor
                    <small class="font-green sbold">Create</small>
                </h1>
            </div>
        </div>
    </div>
    {!! Form::model(null, ['method' => 'post', 'route' => ['visitors.store'], 'files' => 'true']) !!}
        <div class="portlet-body">
    
            @include('backend.visitor._form')
        
        </div>

        <div class="portlet-footer">
            <div class="form-group">
                <a href="{{ route('visitors.index') }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
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
        @if(!empty(old('is_accompanied')) && old('is_accompanied') == true)
            $('#accompaniedBy_div').show();
        @else
            $('#accompaniedBy_div').hide();
        @endif
    });

    $('#is_accompanied').click(function () {
        if($(this).prop("checked") == true){
            $('#accompaniedBy_div').show();
        }
        else if($(this).prop("checked") == false){
            $('#accompaniedBy_div').hide();
            $('#accompanied_by').val('');
        }
    });
  </script>
@endsection
