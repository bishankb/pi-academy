@extends('layouts.backend')

@section('title')
    Show Transaction
@endsection

@section('content')

    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h1 class="page-title font-green sbold">
                    <i class="fa fa-television font-green"></i> Transaction
                    <small class="font-green sbold">Show</small>
                </h1>
            </div>
        </div>
    </div>
    <div class="portlet-body">
        <ul class="list-group">
            <li class="list-group-item">
                <strong>Tranaction Id:</strong> {{ $transaction->transaction_id }}
            </li>
            <li class="list-group-item">
                <strong>Tranaction Type:</strong> {{ \App\Transaction::TransactionType[$transaction->transaction_type] }}
            </li>
            <li class="list-group-item">
                <strong>English Transaction Date:</strong> {{ $transaction->english_transaction_date }} A.D.
            </li>
            <li class="list-group-item">
                <strong>Nepali Transaction Date:</strong> {{ $transaction->nepali_transaction_date }} B.S.
            </li>
            <li class="list-group-item">
                <strong>Transaction Time:</strong> {{ $transaction->transaction_time }}
            </li>
            <li class="list-group-item">
                <strong>Payment Amount:</strong> {{ nepaliCurrencyFormat($transaction->payment_amount) }}
            </li>
            <li class="list-group-item">
                <strong>Payment Type:</strong> {{ \App\Transaction::PaymentType[$transaction->payment_type] }}
            </li>
            @if(\App\Transaction::PaymentType[$transaction->payment_type] == 'Cheque')
                <li class="list-group-item">
                    <strong>Cheque Number:</strong> {{ $transaction->cheque_number }}
                </li>
            @endif
            @if(\App\Transaction::TransactionType[$transaction->transaction_type] == 'Expenditure')
                <li class="list-group-item">
                    <strong>Expend By:</strong> {{ $transaction->expendBy->name }}
                </li>
            @else(\App\Transaction::TransactionType[$transaction->transaction_type] == 'Income')
                <li class="list-group-item">
                    <strong>Paid By:</strong> {{ $transaction->paid_by }}
                </li>
            @endif
            @isset($transaction->remarks)
                <li class="list-group-item">
                    <strong>Remarks:</strong> {{ $transaction->remarks }}
                </li>
            @endisset
            
        </ul>
        <ul class="list-group">
            <li class="list-group-item">
                <strong>Created By:</strong> {{ $transaction->createdBy->name }}
            </li>
            <li class="list-group-item">
                <strong>Updated By:</strong> {{ $transaction->updatedBy->name }}
            </li>
        </ul>
    </div>

    <div class="portlet-footer">
        <div class="form-group">
            <a href="{{ route('transactions.index') }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
            Back</a>
        </div>
    </div>
@endsection

