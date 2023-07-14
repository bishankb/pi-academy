@extends('layouts.backend')

@section('title')
    Show Question Detail
@endsection

@section('content')

    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h1 class="page-title font-green sbold">
                    <i class="fa fa-television font-green"></i> {{ $set->name }}
                    <small class="font-green sbold">Question Details</small>
                </h1>
            </div>
        </div>
    </div>
    <div class="portlet-body">
        <ul class="list-group">
            <li class="list-group-item">
                <strong>Subject:</strong> {{ $subjects[$examination_question->subject] }}
            </li>
             <li class="list-group-item">
                <strong>Marks:</strong> {{ $marks[$examination_question->marks] }}
            </li>
            <li class="list-group-item">
                <strong>Question:</strong><br><br> {!! $examination_question->question !!}
            </li>
            <li class="list-group-item">
                <strong>Option 1:</strong><br><br> {!! $examination_question->option1 !!}
            </li>
            <li class="list-group-item">
                <strong>Option 2:</strong><br><br> {!! $examination_question->option2 !!}
            </li>
            <li class="list-group-item">
                <strong>Option 3:</strong><br><br> {!! $examination_question->option3 !!}
            </li>
            <li class="list-group-item">
                <strong>Option 4:</strong><br><br> {!! $examination_question->option4 !!}
            </li>
            <li class="list-group-item">
                <strong>Correct Answer:</strong> {{ $options[$examination_question->correct_answer] }}
            </li>
            @isset($examination_question->solution)
                <li class="list-group-item">
                    <strong>Solution:</strong><br><br> {!! $examination_question->solution !!}
                </li>
            @endisset
            @isset($set->paragraph->paragraph)
                <li class="list-group-item">
                    <strong>Paragraph:</strong><br><br> {!! $set->paragraph->paragraph !!}
                </li>
            @endisset
            @isset($examination_question->image)
                <li class="list-group-item">
                    <strong>Question Image</strong><br><br>
                    <a href="/storage/media/examination-question/{{ $examination_question->id }}/{{ $examination_question->image->filename }}" data-lightbox="image1">
                        <img class="custom-thumbnail selected-img" src="/storage/media/examination-question/{{ $examination_question->id }}/thumbnail/{{ $examination_question->image->filename }}" class="custom-thumbnail">
                    </a>
                </li>
            @endisset
        </ul>
        <ul class="list-group">
            <li class="list-group-item">
                <strong>Created By:</strong> {{ $examination_question->createdBy->name }}
            </li>
            <li class="list-group-item">
                <strong>Updated By:</strong> {{ $examination_question->updatedBy->name }}
            </li>
        </ul>
    </div>

    <div class="portlet-footer">
        <div class="form-group">
            <a href="{{ route('examination-questions.index', $set->slug) }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
            Back</a>
        </div>
    </div>
@endsection

