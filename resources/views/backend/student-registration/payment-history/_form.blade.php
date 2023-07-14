<div class="row">
    <div class="col-md-12">
        <div class="form-group required {{ $errors->has('payment_amount') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('payment_amount', 'Payment Amount', ['class' => 'control-label']) !!}

            {!! Form::text('payment_amount', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Payment Amount' ]) !!}

            @if ($errors->has('payment_amount'))
                <div class="ui pointing red basic label"> {{$errors->first('payment_amount')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group required {{ $errors->has('english_payment_date') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('english_payment_date', 'English Payment Date', ['class' => 'control-label']) !!}

            {!! Form::text('english_payment_date', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'English Payment Date', 'id' => 'english_date_picker', 'data-conversion-type' => 'english-nepali']) !!}

            @if ($errors->has('english_payment_date'))
                <div class="ui pointing red basic label"> {{$errors->first('english_payment_date')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group required {{ $errors->has('nepali_payment_date') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('nepali_payment_date', 'Nepali Payment Date', ['class' => 'control-label']) !!}

            {!! Form::text('nepali_payment_date', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Nepali Payment Date', 'id' => 'nepali_date_picker', 'data-conversion-type' => 'nepali-english']) !!}

            @if ($errors->has('nepali_payment_date'))
                <div class="ui pointing red basic label"> {{$errors->first('nepali_payment_date')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group {{ $errors->has('payment_time') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('payment_time', 'Payment Time', ['class' => 'control-label']) !!}

            {!! Form::text('payment_time', null, ['class' => 'form-control custom-time', 'placeholder'=>'Payment Time']) !!}

            @if ($errors->has('payment_time'))
                <div class="ui pointing red basic label"> {{$errors->first('payment_time')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('receipt_number') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('receipt_number', 'Receipt Number', ['class' => 'control-label']) !!}

            {!! Form::text('receipt_number', null, ['class' => 'form-control', 'placeholder'=>'Receipt Number', 'id' => 'receipt_number' ]) !!}

            @if ($errors->has('receipt_number'))
                <div class="ui pointing red basic label"> {{$errors->first('receipt_number')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('received_by') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('received_by', 'Received By', ['class' => 'control-label']) !!}

            {!! Form::select('received_by', $users, null,['id'=>'received_by', 'class' => 'form-control custom-select', 'placeholder' => 'Select the user', 'id' => '' ]) !!}

            @if ($errors->has('received_by'))
                <div class="ui pointing red basic label"> {{$errors->first('received_by')}}</div>
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
