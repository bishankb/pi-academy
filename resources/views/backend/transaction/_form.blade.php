<div class="row">
    <div class="col-md-12">
       <div class="form-group required {{ $errors->has('transaction_type') ? ' has-error' : '' }} clearfix">
            {!! Form::label('transaction_type', 'Transaction Type', ['class' => 'control-label']) !!}

            {!! Form::select('transaction_type', $transaction_types, (isset($transaction) ? $transaction->transaction_type : 0),['id'=>'transaction_type', 'class' => 'form-control', 'placeholder' => 'Select the transaction type']) !!}

            @if ($errors->has('transaction_type'))
                <div class="ui pointing red basic label"> {{$errors->first('transaction_type')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group required {{ $errors->has('english_transaction_date') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('english_transaction_date', 'English Transaction Date', ['class' => 'control-label']) !!}

            {!! Form::text('english_transaction_date', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'English Transaction Date', 'id' => 'english_date_picker', 'data-conversion-type' => 'english-nepali']) !!}

            @if ($errors->has('english_transaction_date'))
                <div class="ui pointing red basic label"> {{$errors->first('english_transaction_date')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group required {{ $errors->has('nepali_transaction_date') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('nepali_transaction_date', 'Nepali Transaction Date', ['class' => 'control-label']) !!}

            {!! Form::text('nepali_transaction_date', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Nepali Transaction Date', 'id' => 'nepali_date_picker', 'data-conversion-type' => 'nepali-english']) !!}

            @if ($errors->has('nepali_transaction_date'))
                <div class="ui pointing red basic label"> {{$errors->first('nepali_transaction_date')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group {{ $errors->has('transaction_time') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('transaction_time', 'Transaction Time', ['class' => 'control-label']) !!}

            {!! Form::text('transaction_time', null, ['class' => 'form-control custom-time', 'placeholder'=>'Transaction Time']) !!}

            @if ($errors->has('transaction_time'))
                <div class="ui pointing red basic label"> {{$errors->first('transaction_time')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('payment_amount') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('payment_amount', 'Payment Amount', ['class' => 'control-label']) !!}

            {!! Form::text('payment_amount', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Payment Amount' ]) !!}

            @if ($errors->has('payment_amount'))
                <div class="ui pointing red basic label"> {{$errors->first('payment_amount')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('payment_type') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('payment_type', 'Payment Type', ['class' => 'control-label']) !!}

            {!! Form::select('payment_type', $payment_types, (isset($transaction) ? $transaction->payment_type : 0), ['id'=>'payment_type', 'class' => 'form-control', 'placeholder' => 'Select the transaction type']) !!}

            @if ($errors->has('payment_type'))
                <div class="ui pointing red basic label"> {{$errors->first('payment_type')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6" id="chequeNumber_div">
        <div class="form-group required {{ $errors->has('cheque_number') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('cheque_number', 'Cheque Number', ['class' => 'control-label']) !!}

            {!! Form::text('cheque_number', null, ['class' => 'form-control', 'placeholder'=>'Cheque Number', 'id' => 'cheque_number' ]) !!}

            @if ($errors->has('cheque_number'))
                <div class="ui pointing red basic label"> {{$errors->first('cheque_number')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12" id="expendBy_div">
        <div class="form-group required {{ $errors->has('expend_by') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('expend_by', 'Expend By', ['class' => 'control-label']) !!}

            {!! Form::select('expend_by', $users, null,['id'=>'expend_by', 'class' => 'form-control custom-select', 'placeholder' => 'Select the user', 'id' => '' ]) !!}

            @if ($errors->has('expend_by'))
                <div class="ui pointing red basic label"> {{$errors->first('expend_by')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-12" id="paidBy_div">
        <div class="form-group {{ $errors->has('paid_by') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('paid_by', 'Paid By', ['class' => 'control-label']) !!}

            {!! Form::text('paid_by', null, ['id'=>'paid_by', 'class' => 'form-control', 'placeholder'=>'Paid By' ]) !!}

            @if ($errors->has('paid_by'))
                <div class="ui pointing red basic label"> {{$errors->first('paid_by')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group {{ $errors->has('remarks') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('remarks', 'Remarks', ['class' => 'control-label']) !!}

            {!! Form::textarea('remarks', null, ['class' => 'form-control', 'placeholder'=>'Remarks', 'rows' => 4 ]) !!}

            @if ($errors->has('remarks'))
                <div class="ui pointing red basic label"> {{$errors->first('remarks')}}</div>
            @endif
        </div>
    </div>
</div>
