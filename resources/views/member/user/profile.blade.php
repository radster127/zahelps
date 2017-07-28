<?php
$pageTitle = "Profile";

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


            {!! Form::model($user, ['url' => url('member/update-profile'), 'class' => 'module_form']) !!}

            <div class="form-body">
                <h3 class="box-title">Personal Information</h3>
                <hr>

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
                            <label class="control-label">Mobile Number</label>
                            <div class="input-group">
                                {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Enter mobile number', 'id' => 'phone', 'readonly' => 'readonly', 'required' => 'required']) !!}
                                <div class="input-group-addon"><i class="ti-mobile"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Username</label>
                            <div class="input-group">
                                {!! Form::text('username', null, ['class' => 'form-control', 'placeholder' => 'Enter username', 'readonly' => 'readonly']) !!}
                                <div class="input-group-addon"><i class="ti-user"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Registration Date</label>
                            <div class="input-group">
                                {!! Form::text('joining_datetime', null, ['class' => 'form-control', 'placeholder' => 'Registration Date', 'readonly' => 'readonly']) !!}
                                <div class="input-group-addon"><i class="ti-calendar"></i></div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <div class="input-group">
                                {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Enter email', 'readonly' => 'readonly']) !!}
                                <div class="input-group-addon"><i class="ti-email"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Upline Username</label>
                            <div class="input-group">
                                {!! Form::text('uplineusername', $user->user_id > 0 ? $user->sponsor->username : null, ['class' => 'form-control', 'placeholder' => 'Enter username', 'readonly' => 'readonly']) !!}
                                <div class="input-group-addon"><i class="ti-user"></i></div>
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
                            <label class="control-label">Bank Account Holder</label>
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
                            <label class="control-label">Country</label>
                            {!! Form::select('country_id', $countries, null , ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Postal Code</label>
                            <div class="input-group">
                                {!! Form::text('pincode', null, ['class' => 'form-control', 'placeholder' => 'Enter postal code']) !!}
                                <div class="input-group-addon"><i class="ti-map-alt"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Referral Link</label>
                            <div class="input-group">
                                {!! Form::text('referral_link', env('APP_URL') . '/member/register/' . $user->username, ['class' => 'form-control', 'readonly' => 'readonly', 'placeholder' => 'Enter referral link']) !!}
                                <div class="input-group-addon"><i class="ti-link"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 class="box-title">Social Information</h3>
                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Facebook</label>
                            <div class="input-group">
                                {!! Form::text('facebook', null, ['class' => 'form-control', 'placeholder' => 'Enter Facebook Url']) !!}
                                <div class="input-group-addon"><i class="ti-facebook"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Twitter</label>
                            <div class="input-group">
                                {!! Form::text('twitter', null, ['class' => 'form-control', 'placeholder' => 'Enter Twitter Url']) !!}
                                <div class="input-group-addon"><i class="ti-twitter"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Subscribe for newsletter</label>
                            {!! Form::select('newsletter', ['0' => 'No', '1' => 'Yes'], null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>


            </div>
            <hr/>
            <div class="form-actions text-right">
                <button type="submit" class="btn btn-lg btn-success"> <i class="fa fa-check"></i> Edit Profile</button>
            </div>

            {!! Form::close() !!}

        </div>  
    </div>
</div>

@stop

@section('page_js')
@if ($user->phone == '')
<script type="text/javascript">
  $(function () {
      $('#phone').prop('readonly', false);
  });
</script>
@endif
@stop