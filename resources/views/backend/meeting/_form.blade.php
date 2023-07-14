<div class="row">
    <div class="col-md-12">
        <div class="form-group required {{ $errors->has('topic') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('topic', 'Topic', ['class' => 'control-label']) !!}

            {!! Form::text('topic', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Topic']) !!}

            @if ($errors->has('topic'))
                <div class="ui pointing red basic label"> {{$errors->first('topic')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('english_meeting_date') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('english_meeting_date', 'English meeting Date', ['class' => 'control-label']) !!}

            {!! Form::text('english_meeting_date', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'English meeting Date', 'id' => 'english_date_picker', 'data-conversion-type' => 'english-nepali']) !!}

            @if ($errors->has('english_meeting_date'))
                <div class="ui pointing red basic label"> {{$errors->first('english_meeting_date')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('nepali_meeting_date') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('nepali_meeting_date', 'Nepali meeting Date', ['class' => 'control-label']) !!}

            {!! Form::text('nepali_meeting_date', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Nepali meeting Date', 'id' => 'nepali_date_picker', 'data-conversion-type' => 'nepali-english']) !!}

            @if ($errors->has('nepali_meeting_date'))
                <div class="ui pointing red basic label"> {{$errors->first('nepali_meeting_date')}}</div>
            @endif
        </div>
    </div>    
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('meeting_start_time') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('meeting_start_time', 'Start Time', ['class' => 'control-label']) !!}

            {!! Form::text('meeting_start_time', null, ['class' => 'form-control custom-time', 'placeholder'=>'Start Time', 'requried' => 'required']) !!}
            

            @if ($errors->has('meeting_start_time'))
                <div class="ui pointing red basic label"> {{$errors->first('meeting_start_time')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('meeting_end_time') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('meeting_end_time', 'End Time', ['class' => 'control-label']) !!}

            {!! Form::text('meeting_end_time', null, ['class' => 'form-control custom-time', 'placeholder'=>'End Time', 'requried' => 'required']) !!}
            

            @if ($errors->has('meeting_end_time'))
                <div class="ui pointing red basic label"> {{$errors->first('meeting_end_time')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group {{ $errors->has('discussed') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('discussed', 'Discussed', ['class' => 'control-label']) !!}

            {!! Form::textarea('discussed', null, ['class' => 'form-control custom-textarea', 'placeholder'=>'Discussed', 'rows' => 4 ]) !!}

            @if ($errors->has('discussed'))
                <div class="ui pointing red basic label"> {{$errors->first('discussed')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        {!! Form::label('meeting_file_id', 'File', ['class' => 'control-label']) !!}
        <div class="form-group {{ $errors->has('meeting_file_id') ? 'has-error' :'' }}">
            <div class="fileinput {{isset($meeting) ? ((!$meeting->file) ? 'fileinput-new':'fileinput-exists') :
                    'fileinput-new'}}" data-provides="fileinput">
                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px; display: none;">
                    <img src="" alt="" style="width: 150px; height: 140px;"/>
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail"  style="max-width: 200px; max-height: 150px;">
                    @isset($meeting->file)
                        @if($meeting->file->extension == 'pdf')
                            <a href="@if(isset($meeting->file)) /storage/media/meeting/{{ $meeting->id }}/{{ $meeting->file->filename }} @endif">
                                <img src="@if(isset($meeting->file)) {{ asset('images/pdf-logo.jpg') }} @endif" alt="" class="file-pdf" />
                            </a>
                        @else
                            <a href="@if(isset($meeting->file)) /storage/media/meeting/{{ $meeting->id }}/{{ $meeting->file->filename }} @endif" data-lightbox="image">
                                <img src="@if(isset($meeting->file)) /storage/media/meeting/{{ $meeting->id }}/thumbnail/{{ $meeting->file->filename }} @endif" alt=""/>
                            </a>
                        @endif
                    @endisset
                </div>
                <div>
                    <span class="btn default btn-file">
                        <span class="fileinput-new"> Select File </span>
                        <span class="fileinput-exists"> Change </span>
                        <input type="file" name="meeting_file_id" accept="image/*,application/pdf">
                    </span>
                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput" @isset($meeting) id="deleteFile" data-target-id = "{{ $meeting->meeting_file_id }}" @endisset> Remove </a>
                </div>
                
                @if($errors->first('meeting_file_id'))
                  <div class="ui pointing red basic label"> {{ $errors->first('meeting_file_id') }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
