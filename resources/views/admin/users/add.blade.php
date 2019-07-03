@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-md-6">
        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Add User </h3>
            </div>
            {!! Form::model($user, ['method'=>'POST','route' =>
            ['postUser'],'class'=>'form-horizontal','autocomplete'=>'off','files'=>true]) !!}

            <div class="box-body">
                <div class="form-group {{ $errors->has('firstname') ? 'has-error' : '' }}">
                    <label class="col-sm-3 control-label" for="firstname">Firstname <span
                            class="text-red">*</span></label>
                    <div class="col-sm-8">
                        {!! Form::hidden('uid', request()->segment(4), ['class' => 'form-control']) !!}
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
                    <div class="col-sm-8">
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
                    <div class="col-sm-8">
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
                    <div class="col-sm-5">
                        {{ Form::password('password',['class'=> 'form-control','placeholder'=>'Enter your Password','autocomplete'=>'off','id'=>'password']) }}
                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="col-sm-1">
                        <button class="btn btn-primary" type="button" id="btnPass">Generate Password</button>
                    </div>
                </div>

                <!-- <div class="form-group">
                    <label class="col-sm-3 control-label" for="inputPassword3">Confirm Password </label>

                    <div class="col-sm-8">
                        {{ Form::password('password_confirmation',['class' => 'form-control','placeholder'=>'Re-enter your Password','autocomplete'=>'off']) }}

                        @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                        @endif
                    </div>
                </div> -->

                <div class="form-group {{ $errors->has('role') ? 'has-error' : '' }}">
                    <label class="col-sm-3 control-label" for="inputPassword3">Role</label>

                    <div class="col-sm-8">
                        
                        {!! Form::select('role',['0'=>'Please select']+$role,null, ['class' => 'select2 select2-hidden-accessible form-control','id'=>'role', 'style' => 'width: 100%']) !!}
                        @if ($errors->has('role'))
                        <span class="help-block">
                            <strong>{{ $errors->first('role') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                    <label class="col-sm-3 control-label" for="image">Image <span class="text-red">*</span></label>
                    <div class="col-sm-8 ">
                        <input type="file" name="image" id="img" onChange="AjaxUploadImage(this)" class="form-control">
                        <br>
                        <div class="col-sm-6">
                            <div class="thumbnail">                            
                                @if(!empty($user->image) && file_exists($user->image))
                                <img src="{{ asset($user->image)}}" alt="" class="img-thumbnail" id="DisplayImage"
                                    style="width: 150px;height: 150px;">
                                @else
                                <img src="{{ asset('images/default.jpg') }}" alt="" class="img-thumbnail" id="DisplayImage"
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
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.tab-content -->
@endsection

@section('section_js')

$(document).ready(function() {
   
});

@if(\Session::has('Success'))
<script>
Tost("{{\Session::get('Success')}}", 'success');
@endif
</script>
@endsection