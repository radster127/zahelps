<?php $pageTitle = 'Login' ?>

@extends('member.login_layout')

@section('title', $pageTitle)
@section('content')

<div class="white-box">
    {!! Form::open(['url' => '/member/login', 'class' => 'login_form form-horizontal', 'id' => 'loginform']) !!}
    <a href="javascript:void(0)" class="text-center db">
        <img class="front-logo" src="{{ asset('/') }}themes/eliteadmin/plugins/images/logo.png" alt="Home" />
<!--        <img src="{{ asset('/') }}/themes/eliteadmin/plugins/images/eliteadmin-logo-dark.png" alt="Home" /><br/><img src="{{ asset('/') }}/themes/eliteadmin/plugins/images/eliteadmin-text-dark.png" alt="Home" />-->
    </a>  
    
    @include('member.includes.formErrors')
    @include('member.includes.flashMsg')

    <div class="form-group m-t-20">
        <div class="col-xs-12">
            <div class="input-group">
                {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Email']) !!}
                <div class="input-group-addon"><i class="ti-user"></i></div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-12">
            <div class="input-group">
                {!! Form::password('password', ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Password', 'data-parsley-minlength' => 6]) !!}
                <div class="input-group-addon"><i class="ti-key"></i></div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <div class="checkbox checkbox-primary pull-left p-t-0">
                <input id="checkbox-signup" type="checkbox">
                <label for="checkbox-signup"> Remember me </label>
            </div>
            <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Forgot password?</a> 
        </div>
    </div>
    <div class="form-group text-center m-t-20">
        <div class="col-xs-12">
            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
        </div>
    </div>
    <div class="form-group text-center m-t-20">
        <div class="col-xs-12 text-center">
            <a href="{{ url('member/register') }}" class="text-dark"><i class="fa fa-user m-r-5"></i> Register</a> 
        </div>
    </div>

    {!! Form::close() !!}

    <!-- forget password [start] -->
    {!! Form::open(['url' => '/member/forget-password', 'class' => 'forget_password_form form-horizontal', 'id' => 'recoverform']) !!}
    <div class="form-group ">
        <div class="col-xs-12">
            <h3>Recover Password</h3>
            <p class="text-muted">Enter your Email and new password will be sent to you! </p>
        </div>
    </div>
    <div class="form-group ">
        <div class="col-xs-12">
            <div class="input-group">
                {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Email']) !!}
                <div class="input-group-addon"><i class="ti-email"></i></div>
            </div>
        </div>
    </div>
    <div class="form-group ">
        <div class="col-xs-12">
            <a href="javascript:void(0)" id="to-login" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Back to Login</a> 
        </div>
    </div>
    <div class="form-group text-center m-t-20">
        <div class="col-xs-12">
            <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
        </div>
    </div>
    {!! Form::close() !!}
    <!-- forget password [end] -->


</div>


@stop