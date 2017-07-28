<?php
$pageTitle = "Register";

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
    <div class="col-md-12">

        <div class="white-box">

            @include('member.includes.formErrors')
            @include('member.includes.flashMsg')


            {!! Form::open(['url' => url('member/store-member'), 'class' => 'module_form']) !!}
            <div class="form-body">
                <h3 class="box-title">Personal Information</h3>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Upline / Sponsor</label>
                            {!! Form::text('user_id', null, ['class' => 'form-control', 'required' => 'required', 'id' => 'user_id']) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Full Name</label>
                            <div class="input-group">
                                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter full name', 'required' => 'required']) !!}
                                <div class="input-group-addon"><i class="ti-user"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <div class="input-group">
                                {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Enter email', 'required' => 'required']) !!}
                                <div class="input-group-addon"><i class="ti-email"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Username</label>
                            <div class="input-group">
                                {!! Form::text('username', null, ['class' => 'form-control', 'placeholder' => 'Enter username', 'required' => 'required']) !!}
                                <div class="input-group-addon"><i class="ti-user"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Password</label>
                            <div class="input-group">
                                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Enter password', 'required' => 'required', 'data-parsley-min-length' => '6']) !!}
                                <div class="input-group-addon"><i class="ti-key"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Mobile Number</label>
                            <div class="input-group">
                                {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Enter mobile number', 'required' => 'required']) !!}
                                <div class="input-group-addon"><i class="ti-mobile"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 class="box-title">Bank Information</h3>
                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Bank Name</label>
                            <div class="input-group">
                                {!! Form::text('bank_name', null, ['class' => 'form-control', 'placeholder' => 'Enter bank name', 'required' => 'required']) !!}
                                <div class="input-group-addon"><i class="fa fa-bank"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Bank Account Number</label>
                            <div class="input-group">
                                {!! Form::text('bank_account_number', null, ['class' => 'form-control', 'placeholder' => 'Enter bank account number', 'required' => 'required']) !!}
                                <div class="input-group-addon"><i class="fa fa-barcode"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Bank Account Name</label>
                            <div class="input-group">
                                {!! Form::text('bank_account_name', null, ['class' => 'form-control', 'placeholder' => 'Enter bank account name', 'required' => 'required']) !!}
                                <div class="input-group-addon"><i class="ti-id-badge"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Bitcoin Address</label>
                            <div class="input-group">
                                {!! Form::text('bitcoin', null, ['class' => 'form-control', 'placeholder' => 'Enter bitcoin address']) !!}
                                <div class="input-group-addon"><i class="fa fa-bitcoin"></i></div>
                            </div>
                        </div>
                    </div>
                </div>


                <h3 class="box-title m-t-40">Address Information</h3>
                <hr>


                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Address</label>
                            <div class="input-group">
                                {!! Form::text('address', null, ['class' => 'form-control', 'placeholder' => 'Enter address']) !!}
                                <div class="input-group-addon"><i class="ti-location-pin"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">City</label>
                            <div class="input-group">
                                {!! Form::text('city', null, ['class' => 'form-control', 'placeholder' => 'Enter City']) !!}
                                <div class="input-group-addon"><i class="ti-location-pin"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Postal Code</label>
                            <div class="input-group">
                                {!! Form::text('pincode', null, ['class' => 'form-control', 'placeholder' => 'Enter postal code']) !!}
                                <div class="input-group-addon"><i class="ti-map-alt"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Country</label>
                            {!! Form::select('country_id', $countries, null , ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>

            </div>
            <hr/>
            <div class="form-actions text-right">
                <button type="submit" class="btn btn-lg btn-success"> <i class="fa fa-check"></i> Register New Member</button>
            </div>
            {!! Form::close() !!}

        </div>  
    </div>
</div>

@stop


@section ('page_js')

@section('page_js')

<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('/') }}thirdparty/autocomplete/css/token-input-facebook.css" />
<script type="text/javascript" src="{{ asset('/') }}thirdparty/autocomplete/js/jquery.tokeninput.js"></script>

<script type="text/javascript">

$(function () {

    $("#user_id").tokenInput(
            '{{ url("member/get-users")}}', {
                theme: "facebook",
                preventDuplicates: true,
                tokenLimit: 1,
            }
    );


});

</script>


@stop