@extends('layouts.backend')

@section('title')
  Visitor
@endsection

@section('content')
  <div class="portlet-title">
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6">
        <h1 class="page-title font-green sbold">
          <i class="fa fa-television font-green"></i> Visitor
          <small class="font-green sbold">List</small>
        </h1>
      </div>
      @can('add_visitors')
        <div class="col-xs-6 col-sm-6 col-md-6">
          <div class="caption pull-right">
            <a href="{{ route('visitors.create') }}" class="btn btn-sm bold green">
              <i class="fa fa-plus"></i> Add new Visitor
            </a>
          </div>
        </div>
      @endcan

      @include('backend.visitor._filter')

    </div>
  </div>
  <div class="portlet-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>
            <a href="{{ route('visitors.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'name-high-low'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-up"></i>
            </a>

              Name

            <a href="{{ route('visitors.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'name-low-high'])) }}" style="margin-left: 5px;"> 
              <i class="fa fa-arrow-down"></i>
            </a>
          </th>
          <th>Academic Status</th>
          <th>Counselled By</th>
          <th>
            <a href="{{ route('visitors.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'visitedPeriod-high-low'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-up"></i>
            </a>

              Visited At

            <a href="{{ route('visitors.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'visitedPeriod-low-high'])) }}" style="margin-left: 5px;"> 
              <i class="fa fa-arrow-down"></i>
            </a>
          </th>
          <th>Interested In</th>
          @if(auth()->user()->can('edit_visitors') || auth()->user()->can('delete_visitors'))
            <th class="text-center">Actions</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @forelse($visitors as $visitor)
          <tr>
            <td>{{ reversePagination($visitors, $loop) }}</td>                      
            <td>
              {{ $visitor->name }}
            </td>
            <td>
              @if(isset($visitor->academic_status))
                {{ \App\Visitor::AcademicStatus[$visitor->academic_status] }}
              @else
                --
              @endif
            </td>
            <td>
              @if(isset($visitor->counselled_by))
                {{ $visitor->counselledBy->name }}
              @else
                --
              @endif
            </td>
            @if(isset($visitor->nepali_visited_date))
              <td>
                {{ $visitor->nepali_visited_date }}<br>
                {{ $visitor->visited_time }}
              </td>
            @else
              <td class="text-center">
                --
              </td>
            @endif
            <td>
              @if(isset($visitor->interested_course))
                {{ $interested_courses[$visitor->interested_course] }}
              @else
                --
              @endif
            </td>
            @if(auth()->user()->can('view_visitors') || auth()->user()->can('edit_visitors') || auth()->user()->can('delete_visitors'))
              <td class="text-center">
                @can('view_visitors')
                  <a href="{{ route('visitors.show', $visitor->id) }}"
                     class="btn btn-sm green-seagreen btn-outline filter-submit margin-bottom">
                    <i class="fa fa-eye"></i>
                  </a>
                @endcan
                @can('edit_visitors')
                  <a href="{{ route('visitors.edit', $visitor->id) }}"
                     class="btn btn-sm blue btn-outline filter-submit margin-bottom">
                    <i class="fa fa-edit"></i>
                  </a>
                @endcan
                @can('delete_visitors')
                  @if($visitor->deleted_at == null)
                    {!! Form::open(['route' => ['visitors.destroy', $visitor->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
                      <button
                          class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-delete"
                          title="Delete"
                      >
                        <i class="fa fa-trash-o"></i>
                      </button>
                    {!! Form::close() !!}
                  @else
                    {!! Form::open(['route' => ['visitors.restore', $visitor->id], 'method' => 'POST', 'class' => 'form-edit-button']) !!}
                      <button
                          class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-restore"
                          title="Restore"
                      >
                        <i class="fa fa-recycle"></i>
                      </button>
                    {!! Form::close() !!}

                    {!! Form::open(['route' => ['visitors.forceDestroy', $visitor->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
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
    {{ $visitors->appends(request()->input())->links() }}    
  </div>
@endsection


