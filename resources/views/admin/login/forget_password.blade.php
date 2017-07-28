<?php $pageTitle = 'Forget Password'; ?>
@extends('admin.login_layout')

@section('title', $pageTitle)
@section('content')
<div class="col-md-4 offset-md-4">
    {!! Form::open(['url' => '/admin/forget-password', 'class' => 'login_form']) !!}
    @include('admin.includes.formErrors')
    @include('admin.includes.flashMsg')
    <div class="form-group">
        <div class="input-group">
            {!! Form::text('username', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Username']) !!}
            <div class="input-group-addon"><i class="ti-user"></i></div>
        </div>
    </div>

    <div class="form-group clearfix">
        <div class="float-xs-left">

        </div>
        <div class="float-xs-right">
            <a class="text-white font-90" href="{{ url('admin/login') }}">Back to Login</a>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-danger btn-block">Sign in</button>
    </div>
    {!! Form::close() !!}
</div>

@stop