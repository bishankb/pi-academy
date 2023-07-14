@extends('layouts.backend')

@section('title')
  Scholarship Test
@endsection

@section('content')
  <div class="portlet-title">
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6">
        <h1 class="page-title font-green sbold">
          <i class="fa fa-television font-green"></i> Scholarship Test
          <small class="font-green sbold">List</small>
        </h1>
      </div>
      @can('add_scholarship_tests')
        <div class="col-xs-6 col-sm-6 col-md-6">
          <div class="caption pull-right">
            <a href="{{ route('scholarship-test.create') }}" class="btn btn-sm bold green">
              <i class="fa fa-plus"></i> Add new Student
            </a>
          </div>
        </div>
      @endcan

      @include('backend.scholarship-test._filter')

    </div>
  </div>
  <div class="portlet-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>
            <a href="{{ route('scholarship-test.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'firstName-high-low'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-up"></i>
            </a>

              Student Name

            <a href="{{ route('scholarship-test.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'firstName-low-high'])) }}" style="margin-left: 5px;"> 
              <i class="fa fa-arrow-down"></i>
            </a>
          </th>
          @can('view_confidentials')
            <th>Phone No</th>
          @endcan
          <th>
            <a href="{{ route('scholarship-test.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'registrationNumber-high-low'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-up"></i>
            </a>

              Reg No.

            <a href="{{ route('scholarship-test.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'registrationNumber-low-high'])) }}" style="margin-left: 5px;"> 
              <i class="fa fa-arrow-down"></i>
            </a>
          </th>
          <th>Interested In</th>
          <th>Shift</th>
          @if(auth()->user()->can('edit_scholarship_tests') || auth()->user()->can('delete_scholarship_tests'))
            <th class="text-center">Actions</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @forelse($scholarship_tests as $scholarship_test)
          <tr>
            <td>{{ reversePagination($scholarship_tests, $loop) }}</td>                      
            <td>
              {{ $scholarship_test->first_name }} @isset($scholarship_test->middle_name) {{ $scholarship_test->middle_name }} @endisset {{ $scholarship_test->last_name }}
            </td>
            @can('view_confidentials')
              <td>
                @if(isset($scholarship_test->cell_number))
                  {{ $scholarship_test->cell_number }}
                @elseif(isset($scholarship_test->landline_number))
                  {{ $scholarship_test->landline_number }}
                @elseif(isset($scholarship_test->guardian_cell_number))
                  {{ $scholarship_test->guardian_cell_number }}
                @else
                  {{ $scholarship_test->guardian_landline_number }}
                @endif
              </td>
            @endcan
            <td>{{ $scholarship_test->registration_number }}</td>
            <td>{{ $interested_courses[$scholarship_test->interested_course]}}</td>
            <td>
              @if($scholarship_test->shift == 0)
                Morning
              @elseif($scholarship_test->shift == 1)
                Day
              @else
                Evening
              @endif
            </td>
            @if(auth()->user()->can('view_scholarship_tests') || auth()->user()->can('edit_scholarship_tests') || auth()->user()->can('delete_scholarship_tests'))
              <td class="text-center">
                @can('view_scholarship_tests')
                  <a href="{{ route('scholarship-test.show', $scholarship_test->id) }}"
                     class="btn btn-sm green-seagreen btn-outline filter-submit margin-bottom">
                    <i class="fa fa-eye"></i>
                  </a>
                @endcan
                @can('edit_scholarship_tests')
                  <a href="{{ route('scholarship-test.edit', $scholarship_test->id) }}"
                     class="btn btn-sm blue btn-outline filter-submit margin-bottom">
                    <i class="fa fa-edit"></i>
                  </a>
                @endcan
                @can('delete_scholarship_tests')
                  @if($scholarship_test->deleted_at == null)
                    {!! Form::open(['route' => ['scholarship-test.destroy', $scholarship_test->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
                      <button class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-delete" title="Delete"
                      >
                        <i class="fa fa-trash-o"></i>
                      </button>
                    {!! Form::close() !!}
                  @else
                    {!! Form::open(['route' => ['scholarship-test.restore', $scholarship_test->id], 'method' => 'POST', 'class' => 'form-edit-button']) !!}
                      <button
                          class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-restore"
                          title="Restore"
                      >
                        <i class="fa fa-recycle"></i>
                      </button>
                    {!! Form::close() !!}

                    {!! Form::open(['route' => ['scholarship-test.forceDestroy', $scholarship_test->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
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
    {{ $scholarship_tests->appends(request()->input())->links() }}    
  </div>
@endsection


