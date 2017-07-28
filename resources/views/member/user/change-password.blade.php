<?php
$pageTitle = "Change Password";

$breadCrumbArray = array(
    'Home' => url('/member'),
    $pageTitle => '',
);
?>
@extends('member.layout')

@section('title', $pageTitle)
@section('content')

@include('member.includes.breadcrumb')

<div class="row">
    <div class="col-md-4 col-md-offset-4">

        <div class="white-box">


            {!! Form::open(['url' => url('member/change-password'), 'class' => 'module_form']) !!}

            <div class="form-body">
                <h3 class="box-title">Change Password</h3>
                <hr>

                @include('member.includes.formErrors')
                @include('member.includes.flashMsg')

                <div class="row">
                    <div class="col-md-12">

                        <div class="form-group">
                            <label class="control-label">Old Password</label>
                            <div class="input-group">
                                {!! Form::password('old_password', ['class' => 'form-control', 'placeholder' => 'Enter old password', 'required' => 'required', 'data-parsley-minlength' => '6']) !!}
                                <div class="input-group-addon"><i class="ti-key"></i></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">New Password</label>
                            <div class="input-group">
                                {!! Form::password('new_password', ['class' => 'form-control', 'id' => 'new_password', 'placeholder' => 'Enter new password', 'required' => 'required', 'data-parsley-minlength' => '6', 'data-parsley-type' => 'alphanum']) !!}
                                <div class="input-group-addon"><i class="ti-key"></i></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Confirm Password</label>
                            <div class="input-group">
                                {!! Form::password('confirm_password', ['class' => 'form-control', 'placeholder' => 'Enter confirm password', 'required' => 'required', 'data-parsley-minlength' => '6' , 'data-parsley-type' => 'alphanum',  'data-parsley-equalto' => '#new_password']) !!}
                                <div class="input-group-addon"><i class="ti-key"></i></div>
                            </div>
                        </div>

                    </div>

                    <div class="form-actions text-right">
                        <button type="submit" class="btn btn-lg btn-success"> <i class="fa fa-check"></i> Change Password</button>
                    </div>
                </div>



                {!! Form::close() !!}

            </div>  
        </div>
    </div>
</div>

@stop