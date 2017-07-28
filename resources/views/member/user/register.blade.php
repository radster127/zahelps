<?php $pageTitle = 'Register' ?>


@extends('member.login_layout')
@section('title', $pageTitle)

@section('content')

<div class="white-box">
    {!! Form::open(['url' => '/member/register', 'class' => 'login_form form-horizontal', 'id' => 'loginform']) !!}
    <a href="javascript:void(0)" class="text-center db">
        <img class="front-logo" src="{{ asset('/') }}themes/eliteadmin/plugins/images/logo.png" alt="Home" />
<!--        <img src="{{ asset('/') }}/themes/eliteadmin/plugins/images/eliteadmin-logo-dark.png" alt="Home" /><br/><img src="{{ asset('/') }}/themes/eliteadmin/plugins/images/eliteadmin-text-dark.png" alt="Home" />-->
    </a>  
    
    @include('member.includes.formErrors')
    @include('member.includes.flashMsg')

    <div class="form-group m-t-20">
        <div class="col-xs-12">
            <div class="input-group">
                {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Enter full name']) !!}
                <div class="input-group-addon"><i class="ti-user"></i></div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-12">
            <div class="input-group">
                {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Enter email']) !!}
                <div class="input-group-addon"><i class="ti-email"></i></div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-12">
            <div class="input-group">
                {!! Form::text('username', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Enter username']) !!}
                <div class="input-group-addon"><i class="ti-user"></i></div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-12">
            <div class="input-group">
                {!! Form::password('password', ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Enter password', 'data-parsley-minlength' => 6, 'id' => 'password']) !!}
                <div class="input-group-addon"><i class="ti-key"></i></div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-12">
            <div class="input-group">
                {!! Form::password('confirm_password', ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Enter confirm password', 'data-parsley-minlength' => 6, 'data-parsley-equalto' => '#password']) !!}
                <div class="input-group-addon"><i class="ti-key"></i></div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-12">
            <label>Sponsor: </label>
            {!! Form::text('user_id', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Sponsor', 'id' => 'user_id']) !!}
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            <div class="checkbox checkbox-primary pull-left p-t-0">
                <input id="checkbox-signup" required="required" data-parsley-required-message="kinldy agree terms and conditions" type="checkbox">
                <label for="checkbox-signup"> I agree terms and conditions </label>
            </div>
        </div>
    </div>
    <div class="form-group text-center m-t-20">
        <div class="col-xs-12 text-center">
            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
        </div>
    </div>
    <div class="form-group text-center m-t-20">
        <div class="col-xs-12 text-center">
            <a href="{{ url('member/login') }}" class="text-dark"><i class="fa fa-lock m-r-5"></i> Back to login</a> 
        </div>
    </div>

    {!! Form::close() !!}




</div>


@stop


@section ('page_js')

<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('/') }}/thirdparty/autocomplete/css/token-input-facebook.css" />
<script type="text/javascript" src="{{ asset('/') }}/thirdparty/autocomplete/js/jquery.tokeninput.js"></script>

<script type="text/javascript">

$(function () {

    $("#user_id").tokenInput(
            '{{ url("member/get-users")}}', {
                theme: "facebook",
                preventDuplicates: true,
                tokenLimit: 1,
                prePopulate: [<?php echo isset($sponsor) ? json_encode($sponsor) : ''; ?>],
            }
    );


});

window.setTimeout(function () {
    $(".alert").fadeTo(500, 0).slideUp(500, function () {
        $(this).remove();
    });
}, 4000);

</script>

@stop