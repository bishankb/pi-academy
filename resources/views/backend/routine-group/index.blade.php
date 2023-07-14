@extends('layouts.backend')

@section('title')
  Routine Groups
@endsection

@section('content')
  <div class="portlet-title">
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6">
        <h1 class="page-title font-green sbold">
          <i class="fa fa-television font-green"></i> Routine Groups
          <small class="font-green sbold">List</small>
        </h1>
      </div>
      @can('add_routine_groups')
        <div class="col-xs-6 col-sm-6 col-md-6">
          <div class="caption pull-right">
            <a href="{{ route('routine-groups.create') }}" class="btn btn-sm bold green">
              <i class="fa fa-plus"></i> Add new group
            </a>
          </div>
        </div>
      @endcan

      @include('backend.routine-group._filter')

    </div>
  </div>
  <div class="portlet-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered" id="pi-academy-transaction">
      <thead>
        <tr>
          <th>#</th>
          <th>
            <a href="{{ route('routine-groups.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'name-high-low'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-up"></i>
            </a>

              Group

            <a href="{{ route('routine-groups.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'name-low-high'])) }}" style="margin-left: 5px;"> 
              <i class="fa fa-arrow-down"></i>
            </a>

          </th>
          <th>Shift</th>
          <th>
            <a href="{{ route('routine-groups.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'order-high-low'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-up"></i>
            </a>
              Order
            <a href="{{ route('routine-groups.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'order-low-high'])) }}" style="margin-left: 5px;"> 
              <i class="fa fa-arrow-down"></i>
            </a>
          </th>
          @can('view_routine_class_times')
            <th>Class Time</th>
          @endcan
          @can('view_routines')
            <th>Routine</th>
          @endcan
          @if(auth()->user()->can('edit_routine_groups') || auth()->user()->can('delete_routine_groups'))
            <th class="text-center">Actions</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @forelse($routine_groups as $routine_group)
          <tr>
            <td>{{ pagination($routine_groups, $loop) }}</td>                      
            <td>{{ $routine_group->name }}</td>
            <td>{{ $shifts[$routine_group->shift] }}</td>
            <td>{{ $routine_group->order }}</td>
            @can('view_routine_class_times')            
              <td>
                <a href="{{ route('routine-class-time.index', $routine_group->id) }}">
                  Manage
                </a>
              </td>
            @endcan
            @can('view_routines')
              @if(count($routine_group->routineClassTimes) > 0)
                <td>
                  <a href="{{ route('routines.index', $routine_group->id) }}">
                    Manage
                  </a>
                </td>
              @else
                <td>--</td>
              @endif
            @endcan
            @if(auth()->user()->can('view_routine_groups') || auth()->user()->can('edit_routine_groups') || auth()->user()->can('delete_routine_groups'))
              <td class="text-center">
                @can('view_routine_groups')
                  <a href="{{ route('routine-groups.show', $routine_group->id) }}"
                     class="btn btn-sm green-seagreen btn-outline filter-submit margin-bottom">
                    <i class="fa fa-eye"></i>
                  </a>
                @endcan
                @can('edit_routine_groups')
                  <a href="{{ route('routine-groups.edit', $routine_group->id) }}"
                     class="btn btn-sm blue btn-outline filter-submit margin-bottom">
                    <i class="fa fa-edit"></i>
                  </a>
                @endcan
                @can('delete_routine_groups')
                  @if($routine_group->deleted_at == null)
                    {!! Form::open(['route' => ['routine-groups.destroy', $routine_group->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
                      <button
                          class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-delete"
                          title="Delete"
                      >
                        <i class="fa fa-trash-o"></i>
                      </button>
                    {!! Form::close() !!}
                  @else
                    {!! Form::open(['route' => ['routine-groups.restore', $routine_group->id], 'method' => 'POST', 'class' => 'form-edit-button']) !!}
                      <button
                          class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-restore"
                          title="Restore"
                      >
                        <i class="fa fa-recycle"></i>
                      </button>
                    {!! Form::close() !!}

                    {!! Form::open(['route' => ['routine-groups.forceDestroy', $routine_group->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
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
    {{ $routine_groups->appends(request()->input())->links() }}    
  </div>
@endsection