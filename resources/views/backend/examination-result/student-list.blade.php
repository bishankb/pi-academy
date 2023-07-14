@extends('layouts.backend')

@section('title')
  Student List
@endsection

@section('content')
  <div class="portlet-title">
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6">
        <h1 class="page-title font-green sbold">
          <i class="fa fa-television font-green"></i> Student
          <small class="font-green sbold">List</small>
        </h1>
      </div>

      @include('backend.examination-result._filter')

    </div>
  </div>
  <div class="portlet-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>
            <a href="{{ route('examination-results.student-list', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'name-high-low'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-up"></i>
            </a>

              Name

            <a href="{{ route('examination-results.student-list', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'name-low-high'])) }}" style="margin-left: 5px;"> 
              <i class="fa fa-arrow-down"></i>
            </a>
          </th>
          <th class="text-center">Exam Atemmpted</th>
          <th class="text-center">View Detail</th>
          @can('view_examination_results')
            <th style="text-align: center;">Action</th>
          @endcan
        </tr>
      </thead>
      <tbody>
        @forelse($students as $student)
          <tr>
            <td>{{ reversePagination($students, $loop) }}</td>                      
            <td>
              {{ $student->first_name }} @isset($student->middle_name) {{ $student->middle_name }} @endisset {{ $student->last_name }}
            </td>
            <td class="text-center">
              {{ count($student->examinationRecords) }}
            </td>
            <td class="text-center">
              <a href="{{ route('examination-results.index', $student->id) }}">View Detail</a>
            </td>
            @can('view_examination_results')
              <td class="text-center">
                <a href="{{ route('examination-results.student-show', $student->id) }}"
                   class="btn btn-sm green-seagreen btn-outline filter-submit margin-bottom">
                  <i class="fa fa-eye"></i>
                </a>
              </td>
            @endcan
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
    {{ $students->appends(request()->input())->links() }}    
  </div>
@endsection