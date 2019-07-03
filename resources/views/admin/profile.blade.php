@extends('layouts.app')
@section('content')

<div class="row">

    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Edit User </h3>
            </div>
            <div class="pad margin no-print">
                <div style="margin-bottom: 0!important;" class="callout callout-info">
                    <h4><i class="fa fa-info"></i> Note:</h4>
                    Leave <strong>Password</strong> and <strong>Confirm Password</strong> empty if you are not going to
                    change the password.
                </div>
            </div>

            {!! Form::model($user, ['method'=>'POST','route' =>
            ['save_profile'],'class'=>'form-horizontal','autocomplete'=>'off','files'=>true]) !!}

            <div class="box-body">
                <div class="form-group {{ $errors->has('firstname') ? 'has-error' : '' }}">
                    <label class="col-sm-3 control-label" for="firstname">Firstname <span
                            class="text-red">*</span></label>
                    <div class="col-sm-9">
                        {!! Form::text('firstname', null, ['class' => 'form-control']) !!}
                        @if ($errors->has('firstname'))
                        <span class="help-block">
                            <strong>{{ $errors->first('firstname') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group {{ $errors->has('lastname') ? 'has-error' : '' }}">
                    <label class="col-sm-3 control-label" for="lastname">Lastname <span
                            class="text-red">*</span></label>
                    <div class="col-sm-9">
                        {!! Form::text('lastname', null, ['class' => 'form-control']) !!}
                        @if ($errors->has('lastname'))
                        <span class="help-block">
                            <strong>{{ $errors->first('lastname') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label class="col-sm-3 control-label" for="email">Email<span class="text-red">*</span></label>
                    <div class="col-sm-9">
                        {!! Form::text('email', null, ['class' => 'form-control','autocomplete'=>'off']) !!}
                        @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>



                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label class="col-sm-3 control-label" for="inputPassword3">Password </label>
                    <div class="col-sm-9">

                        {{ Form::password('password',['class'=> 'form-control','placeholder'=>'Enter your Password','autocomplete'=>'off']) }}

                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="inputPassword3">Confirm Password </label>

                    <div class="col-sm-9">
                        {{ Form::password('password_confirmation',['class' => 'form-control','placeholder'=>'Re-enter your Password','autocomplete'=>'off']) }}

                        @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                    <label class="col-sm-3 control-label" for="image">Image <span class="text-red">*</span></label>
                    <div class="col-sm-9 ">
                        <input type="file" name="image" id="img" onChange="AjaxUploadImage(this)" class="form-control">
                        <br>
                        <div class="col-sm-6">
                            <div class="thumbnail">
                            
                                @if(!empty($user->image) && file_exists('public/'.$user->image))
                                <img src="{{ asset('public/'.$user->image)}}" alt="" class="img-thumbnail" id="DisplayImage"
                                    style="width: 150px;height: 150px;">
                                @else
                                <img src="" alt="" class="img-thumbnail" id="DisplayImage"
                                    style="width: 150px;height: 150px;">
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="box-footer">
                <button class="btn btn-primary pull-right" type="submit">Save</button>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
</div>

@endsection

@section('section_js')
@if(\Session::has('Success'))
<script>
Tost("{{\Session::get('Success')}}", 'success');
</script>
@endif

@endsection