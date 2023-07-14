@extends('layouts.backend')

@section('title')
  Edit Payment
@endsection

@section('content')
    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h1 class="page-title font-green sbold">
                    <i class="fa fa-television font-green"></i>  {{ $student_registration->first_name }} @isset($student_registration->middle_name) {{ $student_registration->middle_name }} @endisset {{ $student_registration->last_name }}
                    <small class="font-green sbold">Edit Payment</small>
                </h1>
            </div>
        </div>
    </div>
    {!! Form::model($payment_history, ['method' => 'PUT', 'route' => ['student-payment-history.update', $student_registration->id, $payment_history->id]]) !!}
        <div class="portlet-body">
           
            @include('backend.student-registration.payment-history._form')

        </div>

        <div class="portlet-footer">
            <div class="form-group">
                <a href="{{ route('student-payment-history.index', $student_registration->id) }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
                Back</a>

                <button class="btn btn-primary green" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;Update
                </button>
            </div>
        </div>
    {!! Form::close() !!}
@endsection