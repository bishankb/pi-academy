@extends('layouts.backend')

@section('title')
  Teacher Routine List
@endsection

@section('content')
  <div class="portlet-title">
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6">
        <h1 class="page-title font-green sbold">
          <i class="fa fa-television font-green"></i> {{ $teacher->name }}
          <small class="font-green sbold">Routine List</small>
        </h1>
      </div>

      @include('backend.routine-teacher.routine-class._filter')

    </div>
  </div>
  <div class="portlet-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>Date</th>
            <th>Group</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Subject</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($routine_classes as $routine_class)
            <tr>
              <td>{{ reversePagination($routine_classes, $loop) }}</td>                      
              <td>{{ $routine_class->routine->nepali_routine_date }}</td>
              <td>{{ $routine_class->routineClassTime->routineGroup->name }}</td>
              <td>{{ \Carbon\Carbon::parse($routine_class->routineClassTime->class_start_time)->format('h:i:s a')}}</td>
              <td>{{ \Carbon\Carbon::parse($routine_class->routineClassTime->class_end_time)->format('h:i:s a')}}</td>
              <td>{{ $subjects[$routine_class->subject] }}</td>
              <td class="text-center">
                <a href="{{ route('teacher-routine.show', ['teacher_id' => $teacher->id, 'id' => $routine_class->id]) }}"
                   class="btn btn-sm green-seagreen btn-outline filter-submit margin-bottom">
                  <i class="fa fa-eye"></i>
                </a>
              </td>
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
  <div class="portlet-footer">
    <a href="{{ route('routine.teacher-list') }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
      Back
    </a>
    {{ $routine_classes->appends(request()->input())->links() }}
  </div>
@endsection
