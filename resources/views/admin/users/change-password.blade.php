<?php
$pageTitle = "Change Password";

$breadCrumbArray = array(
    'Home' => url('/'),
    $pageTitle => '',
);
?>

@extends('admin.layout')
@section('title', $pageTitle)

@section ('content')

@include('admin.includes.breadcrumb')
@include('admin.includes.flashMsg')

<!-- row -->

<div class="row">
    <div class="col-md-4 offset-md-4 col-sm-12">
        <div class="box box-block bg-white">
            {!! Form::open(['url' => url('admin/change-password'), 'class' => 'module_form', 'files' => true, ]) !!}
            <div class="form-body"> 

                @include('admin.includes.formErrors')

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('Old Password') !!}
                            {!! Form::password('old_password', ['class' => 'form-control', 'placeholder' => 'Enter old password', 'required' => 'required', 'data-parsley-minlength' => '6']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('New Password') !!}
                            {!! Form::password('new_password', ['class' => 'form-control', 'id' => 'new_password', 'placeholder' => 'Enter new password', 'required' => 'required', 'data-parsley-minlength' => '6' , 'data-parsley-type' => 'alphanum']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Confirm Password') !!}
                            {!! Form::password('confirm_password', ['class' => 'form-control', 'placeholder' => 'Enter confirm password', 'required' => 'required', 'data-parsley-minlength' => '6' , 'data-parsley-type' => 'alphanum', 'data-parsley-equalto' => '#new_password']) !!}
                        </div>
                    </div>
                </div>
                <hr/>
                <button type="submit" class="btn btn-info pull-right waves-effect waves-light">Change Password</button>
                <div class="clearfix"></div>
            </div>
        </div>

    </div>

    {!! Form::close() !!}

</div> <!-- end row -->

@stop
