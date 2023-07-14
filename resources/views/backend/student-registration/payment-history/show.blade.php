@extends('layouts.backend')

@section('title')
    Show Payment Detail
@endsection

@section('content')

    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h1 class="page-title font-green sbold">
                    <i class="fa fa-television font-green"></i> {{ $student_registration->first_name }} @isset($student_registration->middle_name) {{ $student_registration->middle_name }} @endisset {{ $student_registration->last_name }}
                    <small class="font-green sbold">Payment Details</small>
                </h1>
            </div>
        </div>
    </div>
    <div class="portlet-body">
        <ul class="list-group">
            <li class="list-group-item">
                <strong>Total Fee to be Paid:</strong> {{ nepaliCurrencyFormat($student_registration->fee_after_scholarship) }}
            </li>
            @isset($student_registration->due_clearance_date)
                <li class="list-group-item">
                    <strong>Due Clearance Date:</strong> {{ $student_registration->due_clearance_date->format('d M, Y | h:i:s a') }}
                </li>
            @endisset
        </ul>
        <ul class="list-group">
            <li class="list-group-item">
                <strong>Payment Amount:</strong> {{ nepaliCurrencyFormat($payment_history->payment_amount) }}
            </li>
            <li class="list-group-item">
                <strong>English Payment Date:</strong> {{ $payment_history->english_payment_date }} A.D.
            </li>
            <li class="list-group-item">
                <strong>Nepali Payment Date:</strong> {{ $payment_history->nepali_payment_date }} B.S.
            </li>
            <li class="list-group-item">
                <strong>Payment Time:</strong> {{ $payment_history->payment_time }}
            </li>
            <li class="list-group-item">
                <strong>Receipt Number:</strong> {{ $payment_history->receipt_number }}
            </li>
            @isset($payment_history->received_by)
                <li class="list-group-item">
                    <strong>Received By:</strong> {{ $payment_history->receivedBy->name }}
                </li>
            @endisset
            @isset($payment_history->remarks)
                <li class="list-group-item">
                    <strong>Remarks:</strong> {{ $payment_history->remarks }}
                </li>
            @endisset
        </ul>
        <ul class="list-group">
            <li class="list-group-item">
                <strong>Created By:</strong> {{ $payment_history->createdBy->name }}
            </li>
            <li class="list-group-item">
                <strong>Updated By:</strong> {{ $payment_history->updatedBy->name }}
            </li>
        </ul>
    </div>

    <div class="portlet-footer">
        <div class="form-group">
            <a href="{{ route('student-payment-history.index', $student_registration->id) }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
            Back</a>
        </div>
    </div>
@endsection

