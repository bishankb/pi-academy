@extends('layouts.backend')

@section('title')
  Class Times
@endsection

@section('content')
  <div class="portlet-title">
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6">
        <h1 class="page-title font-green sbold">
          <i class="fa fa-television font-green"></i> {{ $routine_group->name }}
          <small class="font-green sbold">Class Times</small>
        </h1>
      </div>
      @can('add_routine_class_times')
        <div class="col-xs-6 col-sm-6 col-md-6">
          <div class="caption pull-right">
            <a href="{{ route('routine-class-time.create', $routine_group->id) }}" class="btn btn-sm bold green">
              <i class="fa fa-plus"></i> Add Class
            </a>
          </div>
        </div>
      @endcan

      @include('backend.routine-group.routine-class-time._filter')

    </div>
  </div>
  <div class="portlet-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Order</th>
            @if(auth()->user()->can('edit_routine_class_times') || auth()->user()->can('delete_routine_class_times'))
              <th class="text-center">Actions</th>
            @endif
          </tr>
        </thead>
        <tbody>
          @forelse($routine_class_times as $routine_class_time)
            <tr>
              <td>{{ pagination($routine_class_times, $loop) }}</td>                      
              <td>{{ \Carbon\Carbon::parse($routine_class_time->class_start_time)->format('h:i:s a')}}</td>
              <td>{{ \Carbon\Carbon::parse($routine_class_time->class_end_time)->format('h:i:s a')}}</td>
              <td>{{ $routine_class_time->order }}</td>
              @if(auth()->user()->can('view_routine_class_times') || auth()->user()->can('edit_routine_class_times') || auth()->user()->can('delete_routine_class_times'))
                <td class="text-center">
                  @can('view_routine_class_times')
                    <a href="{{ route('routine-class-time.show', ['group_id' => $routine_group->id, 'id' => $routine_class_time->id ]) }}"
                       class="btn btn-sm green-seagreen btn-outline filter-submit margin-bottom">
                      <i class="fa fa-eye"></i>
                    </a>
                  @endcan
                  @can('edit_routine_class_times')
                    <a href="{{ route('routine-class-time.edit', ['group_id' => $routine_group->id, 'id' => $routine_class_time->id ]) }}"
                       class="btn btn-sm blue btn-outline filter-submit margin-bottom">
                      <i class="fa fa-edit"></i>
                    </a>
                  @endcan
                  @can('delete_routine_class_times')
                    @if($routine_class_time->deleted_at == null)
                      {!! Form::open(['route' => ['routine-class-time.destroy', $routine_group->id, $routine_class_time->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
                        <button
                            class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-delete"
                            title="Delete"
                        >
                          <i class="fa fa-trash-o"></i>
                        </button>
                      {!! Form::close() !!}
                    @else
                      {!! Form::open(['route' => ['routine-class-time.restore', $routine_group->id, $routine_class_time->id], 'method' => 'POST', 'class' => 'form-edit-button']) !!}
                        <button
                            class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-restore"
                            title="Restore"
                        >
                          <i class="fa fa-recycle"></i>
                        </button>
                      {!! Form::close() !!}

                      {!! Form::open(['route' => ['routine-class-time.forceDestroy', $routine_group->id, $routine_class_time->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
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
  <div class="portlet-footer">
    <a href="{{ route('routine-groups.index') }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
      Back
    </a>
    {{ $routine_class_times->appends(request()->input())->links() }}
  </div>
@endsection
