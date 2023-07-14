@extends('layouts.backend')

@section('title')
  Edit Visitor
@endsection

@section('content')
    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h1 class="page-title font-green sbold">
                    <i class="fa fa-television font-green"></i> Visitor
                    <small class="font-green sbold">Edit</small>
                </h1>
            </div>
        </div>
    </div>
    {!! Form::model($visitor, ['method' => 'PUT', 'route' => ['visitors.update',  $visitor->id ], 'files' => 'true']) !!}
        <div class="portlet-body">
           
            @include('backend.visitor._form')

        </div>

        <div class="portlet-footer">
            <div class="form-group">
                <a href="{{ route('visitors.index') }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
                Back</a>

                <button class="btn btn-primary green" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;Update
                </button>
            </div>
        </div>
    {!! Form::close() !!}
@endsection

@section('backend-script')
  <script type="text/javascript">
    $(document).ready(function() {
        @if($visitor->is_accompanied == 1)
            $('#accompaniedBy_div').show();
        @else 
            $('#accompaniedBy_div').hide();
        @endif

        var isAccompanied = '{{ old('is_accompanied') }}';
        if(isAccompanied && isAccompanied == 'on') {
            $('#accompaniedBy_div').show();
        }

        if($('#is_accompanied').prop("checked") == false) {
            $('#accompaniedBy_div').hide();
        }
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