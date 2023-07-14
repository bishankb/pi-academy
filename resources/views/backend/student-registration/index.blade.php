@extends('layouts.backend')

@section('title')
  Student Registration
@endsection

@section('content')
  <div class="portlet-title">
    <div class="alert alert-success" id="status-change-alert">
      Status Changed Sucessfully.
    </div>
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6">
        <h1 class="page-title font-green sbold">
          <i class="fa fa-television font-green"></i> Student Registration
          <small class="font-green sbold">List</small>
        </h1>
      </div>
      @can('add_student_registrations')
        <div class="col-xs-6 col-sm-6 col-md-6">
          <div class="caption pull-right">
            <a href="{{ route('student-registration.create') }}" class="btn btn-sm bold green">
              <i class="fa fa-plus"></i> Add new Student
            </a>
          </div>
        </div>
      @endcan

      @include('backend.student-registration._filter')

    </div>
  </div>
  <div class="portlet-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>
            <a href="{{ route('student-registration.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'firstName-high-low'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-up"></i>
            </a>

              Student Name

            <a href="{{ route('student-registration.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'firstName-low-high'])) }}" style="margin-left: 5px;"> 
              <i class="fa fa-arrow-down"></i>
            </a>
          </th>
          <th>
            <a href="{{ route('student-registration.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'registrationNumber-high-low'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-up"></i>
            </a>

              Reg No.

            <a href="{{ route('student-registration.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'registrationNumber-low-high'])) }}" style="margin-left: 5px;"> 
              <i class="fa fa-arrow-down"></i>
            </a>
          </th>
          @can('view_student_payment_histories')
            <th>Due</th>
            <th>Payment</th>
          @endcan
          @can('edit_online_examination_credentials')
            <th>Examination</th>
          @endcan
          <th class="text-center">Active</th>
          @if(auth()->user()->can('edit_student_registrations') || auth()->user()->can('delete_student_registrations'))
            <th class="text-center">Actions</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @forelse($student_registrations as $student_registration)
          <tr>
            <td>{{ reversePagination($student_registrations, $loop) }}</td>                      
            <td>
              {{ $student_registration->first_name }} @isset($student_registration->middle_name) {{ $student_registration->middle_name }} @endisset {{ $student_registration->last_name }}
            </td>
            <td>{{ $student_registration->registration_number ? $student_registration->registration_number : '--' }}</td>
            @can('view_student_payment_histories')
              @php
                $total_paid = $student_registration->paymentHistories->sum('payment_amount');
                $due = $student_registration->fee_after_scholarship - $total_paid;
              @endphp
              <td>
                {{ nepaliCurrencyFormat($due) }}
              </td>
              <td>
                <a href="{{ route('student-payment-history.index', $student_registration->id) }}">
                  Manage
                </a>
              </td>
            @endcan
            @can('edit_online_examination_credentials')
              <td>
                <a href="{{ route('student-registration.editExaminationCredential', ['student_id' => $student_registration->id, 'id' => $student_registration->examinationCredential->id ]) }}">
                  Manage
                </a>
              </td>
            @endcan
            @if(auth()->user()->can('edit_online_examination_credentials'))
              <td class="text-center">
                <label class="toggle-switch">
                  <input type="checkbox" class="changeStatus{{$student_registration->id}}" data-route-name="{{ route('examination-credential.changeStatus', ['student_id' => $student_registration->id, 'id' => $student_registration->examinationCredential->id ]) }}" @if($student_registration->examinationCredential->active == 1) checked @endif>
                  <span class="toggle-slider round"></span>
                </label>
              </td>
            @else
              <td class="text-center">
                @if($student_registration->examinationCredential->active == 1)
                  <span style="font-size: 12px;" class="label label-success">Active</span>
                @else
                  <span style="font-size: 12px;" class="label label-danger">Inactive</span>
                @endif
              </td>
            @endif
            @if(auth()->user()->can('view_student_registrations') || auth()->user()->can('edit_student_registrations') || auth()->user()->can('delete_student_registrations'))
              <td class="text-center">
                @can('view_student_registrations')
                  <a href="{{ route('student-registration.show', $student_registration->id) }}"
                     class="btn btn-sm green-seagreen btn-outline filter-submit margin-bottom">
                    <i class="fa fa-eye"></i>
                  </a>
                @endcan
                @can('edit_student_registrations')
                  <a href="{{ route('student-registration.edit', $student_registration->id) }}"
                     class="btn btn-sm blue btn-outline filter-submit margin-bottom">
                    <i class="fa fa-edit"></i>
                  </a>
                @endcan
                @can('delete_student_registrations')
                  @if($student_registration->deleted_at == null)
                    {!! Form::open(['route' => ['student-registration.destroy', $student_registration->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
                      <button
                          class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-delete"
                          title="Delete"
                      >
                        <i class="fa fa-trash-o"></i>
                      </button>
                    {!! Form::close() !!}
                  @else
                    {!! Form::open(['route' => ['student-registration.restore', $student_registration->id], 'method' => 'POST', 'class' => 'form-edit-button']) !!}
                      <button
                          class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-restore"
                          title="Restore"
                      >
                        <i class="fa fa-recycle"></i>
                      </button>
                    {!! Form::close() !!}

                    {!! Form::open(['route' => ['student-registration.forceDestroy', $student_registration->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
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
            <td colspan="7">No data available in table</td>
          </tr>
        @endforelse
      </tbody>
      </table>
    </div>
  </div>
  <div class="portlet-footer text-center">
    {{ $student_registrations->appends(request()->input())->links() }}
  </div>
@endsection

@section('backend-script')
  <script type="text/javascript">
    $(document).ready(function(){
      @foreach($student_registrations as $student_registration)
        $('.changeStatus'+'{{$student_registration->id}}').click(function () {
          var val = $(this).prop('checked') == false ? 0 : 1;
          var route_name = $(this).attr("data-route-name");
          $.ajax({
            type     : "POST",
            headers  : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url      : route_name,
            data     : {status: val},
            success: function(response){
              if (response.success) {
                $("#status-change-alert").show();
                $('#status-change-alert').delay(3000).fadeOut(1000);
              }
            },
            error: function(response){
              alert("There was some internal error while updating the status.");
              window.location.reload(); 
            },
          });
        });
      @endforeach
    });
  </script>
@endsection
