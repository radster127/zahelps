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

<div class="row my-page">

    <div class="col-md-12">
        @include('member.includes.formErrors')
        @include('member.includes.flashMsg')
    </div>

    <div class="col-md-3">
        <div class="white-box">
            <div class="overlay-box text-center bg-purple user-info">
                <a href="javascript:void(0)">
                    @if (Auth::user()->avatar != '')
                    <img onerror="userAvatarImgError(this)" src="{{ asset('/') }}uploads/members/{{ Auth::user()->id }}/thumb_100X100_{{ Auth::user()->avatar }}" alt="user-img">
                    @else
                    <img src="{{ asset('/') }}images/user.png" alt="user-img">
                    @endif
                </a>
                <br/>
                {!! Form::open(['url' => url('member/update-avatar'), 'class' => 'module_form', 'files' => true, 'id' => 'change_avatar_form']) !!}
                {!! Form::hidden('back_page', 'member/my-page') !!}
                <input type="file" id="avatar" name="avatar" class="hide" />
                {!! Form::close() !!}
                <a class="change_avatar" href="javascript:void(0)"><small><i>Change Avatar</i></small></a>
                <h4 class="text-white">{{ $user->username }}</h4>
                <h5 class="text-white">{{ $user->email }}</h5>
            </div>
        </div>
        <div class="clearfix"></div>
        <a href="{{ url('member/provide-help') }}" class="btn btn-success btn-lg btn-block provide_help_button">Provide Help</a>
        <a href="{{ url('member/get-help') }}" class="btn btn-danger btn-lg btn-block get_help_button">Get Help</a>
    </div>

    <div class="col-md-9">
        <div class="row">
            <div class="col-md-8">
                <div class="white-box">
                    <h2>Profile display</h2>
                    <table class="table table-bordered table-striped table-hover">
                        <tr>
                            <th class="col-md-6">Full Name</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Username </th>
                            <td>{{ $user->username }}</td>
                        </tr>
                        <tr>
                            <th>Mobile No</th>
                            <td>{{ $user->phone }}</td>
                        </tr>
                        <tr>
                            <th>Email Id</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Date of Registration</th>
                            <td>{{ \App\Custom::showDateTime($user->joining_datetime,'d M, y') }}</td>
                        </tr>
                        <tr>
                            <th>Approved PH</th>
                            <td>${{ number_format($approved_ph_amount, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Approved GH </th>
                            <td>${{ number_format($approved_gh_amount, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Downline PH </th>
                            <td>$0.00</td>
                        </tr>
                        <tr>
                            <th>Direct Referrals</th>
                            <td>{{ $direct_referrals }} Members</td>
                        </tr>
                        <tr>
                            <th>Total Downline</th>
                            <td>{{ $total_downline }} Members</td>
                        </tr>
                        <tr>
                            <th>Bonus Amount</th>
                            <td>${{ number_format($user->member_commision, 2) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            @if(count($news) > 0)
            <div class="col-md-4">
                <div class="white-box bg-info">
                    <h2 class="text-white">LATEST NEWS</h2>
                    <div id="news-list">
                        <ul class="page-news">
                            @foreach($news as $item)
                            <li class="text-white">
                                <h4>{{ $item->subject }}</h4>
                                <p>{{ $item->news }}</p>
                                <p class="text-right"><small>- {{ \App\Custom::showDateTime($item->created_at,'d M, y') }} </small></p>
                                <div class="clearfix"></div>
                            </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="clearfix"></div>
        <div class="white-box btn-list">
            <div class="row ">
                <div class="col-md-12">


                    <div class="col-md-2 col-xs-12 col-sm-6">
                        <a href="{{ url('member/provide-help-history') }}">
                            <div class="white-box text-center bg-info">
                                <i class="fa fa-usd fa-2x text-white"></i>
                                <p class="text-white">PH History</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-2 col-xs-12 col-sm-6">
                        <a href="{{ url('member/get-help-history') }}">
                            <div class="white-box text-center bg-warning">
                                <i class="fa fa-credit-card fa-2x text-white"></i>
                                <p class="text-white">GH History</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-2 col-xs-12 col-sm-6">
                        <a href="{{ url('member/my-downline') }}">
                            <div class="white-box text-center bg-danger">
                                <i class="fa fa-users fa-2x text-white"></i>
                                <p class="text-white">My Downline</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-2 col-xs-12 col-sm-6">
                        <a href="{{ url('member/inbox') }}">
                            <div class="white-box text-center bg-inverse">
                                <i class="fa fa-envelope-o fa-2x text-white"></i>
                                <p class="text-white">Message Box</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-2 col-xs-12 col-sm-6">
                        <a href="{{ url('member/add-member') }}">
                            <div class="white-box text-center bg-purple">
                                <i class="fa fa-user-plus fa-2x text-white"></i>
                                <p class="text-white">Register Member</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-2 col-xs-12 col-sm-6">
                        <a href="{{ url('member/change-password') }}">
                            <div class="white-box text-center bg-success">
                                <i class="fa fa-lock fa-2x text-white"></i>
                                <p class="text-white">Password</p>
                            </div>
                        </a>
                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-md-offset-2">

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>

</div>

@stop

@section('page_js')

<script type="text/javascript" src="{{ asset('/') }}/thirdparty/vticker/jquery.vticker.min.js"></script>

<script type="text/javascript">
$(function () {
    $('.change_avatar').click(function () {
        $('#avatar').trigger('click');
    });

    $('#avatar').change(function () {
        //alert('test');
        $('#change_avatar_form').submit();
    });

    $('#news-list').vTicker();

});
</script>
@stop