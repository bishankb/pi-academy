@extends('layouts.backend')

@section('title')
  Edit Meeting
@endsection

@section('content')
    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h1 class="page-title font-green sbold">
                    <i class="fa fa-television font-green"></i> Meeting
                    <small class="font-green sbold">Edit</small>
                </h1>
            </div>
        </div>
    </div>
    {!! Form::model($meeting, ['method' => 'PUT', 'route' => ['meeting.update',  $meeting->id ], 'files' => 'true']) !!}
        <div class="portlet-body">
           
            @include('backend.meeting._form')

        </div>

        <div class="portlet-footer">
            <div class="form-group">
                <a href="{{ route('meeting.index') }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
                Back</a>

                <button class="btn btn-primary green" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;Update
                </button>
            </div>
        </div>
    {!! Form::close() !!}
@endsection

@section('backend-script')
    <script type="text/javascript">
        @if($meeting->file)
            $('#deleteFile').click(function () {
                dataId = $('#deleteFile').attr('data-target-id');
                $.ajax({
                    type     : "POST",
                    headers  : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url      : "{{route('meeting.destroyFile', '')}}/"+dataId,
                    success: function(response){
                        if (response.success) {
                        }
                    },
                    error: function(data){
                        alert("There was some internal error.");
                        window.location.reload();
                    },
                });
            });
        @endif
    </script>
@endsection