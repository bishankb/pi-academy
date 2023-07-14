@extends('layouts.backend')

@section('title')
  {{$staff->name}} Attendence
@endsection

@section('content')
  <div class="portlet-title">
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6">
        <h1 class="page-title font-green sbold">
          <i class="fa fa-television font-green"></i> {{$staff->name}} 
          <small class="font-green sbold">Attendence</small>
        </h1>
      </div>
      @can('add_attendences')
        <div class="col-xs-6 col-sm-6 col-md-6">
          <div class="caption pull-right">
            <a href="{{ route('attendence.create', $staff->id) }}" class="btn btn-sm bold green">
              <i class="fa fa-plus"></i> Add new attendence
            </a>
          </div>
        </div>
      @endcan

      @include('backend.attendence.attendence-record._filter')

    </div>
  </div>
  <div class="portlet-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>
            <a href="{{ route('attendence.index', array_merge(Request::all(), ['staff_id' => $staff->id, 'sort_by' => 'criteria', 'criteria' => 'attendenceDate-high-low'])) }}" style="margin-right: 5px;">
                <i class="fa fa-arrow-up"></i>
              </a>

              Date

            <a href="{{ route('attendence.index', array_merge(Request::all(), ['staff_id' => $staff->id, 'sort_by' => 'criteria', 'criteria' => 'attendenceDate-low-high'])) }}" style="margin-left: 5px;"> 
                <i class="fa fa-arrow-down"></i>
              </a>
          </th>
          <th class="text-center">Attendence</th>
          <th>Arrival Time</th>
          <th>Departure Time</th>
          <th class="text-center">Gap Hour</th>
          <th class="text-center">Worked Hour</th>
          @if(auth()->user()->can('edit_attendences') || auth()->user()->can('delete_attendences'))
            <th class="text-center">Actions</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @forelse($attendences as $attendence)
          <tr>
            <td>{{ reversePagination($attendences, $loop) }}</td>                      
            <td>{{ $attendence->nepali_attendence_date }}</td>
            <td class="text-center">
              @if($attendence->has_taken_leave == 1)
                <span class="label label-danger">On Leave</span>
              @elseif($attendence->is_holiday == 1)
                <span class="label label-warning">Holiday</span>
              @else
                <span class="label label-success">Present</span>
              @endif
            </td>
            <td>
              @if(isset($attendence->arrival_time))
                {{ \Carbon\Carbon::parse($attendence->arrival_time)->format('h:i:s a')}}
              @else
                --
              @endif
            </td>
            <td>
              @if(isset($attendence->departure_time))
                {{ \Carbon\Carbon::parse($attendence->departure_time)->format('h:i:s a')}}
              @else
                --
              @endif
            </td>
            <td class="text-center">
              @if(isset($attendence->gap_departure_time) && isset($attendence->gap_arrival_time))
                {{ \Carbon\Carbon::parse($attendence->gap_arrival_time)->diffInHours(\Carbon\Carbon::parse($attendence->gap_departure_time)) }} hr
              @else
                --
              @endif
            </td>
            <td class="text-center">
              @if($attendence->worked_hour != 0)
                {{ $attendence->worked_hour }} hr
              @else
                --
              @endif
            </td>
            @if(auth()->user()->can('view_attendences') || auth()->user()->can('edit_attendences') || auth()->user()->can('delete_attendences'))
              <td class="text-center">
                @can('view_attendences')
                  <a href="{{ route('attendence.show', ['$staff_id' => $staff->id, $attendence->id]) }}"
                     class="btn btn-sm green-seagreen btn-outline filter-submit margin-bottom">
                    <i class="fa fa-eye"></i>
                  </a>
                @endcan
                @can('edit_attendences')
                  <a href="{{ route('attendence.edit', ['$staff_id' => $staff->id, $attendence->id]) }}"
                     class="btn btn-sm blue btn-outline filter-submit margin-bottom">
                    <i class="fa fa-edit"></i>
                  </a>
                @endcan
                @can('delete_attendences')
                  @if($attendence->deleted_at == null)
                    {!! Form::open(['route' => ['attendence.destroy', $staff->id, $attendence->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
                      <button
                          class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-delete"
                          title="Delete"
                      >
                        <i class="fa fa-trash-o"></i>
                      </button>
                    {!! Form::close() !!}
                  @else
                    {!! Form::open(['route' => ['attendence.restore', $staff->id, $attendence->id], 'method' => 'POST', 'class' => 'form-edit-button']) !!}
                      <button
                          class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-restore"
                          title="Restore"
                      >
                        <i class="fa fa-recycle"></i>
                      </button>
                    {!! Form::close() !!}

                    {!! Form::open(['route' => ['attendence.forceDestroy', $staff->id, $attendence->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
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
    <a href="{{ route('attendence.staff-list') }}" type="button" class="btn btn-info btn-back" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
      Back
    </a>
    {{ $attendences->appends(request()->input())->links() }}    
  </div>
@endsection


