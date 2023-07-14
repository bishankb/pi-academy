@extends('layouts.backend')

@section('title')
  Teacher List
@endsection

@section('content')
  <div class="portlet-title">
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6">
        <h1 class="page-title font-green sbold">
          <i class="fa fa-television font-green"></i> Teacher
          <small class="font-green sbold">List</small>
        </h1>
      </div>

      @include('backend.routine-teacher._filter')

    </div>
  </div>
  <div class="portlet-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>
            <a href="{{ route('routine.teacher-list', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'name-high-low'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-up"></i>
            </a>

              Name

            <a href="{{ route('routine.teacher-list', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'name-low-high'])) }}" style="margin-left: 5px;"> 
              <i class="fa fa-arrow-down"></i>
            </a>
          </th>
          <th>Routine</th>
        </tr>
      </thead>
      <tbody>
        @forelse($teachers as $teacher)
          <tr>
            <td>{{ pagination($teachers, $loop) }}</td>                      
            <td>
              {{ $teacher->name }}
            </td>
            <td>
              <a href="{{ route('teacher-routine.index', $teacher->id) }}">View Routine</a>
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
  <div class="portlet-footer text-center">
    {{ $teachers->appends(request()->input())->links() }}    
  </div>
@endsection