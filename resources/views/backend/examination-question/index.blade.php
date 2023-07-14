@extends('layouts.backend')

@section('title')
  {{ $set['name'] }} Question
@endsection

@section('content')
  <div class="portlet-title">
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6">
        <h1 class="page-title font-green sbold">
          <i class="fa fa-television font-green"></i> {{ $set['name'] }} Question
          <small class="font-green sbold">List</small>
        </h1>
      </div>
      @can('add_examination_questions')
        <div class="col-xs-6 col-sm-6 col-md-6">
          <div class="caption pull-right">
            <a href="{{ route('examination-questions.create', $set->slug ) }}" class="btn btn-sm bold green">
              <i class="fa fa-plus"></i> Add Question
            </a>
          </div>
        </div>
      @endcan

      @include('backend.examination-question._filter')

    </div>
  </div>
  <div class="portlet-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>Question</th>
            <th>Subject</th>
            <th>Marks</th>
            
            @if(auth()->user()->can('edit_examination_questions') || auth()->user()->can('delete_examination_questions'))
              <th class="text-center">Actions</th>
            @endif
          </tr>
        </thead>
        <tbody>
          @forelse($examination_questions as $examination_question)
            <tr>
              <td>{{ reversePagination($examination_questions, $loop) }}</td>                      
              <td>{!! str_limit($examination_question->question, $limit = 35, $end = '...') !!}</td>
              <td>{{ $subjects[$examination_question->subject] }}</td>
              <td>{{ $marks[$examination_question->marks] }}</td>

              @if(auth()->user()->can('view_examination_questions') || auth()->user()->can('edit_examination_questions') || auth()->user()->can('delete_examination_questions'))
                <td class="text-center">
                  @can('view_examination_questions')
                    <a href="{{ route('examination-questions.show', ['set_type' => $set->slug, 'id' => $examination_question->id ]) }}" class="btn btn-sm blue btn-outline filter-submit margin-bottom">
                      <i class="fa fa-eye"></i>
                    </a>
                  @endcan
                  @can('edit_examination_questions')
                    <a href="{{ route('examination-questions.edit', ['set_type' => $set->slug, 'id' => $examination_question->id ]) }}" class="btn btn-sm blue btn-outline filter-submit margin-bottom">
                      <i class="fa fa-edit"></i>
                    </a>
                  @endcan
                  @can('delete_examination_questions')
                    @if($examination_question->deleted_at == null)
                      {!! Form::open(['route' => ['examination-questions.destroy', $set->slug, $examination_question->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
                        <button  class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-delete"
                            title="Delete">
                          <i class="fa fa-trash-o"></i>
                        </button>
                      {!! Form::close() !!}
                    @else
                      {!! Form::open(['route' => ['examination-questions.restore', $set->slug, $examination_question->id], 'method' => 'POST', 'class' => 'form-edit-button']) !!}
                        <button
                            class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-restore"
                            title="Restore"
                        >
                          <i class="fa fa-recycle"></i>
                        </button>
                      {!! Form::close() !!}

                      {!! Form::open(['route' => ['examination-questions.forceDestroy', $set->slug, $examination_question->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
                        <button class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-force-delete"  title="Force Delete">
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
    {{ $examination_questions->appends(request()->input())->links() }}
  </div>
@endsection
