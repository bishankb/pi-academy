@extends('layouts.backend')

@section('title')
  Edit Examination Credentials
@endsection

@section('content')
    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h1 class="page-title font-green sbold">
                    <i class="fa fa-television font-green"></i> {{ $examination_credential->student->first_name }} @isset($examination_credential->student->middle_name) {{ $examination_credential->student->middle_name }} @endisset {{ $examination_credential->student->last_name }}
                    <small class="font-green sbold">Edit Examination Credentials</small>
                </h1>
            </div>
        </div>
    </div>
    {!! Form::model($examination_credential, ['method' => 'PUT', 'route' => ['student-registration.updateExaminationCredential', $examination_credential->student->id, $examination_credential->id]]) !!}
        <div class="portlet-body">
           
            @include('backend.student-registration.examination-credential._form')

        </div>

        <div class="portlet-footer">
            <div class="form-group">
                <a href="{{ route('student-registration.index') }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
                Back</a>

                <button class="btn btn-primary green" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;Update
                </button>
            </div>
        </div>
    {!! Form::close() !!}
@endsection