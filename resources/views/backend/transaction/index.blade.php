@extends('layouts.backend')

@section('title')
  Transaction
@endsection

@section('content')
  <div class="portlet-title">
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6">
        <h1 class="page-title font-green sbold">
          <i class="fa fa-television font-green"></i> Transactions
          <small class="font-green sbold">List</small>
        </h1>
      </div>
      @can('add_transactions')
        <div class="col-xs-6 col-sm-6 col-md-6">
          <div class="caption pull-right">
            <a href="{{ route('transactions.create') }}" class="btn btn-sm bold green">
              <i class="fa fa-plus"></i> Add new Transaction
            </a>
          </div>
        </div>
      @endcan

      @include('backend.transaction._filter')

    </div>
  </div>
  <div class="portlet-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered" id="pi-academy-transaction">
      <thead>
        <tr>
          <th>#</th>
          <th>Transaction Id</th>
          <th>
            <a href="{{ route('transactions.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'transactionPeriod-high-low'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-up"></i>
            </a>

              Period

            <a href="{{ route('transactions.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'transactionPeriod-low-high'])) }}" style="margin-left: 5px;"> 
              <i class="fa fa-arrow-down"></i>
            </a>

          </th>
          <th>Type</th>
          <th>
            <a href="{{ route('transactions.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'paymentAmount-high-low'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-up"></i>
            </a>

              Amount

            <a href="{{ route('transactions.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'paymentAmount-low-high'])) }}" style="margin-left: 5px;"> 
              <i class="fa fa-arrow-down"></i>
            </a>
          </th>
          <th>Payment By</th>
          <th>Paid By</th>
          @if(auth()->user()->can('edit_transactions') || auth()->user()->can('delete_transactions'))
            <th class="text-center">Actions</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @forelse($transactions as $transaction)
          <tr>
            <td>{{ reversePagination($transactions, $loop) }}</td>                      
            <td>{{ $transaction->transaction_id }}</td>
            <td>
              {{ $transaction->nepali_transaction_date }}<br>
              {{ $transaction->transaction_time }}
            </td>
            <td>{{ \App\Transaction::TransactionType[$transaction->transaction_type] }}</td>
            <td>{{ nepaliCurrencyFormat($transaction->payment_amount) }}</td>
            <td>{{\ App\Transaction::PaymentType[$transaction->payment_type]}}</td>
            <td>
              @if(isset($transaction->expendBy->name) && \App\Transaction::TransactionType[$transaction->transaction_type] == 'Expenditure')
                {{ $transaction->expendBy->name}}
              @elseif(isset($transaction->paid_by) && \App\Transaction::TransactionType[$transaction->transaction_type] == 'Income')
                {{ $transaction->paid_by}}
              @endif
            </td>
            @if(auth()->user()->can('view_transactions') || auth()->user()->can('edit_transactions') || auth()->user()->can('delete_transactions'))
              <td class="text-center">
                @can('view_transactions')
                  <a href="{{ route('transactions.show', $transaction->id) }}"
                     class="btn btn-sm green-seagreen btn-outline filter-submit margin-bottom">
                    <i class="fa fa-eye"></i>
                  </a>
                @endcan
                @can('edit_transactions')
                  <a href="{{ route('transactions.edit', $transaction->id) }}"
                     class="btn btn-sm blue btn-outline filter-submit margin-bottom">
                    <i class="fa fa-edit"></i>
                  </a>
                @endcan
                @can('delete_transactions')
                  @if($transaction->deleted_at == null)
                    {!! Form::open(['route' => ['transactions.destroy', $transaction->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
                      <button
                          class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-delete"
                          title="Delete"
                      >
                        <i class="fa fa-trash-o"></i>
                      </button>
                    {!! Form::close() !!}
                  @else
                    {!! Form::open(['route' => ['transactions.restore', $transaction->id], 'method' => 'POST', 'class' => 'form-edit-button']) !!}
                      <button
                          class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-restore"
                          title="Restore"
                      >
                        <i class="fa fa-recycle"></i>
                      </button>
                    {!! Form::close() !!}

                    {!! Form::open(['route' => ['transactions.forceDestroy', $transaction->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
                      <button
                          class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-force-delete"
                          title="Force Delete"
                      >
                        <i class="fa fa-trash"></i>
                      </button>
                    {!! Form::close() !!}
                  @endif
                @endcan
              </td>
            @endif
          </tr>
        @empty
          <tr class="text-center">
            <td colspan="6">No data available in table</td>
          </tr>
        @endforelse
      </tbody>
      </table>
    </div>
  </div>
  <div class="portlet-footer text-center">
    {{ $transactions->appends(request()->input())->links() }}    
  </div>
@endsection

@section('backend-script')
  <script type="text/javascript">
    $(document).ready(function() {
      @can('view_export_datas')
        $("#pi-academy-transaction").tableExport({
          bootstrap: false,
          ignoreCols: 7,
        });
      @endcan
    });
  </script>
@endsection


