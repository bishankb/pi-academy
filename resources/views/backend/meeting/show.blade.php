@extends('layouts.backend')

@section('title')
    Show Meeting
@endsection

@section('content')

    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h1 class="page-title font-green sbold">
                    <i class="fa fa-television font-green"></i> Meeting
                    <small class="font-green sbold">Show</small>
                </h1>
            </div>
        </div>
    </div>
    <div class="portlet-body">
        <ul class="list-group">
            @isset($meeting->file)
                <li class="list-group-item">
                    @if($meeting->file->extension == 'pdf')
                        <a href="@if(isset($meeting->file)) /storage/media/meeting/{{ $meeting->id }}/{{ $meeting->file->filename }} @endif">
                            <img src="@if(isset($meeting->file)) {{ asset('images/pdf-logo.jpg') }} @endif" alt="" class="file-pdf" />
                        </a>
                    @else
                        <a href="@if(isset($meeting->file)) /storage/media/meeting/{{ $meeting->id }}/{{ $meeting->file->filename }} @endif" data-lightbox="image">
                            <img src="@if(isset($meeting->file)) /storage/media/meeting/{{ $meeting->id }}/thumbnail/{{ $meeting->file->filename }} @endif" alt=""/>
                        </a>
                    @endif
                </li>
            @endisset
            <li class="list-group-item">
                <strong>Topic:</strong> {{ $meeting->topic }}
            </li>
            <li class="list-group-item">
                <strong>English Meeting Date:</strong> {{ $meeting->english_meeting_date }} A.D.
            </li>
            <li class="list-group-item">
                <strong>Nepali Meeting Date:</strong> {{ $meeting->nepali_meeting_date }} B.S.
            </li>
            <li class="list-group-item">
                <strong>Start Time:</strong> {{ \Carbon\Carbon::parse($meeting->meeting_start_time)->format('h:i:s a')}}
            </li>
            <li class="list-group-item">
                <strong>End Time:</strong> {{ \Carbon\Carbon::parse($meeting->meeting_start_time)->format('h:i:s a')}}
            </li>
            @isset($meeting->discussed)
                <li class="list-group-item">
                    <strong>Discussed:</strong> {{ $meeting->discussed }}
                </li>
            @endisset
            
        </ul>
        <ul class="list-group">
            <li class="list-group-item">
                <strong>Created By:</strong> {{ $meeting->createdBy->name }}
            </li>
            <li class="list-group-item">
                <strong>Updated By:</strong> {{ $meeting->updatedBy->name }}
            </li>
        </ul>
    </div>

    <div class="portlet-footer">
        <div class="form-group">
            <a href="{{ route('meeting.index') }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
            Back</a>
        </div>
    </div>
@endsection

