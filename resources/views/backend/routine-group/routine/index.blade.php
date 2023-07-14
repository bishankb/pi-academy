@extends('layouts.backend')

@section('title')
  Routine Record
@endsection

@section('content')
  <div class="portlet-title">
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6">
        <h1 class="page-title font-green sbold">
          <i class="fa fa-television font-green"></i> {{ $routine_group->name }} Routine Record
          <small class="font-green sbold">List</small>
        </h1>
      </div>
      @can('add_routines')
        <div class="col-xs-6 col-sm-6 col-md-6">
          <div class="caption pull-right">
            <a href="{{ route('routines.create', $routine_group->id) }}" class="btn btn-sm bold green">
              <i class="fa fa-plus"></i> Add new record
            </a>
          </div>
        </div>
      @endcan

      @include('backend.routine-group.routine._filter')

    </div>
  </div>
  <div class="portlet-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered" id="pi-academy-transaction">
      <thead>
        <tr>
          <th>#</th>
          <th>
            <a href="{{ route('routines.index', array_merge(Request::all(), ['group_id' => $routine_group->id, 'sort_by' => 'criteria', 'criteria' => 'routineDate-high-low'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-up"></i>
            </a>

              Date

            <a href="{{ route('routines.index', array_merge(Request::all(), ['group_id' => $routine_group->id, 'sort_by' => 'criteria', 'criteria' => 'routineDate-low-high'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-down"></i>
            </a>
          </th>
          <th>Teachers</th>
          @if(auth()->user()->can('edit_routines') || auth()->user()->can('delete_routines'))
            <th class="text-center">Actions</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @forelse($routines as $routine)
          <tr>
            <td>{{ reversePagination($routines, $loop) }}</td>                    
            <td>{{ $routine->nepali_routine_date }}</td>
            <td>{{ implode(',', $routine->routineClass->pluck('teacher.name')->toArray()) }}</td>
            @if(auth()->user()->can('view_routines') || auth()->user()->can('edit_routines') || auth()->user()->can('delete_routines'))
              <td class="text-center">
                @can('view_routines')
                  <a href="{{ route('routines.show', ['group_id' => $routine_group->id, 'id' => $routine->id]) }}"
                     class="btn btn-sm green-seagreen btn-outline filter-submit margin-bottom">
                    <i class="fa fa-eye"></i>
                  </a>
                @endcan
                @can('edit_routines')
                  <a href="{{ route('routines.edit', ['group_id' => $routine_group->id, 'id' => $routine->id]) }}"
                     class="btn btn-sm blue btn-outline filter-submit margin-bottom">
                    <i class="fa fa-edit"></i>
                  </a>
                @endcan
                @can('delete_routines')
                  @if($routine->deleted_at == null)
                    {!! Form::open(['route' => ['routines.destroy', $routine_group->id, $routine->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
                      <button
                          class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-delete"
                          title="Delete"
                      >
                        <i class="fa fa-trash-o"></i>
                      </button>
                    {!! Form::close() !!}
                  @else
                    {!! Form::open(['route' => ['routines.restore', $routine_group->id, $routine->id], 'method' => 'POST', 'class' => 'form-edit-button']) !!}
                      <button
                          class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-restore"
                          title="Restore"
                      >
                        <i class="fa fa-recycle"></i>
                      </button>
                    {!! Form::close() !!}

                    {!! Form::open(['route' => ['routines.forceDestroy', $routine_group->id, $routine->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
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
            <td colspan="8">No data available in table</td>
          </tr>
        @endforelse
      </tbody>
      </table>
    </div>
  </div>
  <div class="portlet-footer">
    <a href="{{ route('routine-groups.index') }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
      Back
    </a>
    {{ $routines->appends(request()->input())->links() }}
  </div>
@endsection