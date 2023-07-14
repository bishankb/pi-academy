@extends('layouts.backend')

@section('title')
  Meetings
@endsection

@section('content')
  <div class="portlet-title">
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6">
        <h1 class="page-title font-green sbold">
          <i class="fa fa-television font-green"></i> Meetings
          <small class="font-green sbold">List</small>
        </h1>
      </div>
      @can('add_meetings')
        <div class="col-xs-6 col-sm-6 col-md-6">
          <div class="caption pull-right">
            <a href="{{ route('meeting.create') }}" class="btn btn-sm bold green">
              <i class="fa fa-plus"></i> Add new record
            </a>
          </div>
        </div>
      @endcan

      @include('backend.meeting._filter')

    </div>
  </div>
  <div class="portlet-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered" id="pi-academy-transaction">
      <thead>
        <tr>
          <th>#</th>
          <th>Topic</th>
          <th>
            <a href="{{ route('meeting.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'meetingDate-high-low'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-up"></i>
            </a>

              Date

            <a href="{{ route('meeting.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'meetingDate-low-high'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-down"></i>
            </a>
          </th>
          <th>Start Time</th>
          <th>End Time</th>
          @if(auth()->user()->can('edit_meetings') || auth()->user()->can('delete_meetings'))
            <th class="text-center">Actions</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @forelse($meetings as $meeting)
          <tr>
            <td>{{ reversePagination($meetings, $loop) }}</td>                      
            <td>{{ $meeting->topic }}</td>
            <td>{{ $meeting->nepali_meeting_date }}</td>
            <td>{{ \Carbon\Carbon::parse($meeting->meeting_start_time)->format('h:i:s a')}}</td>
            <td>{{ \Carbon\Carbon::parse($meeting->meeting_end_time)->format('h:i:s a')}}</td>
            @if(auth()->user()->can('view_meetings') || auth()->user()->can('edit_meetings') || auth()->user()->can('delete_meetings'))
              <td class="text-center">
                @can('view_meetings')
                  <a href="{{ route('meeting.show', $meeting->id) }}"
                     class="btn btn-sm green-seagreen btn-outline filter-submit margin-bottom">
                    <i class="fa fa-eye"></i>
                  </a>
                @endcan
                @can('edit_meetings')
                  <a href="{{ route('meeting.edit', $meeting->id) }}"
                     class="btn btn-sm blue btn-outline filter-submit margin-bottom">
                    <i class="fa fa-edit"></i>
                  </a>
                @endcan
                @can('delete_meetings')
                  @if($meeting->deleted_at == null)
                    {!! Form::open(['route' => ['meeting.destroy', $meeting->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
                      <button
                          class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-delete"
                          title="Delete"
                      >
                        <i class="fa fa-trash-o"></i>
                      </button>
                    {!! Form::close() !!}
                  @else
                    {!! Form::open(['route' => ['meeting.restore', $meeting->id], 'method' => 'POST', 'class' => 'form-edit-button']) !!}
                      <button
                          class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-restore"
                          title="Restore"
                      >
                        <i class="fa fa-recycle"></i>
                      </button>
                    {!! Form::close() !!}

                    {!! Form::open(['route' => ['meeting.forceDestroy', $meeting->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
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
    {{ $meetings->appends(request()->input())->links() }}    
  </div>
@endsection