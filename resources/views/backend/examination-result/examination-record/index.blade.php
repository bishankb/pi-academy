@extends('layouts.backend')

@section('title')
  Student Results
@endsection

@section('content')
  <div class="portlet-title">
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6">
        <h1 class="page-title font-green sbold">
          <i class="fa fa-television font-green"></i> {{ $student->first_name }} @isset($student->middle_name) {{ $student->middle_name }} @endisset {{ $student->last_name }}
          <small class="font-green sbold">Results</small>
        </h1>
      </div>

      @include('backend.examination-result.examination-record._filter')

    </div>
  </div>
  <div class="portlet-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th style="text-align: center;">
            <a href="{{ route('examination-results.index', array_merge(Request::all(), ['student_id' => $student->id, 'sort_by' => 'criteria', 'criteria' => 'set-high-low'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-up"></i>
            </a>

              Set

            <a href="{{ route('examination-results.index', array_merge(Request::all(), ['student_id' => $student->id, 'sort_by' => 'criteria', 'criteria' => 'set-low-high'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-down"></i>
            </a>
          </th>
          <th style="text-align: center;">
            <a href="{{ route('examination-results.index', array_merge(Request::all(), ['student_id' => $student->id, 'sort_by' => 'criteria', 'criteria' => 'attempted-high-low'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-up"></i>
            </a>

              Attempted

            <a href="{{ route('examination-results.index', array_merge(Request::all(), ['student_id' => $student->id, 'sort_by' => 'criteria', 'criteria' => 'attempted-low-high'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-down"></i>
            </a>
          </th>
          <th style="text-align: center;">
            <a href="{{ route('examination-results.index', array_merge(Request::all(), ['student_id' => $student->id, 'sort_by' => 'criteria', 'criteria' => 'score-high-low'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-up"></i>
            </a>

              Score

            <a href="{{ route('examination-results.index', array_merge(Request::all(), ['student_id' => $student->id, 'sort_by' => 'criteria', 'criteria' => 'score-low-high'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-down"></i>
            </a>
          </th>
          @can('view_examination_results')
            <th style="text-align: center;">Action</th>
          @endcan
        </tr>
      </thead>
      <tbody>
        @forelse($examination_results as $examination_result)
          <tr>
            <td>{{ reversePagination($examination_results, $loop) }}</td>                      
            <td class="text-center">
              {{ $examination_result->set->name }}
            </td>
            <td class="text-center">{{ $examination_result->attempted }}</td>
            <td class="text-center">{{ $examination_result->score }}</td>
            @can('view_examination_results')
              <td class="text-center">
                <a href="{{ route('examination-results.show', ['student_id' => $student->id, 'id' => $examination_result->id ]) }}"
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
    <a href="{{ route('examination-results.student-list') }}" type="button" class="btn btn-info btn-back" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
      Back
    </a>
    {{ $examination_results->appends(request()->input())->links() }}    
  </div>
@endsection