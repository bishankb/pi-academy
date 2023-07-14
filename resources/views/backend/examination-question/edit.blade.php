@extends('layouts.backend')

@section('title')
  Edit Question
@endsection

@section('content')
    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h1 class="page-title font-green sbold">
                    <i class="fa fa-television font-green"></i>  {{ $set->name }}
                    <small class="font-green sbold">Edit Question</small>
                </h1>
            </div>
        </div>
    </div>
    {!! Form::model($examination_question, ['method' => 'PUT', 'route' => ['examination-questions.update', $set->slug, $examination_question->id], 'files' => 'true']) !!}

        <div class="portlet-body">
           
            @include('backend.examination-question._form')

        </div>

        <div class="portlet-footer">
            <div class="form-group">
                <a href="{{ route('examination-questions.index', $set->slug) }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
                Back</a>

                <button class="btn btn-primary green" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;Update
                </button>
            </div>
        </div>
    {!! Form::close() !!}
@endsection

@section('backend-script')
    <script type="text/javascript">
        $(document).ready(function() {

            @if(isset($examination_question->subject) && $subjects[$examination_question->subject] == 'English' &&
                isset($examination_question->marks) && $marks[$examination_question->marks] == '2 Marks'
                )
                $('#paragraph_div').show();
            @else 
                $('#paragraph_div').hide();                
            @endif

            var subjects = {!! json_encode($subjects, JSON_HEX_TAG) !!};
            var marks = {!! json_encode($marks, JSON_HEX_TAG) !!};

            var selectedSuject = {{ $examination_question->subject }};
            var selectedMarks = {{ $examination_question->marks }};

            window.selectedSubject = subjects[selectedSuject];
            window.selectedMarks = marks[selectedMarks];

            var subjectId = '{{ old('subject') }}';
            var markId = '{{ old('marks') }}';

            var subject = subjects[subjectId];
            var marks = marks[markId];

            if(subject && subject == 'English' && marks && marks == '2 Marks') {
                $('#paragraph_div').show();
            }
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
            if(window.selectedSubject == 'English' && window.choosenMarks == '2 Marks' ||
               window.selectedMarks == '2 Marks' && window.choosenSubject == 'English'
            ) {
                window.selectedSubject = null;
                window.selectedMarks = null;
                $('#paragraph_div').show();
            } else if(window.choosenSubject == 'English' && window.choosenMarks == '2 Marks') {
                $('#paragraph_div').show();
            } else {
                $('#paragraph_div').hide();
            }
        }
    </script>
@endsection