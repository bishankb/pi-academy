@extends('layouts.backend')

@section('title')
  Payment History
@endsection

@section('content')
  <div class="portlet-title">
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6">
        <h1 class="page-title font-green sbold">
          <i class="fa fa-television font-green"></i> {{ $student_registration->first_name }} @isset($student_registration->middle_name) {{ $student_registration->middle_name }} @endisset {{ $student_registration->last_name }}
          <small class="font-green sbold">Payment History</small>
        </h1>
      </div>
      @can('add_student_payment_histories')
        <div class="col-xs-6 col-sm-6 col-md-6">
          <div class="caption pull-right">
            <a href="{{ route('student-payment-history.create', $student_registration->id) }}" class="btn btn-sm bold green">
              <i class="fa fa-plus"></i> Add Payment
            </a>
          </div>
        </div>
      @endcan

      @include('backend.student-registration.payment-history._filter')

    </div>
  </div>
  <div class="portlet-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered" id="pi-academy-payment_history">
        <thead>
          <tr>
            <th>#</th>
            <th>
              <a href="{{ route('student-payment-history.index', array_merge(Request::all(), ['student_id' => $student_registration->id, 'sort_by' => 'criteria', 'criteria' => 'paymentDate-high-low'])) }}" style="margin-right: 5px;">
                <i class="fa fa-arrow-up"></i>
              </a>

                Paid Date

              <a href="{{ route('student-payment-history.index', array_merge(Request::all(), ['student_id' => $student_registration->id, 'sort_by' => 'criteria', 'criteria' => 'paymentDate-low-high'])) }}" style="margin-left: 5px;"> 
                <i class="fa fa-arrow-down"></i>
              </a>

            </th>
            <th>
              <a href="{{ route('student-payment-history.index', array_merge(Request::all(), ['student_id' => $student_registration->id, 'sort_by' => 'criteria', 'criteria' => 'receiptNumber-high-low'])) }}" style="margin-right: 5px;">
                <i class="fa fa-arrow-up"></i>
              </a>

                Receipt No.

              <a href="{{ route('student-payment-history.index', array_merge(Request::all(), ['student_id' => $student_registration->id, 'sort_by' => 'criteria', 'criteria' => 'receiptNumber-low-high'])) }}" style="margin-left: 5px;"> 
                <i class="fa fa-arrow-down"></i>
              </a>
            </th>
            <th>Received By</th>
            <th>
              <a href="{{ route('student-payment-history.index', array_merge(Request::all(), ['student_id' => $student_registration->id, 'sort_by' => 'criteria', 'criteria' => 'paymentAmount-high-low'])) }}" style="margin-right: 5px;">
                <i class="fa fa-arrow-up"></i>
              </a>

                Amount

              <a href="{{ route('student-payment-history.index', array_merge(Request::all(), ['student_id' => $student_registration->id, 'sort_by' => 'criteria', 'criteria' => 'paymentAmount-low-high'])) }}" style="margin-left: 5px;"> 
                <i class="fa fa-arrow-down"></i>
              </a>

            </th>
            @if(auth()->user()->can('edit_student_payment_histories') || auth()->user()->can('delete_student_payment_histories'))
              <th class="text-center">Actions</th>
            @endif
          </tr>
        </thead>
        <tbody>
          @forelse($payment_histories as $payment_history)
            <tr>
              <td>{{ reversePagination($payment_histories, $loop) }}</td>                      
              <td>
                {{ $payment_history->nepali_payment_date }}<br>
                {{ $payment_history->payment_time }}
              </td>
              <td>{{ $payment_history->receipt_number }}</td>
              <td>
                @if(isset($payment_history->received_by))
                  {{ $payment_history->receivedBy->name }}
                @else
                  --
                @endif
              </td>
              <td>{{ nepaliCurrencyFormat($payment_history->payment_amount) }}</td>
              @if(auth()->user()->can('view_student_payment_histories') || auth()->user()->can('edit_student_payment_histories') || auth()->user()->can('delete_student_payment_histories'))
                <td class="text-center">
                  @can('view_student_payment_histories')
                    <a href="{{ route('student-payment-history.show', ['student_id' => $student_registration->id, 'id' => $payment_history->id ]) }}"
                       class="btn btn-sm green-seagreen btn-outline filter-submit margin-bottom">
                      <i class="fa fa-eye"></i>
                    </a>
                  @endcan
                  @can('edit_student_payment_histories')
                    <a href="{{ route('student-payment-history.edit', ['student_id' => $student_registration->id, 'id' => $payment_history->id ]) }}"
                       class="btn btn-sm blue btn-outline filter-submit margin-bottom">
                      <i class="fa fa-edit"></i>
                    </a>
                  @endcan
                  @can('delete_student_payment_histories')
                    @if($payment_history->deleted_at == null)
                      {!! Form::open(['route' => ['student-payment-history.destroy', $student_registration->id, $payment_history->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
                        <button
                            class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-delete"
                            title="Delete"
                        >
                          <i class="fa fa-trash-o"></i>
                        </button>
                      {!! Form::close() !!}
                    @else
                      {!! Form::open(['route' => ['student-payment-history.restore', $student_registration->id, $payment_history->id], 'method' => 'POST', 'class' => 'form-edit-button']) !!}
                        <button
                            class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-restore"
                            title="Restore"
                        >
                          <i class="fa fa-recycle"></i>
                        </button>
                      {!! Form::close() !!}

                      {!! Form::open(['route' => ['student-payment-history.forceDestroy', $student_registration->id, $payment_history->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
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
        <tfoot>
          <tr>
            <th  colspan="4" style="text-align: right;">Total Paid till now:</th>
            <td>{{ nepaliCurrencyFormat($total_paid) }}</td>
          </tr>
          <tr>
            <th  colspan="4" style="text-align: right;">Total Fee to be Paid:</th>
            <td>{{ nepaliCurrencyFormat($student_registration->fee_after_scholarship) }}</td>
          </tr>
          <tr>
            <th  colspan="4" style="text-align: right;">Remaning Fee (Due):</th>
            <td>{{ nepaliCurrencyFormat($due) }}</td>
          </tr>
       </tfoot>
      </table>
    </div>
  </div>
  <div class="portlet-footer">
    <a href="{{ route('student-registration.index') }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
      Back
    </a>
    {{ $payment_histories->appends(request()->input())->links() }}
  </div>
@endsection

@section('backend-script')
  <script type="text/javascript">
    $(document).ready(function() {
      @can('view_export_datas')
        $("#pi-academy-payment_history").tableExport({
          bootstrap: false,
          ignoreCols: 4,
        });
      @endcan
    });
  </script>
@endsection


