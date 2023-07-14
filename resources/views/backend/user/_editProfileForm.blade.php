<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('phone1') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('phone1', 'Phone Number', ['class' => 'control-label']) !!}

            {!! Form::text('phone1', null, ['class' => 'form-control', 'placeholder'=>'Phone Number' ]) !!}

            @if ($errors->has('phone1'))
                <span class="help-block">
                    <strong>{{ $errors->first('phone1') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('phone2') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('phone2', 'Secondary Phone Number', ['class' => 'control-label']) !!}

            {!! Form::text('phone2', null, ['class' => 'form-control', 'placeholder'=>'Secondary Phone Number' ]) !!}

            @if ($errors->has('phone2'))
                <span class="help-block">
                    <strong>{{ $errors->first('phone2') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('address', 'Address', ['class' => 'control-label']) !!}

            {!! Form::text('address', null, ['class' => 'form-control', 'placeholder'=>'Address' ]) !!}

            @if ($errors->has('address'))
                <span class="help-block">
                    <strong>{{ $errors->first('address') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('city') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('city', 'City', ['class' => 'control-label']) !!}

            {!! Form::text('city', null, ['class' => 'form-control', 'placeholder'=>'City' ]) !!}

            @if ($errors->has('city'))
                <span class="help-block">
                    <strong>{{ $errors->first('city') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        {!! Form::label('user_image', 'User Image', ['class' => 'control-label']) !!}
        <div class="form-group {{ $errors->has('user_image') ? 'has-error' :'' }}">
            <div class="fileinput {{isset($userProfile) ? ((!$userProfile->image) ? 'fileinput-new':'fileinput-exists') :
                    'fileinput-new'}}" data-provides="fileinput">
                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px; display: none;">
                    <img src="" alt="" style="width: 150px; height: 140px;"/>
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail"  style="max-width: 200px; max-height: 150px;">
                    <a href="@if(isset($userProfile->image)) /storage/media/user/{{$user->id}}/{{$userProfile->image->filename}} @endif" data-lightbox="user">
                        <img src="@if(isset($userProfile->image)) /storage/media/user/{{$user->id}}/thumbnail/{{$userProfile->image->filename}} @endif" alt=""/>
                    </a>
                </div>
                <div>
                    <span class="btn default btn-file">
                        <span class="fileinput-new"> Select image </span>
                        <span class="fileinput-exists"> Change </span>
                        <input type="file" name="user_image" accept="image/*">
                    </span>
                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput" @isset($userProfile) id="deleteImage" data-target-id = "{{ $userProfile->user_image_id }}" @endisset> Remove </a>
                </div>
                
                @if($errors->first('user_image'))
                  <div class="ui pointing red basic label"> {{ $errors->first('user_image') }}</div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="portlet-footer">
    <div class="form-group">
        <a href="{{ route('users.index') }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
        Back</a>

        <button class="btn btn-primary green" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;Update Profile
        </button>
    </div>
</div>