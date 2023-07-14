@extends('layouts.backend')

@section('title')
  Question Sets
@endsection

@section('content')
  <div class="portlet-title">
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6">
        <h1 class="page-title font-green sbold">
          <i class="fa fa-television font-green"></i> Question Sets
          <small class="font-green sbold">List</small>
        </h1>
      </div>
      @can('add_question_sets')
        <div class="col-xs-6 col-sm-6 col-md-6">
          <div class="caption pull-right">
            <a href="{{ route('question-sets.create') }}" class="btn btn-sm bold green">
              <i class="fa fa-plus"></i> Add new Set
            </a>
          </div>
        </div>
      @endcan

      @include('backend.question-set._filter')

    </div>
  </div>
  <div class="portlet-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered" id="pi-academy-transaction">
      <thead>
        <tr>
          <th>#</th>
          <th>
            <a href="{{ route('question-sets.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'name-high-low'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-up"></i>
            </a>

              Set

            <a href="{{ route('question-sets.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'name-low-high'])) }}" style="margin-left: 5px;"> 
              <i class="fa fa-arrow-down"></i>
            </a>

          </th>

          <th>
            <a href="{{ route('question-sets.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'order-high-low'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-up"></i>
            </a>

              Order
              
            <a href="{{ route('question-sets.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'order-low-high'])) }}" style="margin-left: 5px;"> 
              <i class="fa fa-arrow-down"></i>
            </a>
          </th>

          <th>Created By</th>
          <th>Updated By</th>
          @if(auth()->user()->can('edit_question_sets') || auth()->user()->can('delete_question_sets'))
            <th class="text-center">Actions</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @forelse($question_sets as $question_set)
          <tr>
            <td>{{ pagination($question_sets, $loop) }}</td>                      
            <td>{{ $question_set->name }}</td>
            <td>{{ $question_set->order }}</td>
            <td>{{ $question_set->createdBy->name }}</td>
            <td>{{ $question_set->updatedBy->name }}</td>
            @if(auth()->user()->can('view_question_sets') || auth()->user()->can('edit_question_sets') || auth()->user()->can('delete_question_sets'))
              <td class="text-center">
                @can('view_question_sets')
                  <a href="{{ route('question-sets.show', $question_set->id) }}"
                     class="btn btn-sm green-seagreen btn-outline filter-submit margin-bottom">
                    <i class="fa fa-eye"></i>
                  </a>
                @endcan
                @can('edit_question_sets')
                  <a href="{{ route('question-sets.edit', $question_set->id) }}"
                     class="btn btn-sm blue btn-outline filter-submit margin-bottom">
                    <i class="fa fa-edit"></i>
                  </a>
                @endcan
                @can('delete_question_sets')
                  @if($question_set->deleted_at == null)
                    {!! Form::open(['route' => ['question-sets.destroy', $question_set->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
                      <button
                          class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-delete"
                          title="Delete"
                      >
                        <i class="fa fa-trash-o"></i>
                      </button>
                    {!! Form::close() !!}
                  @else
                    {!! Form::open(['route' => ['question-sets.restore', $question_set->id], 'method' => 'POST', 'class' => 'form-edit-button']) !!}
                      <button
                          class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-restore"
                          title="Restore"
                      >
                        <i class="fa fa-recycle"></i>
                      </button>
                    {!! Form::close() !!}

                    {!! Form::open(['route' => ['question-sets.forceDestroy', $question_set->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
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
    {{ $question_sets->appends(request()->input())->links() }}    
  </div>
@endsection