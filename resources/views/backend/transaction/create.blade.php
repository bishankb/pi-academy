@extends('layouts.backend')

@section('title')
  Create Transaction
@endsection

@section('backend-style')
    <style>
        #paidBy_div, #chequeNumber_div {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h1 class="page-title font-green sbold">
                    <i class="fa fa-television font-green"></i> Transaction
                    <small class="font-green sbold">Create</small>
                </h1>
            </div>
        </div>
    </div>
    {!! Form::model(null, ['method' => 'post', 'route' => ['transactions.store']]) !!}
        <div class="portlet-body">
    
            @include('backend.transaction._form')
        
        </div>

        <div class="portlet-footer">
            <div class="form-group">
                <a href="{{ route('transactions.index') }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
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
            @if(!empty(old('transaction_type')) && \App\Transaction::TransactionType[old('transaction_type')] == 'Income')
                $('#expendBy_div').hide();
                $('#paidBy_div').show();
            @elseif(!empty(old('transaction_type')) && \App\Transaction::TransactionType[old('transaction_type')] == 'Expenditure')
                $('#expendBy_div').show();
                $('#paidBy_div').hide();
            @endif

            @if(!empty(old('payment_type')) && \App\Transaction::PaymentType[old('payment_type')] == 'Cheque')
                $('#chequeNumber_div').show();
            @else
                $('#chequeNumber_div').hide();
            @endif
        });


        $('#transaction_type').change(function (event) {
            var transactionType = event.target.value;
            var transactionTypes = {!! json_encode($transaction_types, JSON_HEX_TAG) !!};
            if(transactionTypes[event.target.value] == 'Income') {
                $('#paidBy_div').show();
                $('#expendBy_div').hide();
                $(".custom-select").val('').trigger('change') ;
            } else {
                $('#paidBy_div').hide();
                $('#expendBy_div').show();
                $('#paid_by').val('');
            }
        });

        $('#payment_type').change(function (event) {
            var paymentType = event.target.value;
            var paymentTypes = {!! json_encode($payment_types, JSON_HEX_TAG) !!};
            if(paymentTypes[event.target.value] == 'Cheque') {
                $('#chequeNumber_div').show();
            } else {
                $('#chequeNumber_div').hide();
                $('#cheque_number').val('');
            }
        });
    </script>
@endsection
