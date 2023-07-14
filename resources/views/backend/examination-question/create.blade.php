@extends('layouts.backend')

@section('title')
  Add Question
@endsection

@section('backend-style')
    <style>
        #paragraph_div {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h1 class="page-title font-green sbold">
                    <i class="fa fa-television font-green"></i> {{ $set->name }}
                    <small class="font-green sbold">Add Question</small>
                </h1>
            </div>
        </div>
    </div>
    {!! Form::model(null, ['method' => 'post', 'route' => ['examination-questions.store', $set->slug], 'files' => 'true']) !!}
        <div class="portlet-body">
    
            @include('backend.examination-question._form')
        
        </div>

        <div class="portlet-footer">
            <div class="form-group">
                <a href="{{ route('examination-questions.index', $set->slug) }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
                Back</a>

                <button class="btn btn-primary green" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;Save
                </button>
            </div>
        </div>
    {!! Form::close() !!}
@endsection

@section('backend-script')
    <script type="text/javascript">
        $(document).ready(function() {
            @if(!empty(old('subject')) && $subjects[old('subject')] == 'English' && 
                !empty(old('marks')) && $marks[old('marks')] == '2 Marks'
            )
                $('#paragraph_div').show();
            @else
                $('#paragraph_div').hide();
            @endif
        });

        $('#subject').change(function (event) {
            var subjects = {!! json_encode($subjects, JSON_HEX_TAG) !!};
            window.choosenSubject = subjects[event.target.value];
            alterParagraphDiv();
        });

        $('.marks').change(function (event) {
            var marks = {!! json_encode($marks, JSON_HEX_TAG) !!};
            window.choosenMarks = marks[event.target.value];
            alterParagraphDiv();
        });

        function alterParagraphDiv() {
            if(window.choosenSubject == 'English' && window.choosenMarks == '2 Marks') {
                $('#paragraph_div').show();
            } else {
                $('#paragraph_div').hide();
            }
        }
    </script>
@endsection
