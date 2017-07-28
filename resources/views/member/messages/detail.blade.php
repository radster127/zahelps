<?php
$pageTitle = $message->subject;

$breadCrumbArray = array(
    'Home' => url('/member'),
    $pageTitle => '',
);
?>
@extends('member.layout')

@section('title', $pageTitle)
@section('content')
@include('member.includes.breadcrumb')

<div class="col-md-12">

    <div class="row">
        <div class="col-lg-2 col-md-3  col-sm-12 col-xs-12 inbox-panel">
            <a href="{{ url('member/compose-message') }}" class="btn btn-info btn-block waves-effect waves-light">Compose</a>
            <div class="list-group mail-list m-t-20">
                <a href="{{ url('member/inbox') }}" class="list-group-item active">Inbox <span class="label label-rouded label-success pull-right">{{ $unreadCounter }}</span></a> 
                <a href="{{ url('member/outbox') }}" class="list-group-item">Sent Mail</a> 
            </div>
        </div>

        <div class="col-lg-10 col-md-9 col-sm-8 col-xs-12 mail_listing">
            <div class="media m-b-30 p-t-20">
                <h4 class="font-bold m-t-0">
                    {{ $message->subject }}
                    <span class="media-meta pull-right text-muted">{{ $message->created_at->diffForHumans() }}</span>
                </h4>
                <hr>
                <div class="row">
                    <div class="col-lg-6">
                        <h5>From</h5>
                        <a class="pull-left" href="#">
                            @if ($message->from->avatar != '')
                            <img src="{{ asset('/') }}uploads/members/{{ $message->from_id }}/thumb_50X50_{{ $message->from->avatar }}" class="media-object thumb-sm img-circle" />
                            @else
                            <img src="{{ asset('/') }}images/user.png" class="media-object thumb-sm img-circle" />
                            @endif
                        </a>
                        <div class="media-body"> 
                            <h4 class="text-danger m-0">{{ $message->from->username }}</h4>
                            <small class="text-muted">From: {{ $message->from->email }}</small> 
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h5>To</h5>
                        <a class="pull-left" href="#">
                            @if ($message->to->avatar != '')
                            <img src="{{ asset('/') }}uploads/members/{{ $message->to_id }}/thumb_50X50_{{ $message->to->avatar }}" class="media-object thumb-sm img-circle" />
                            @else
                            <img src="{{ asset('/') }}images/user.png" class="media-object thumb-sm img-circle" />
                            @endif
                        </a>
                        <div class="media-body"> 
                            <h4 class="text-danger m-0">{{ $message->to->username }}</h4>
                            <small class="text-muted">To: jonathan@domain.com</small> 
                        </div>
                    </div>
                </div>


                <hr/>
                {!! $message->message !!}
            </div>

            <hr/>
            <div class="b-all p-20">
                <p>click here to <a href="{{ url('member/compose-message') }}">Reply</a></p>
            </div>
        </div>

    </div>

</div>


@stop
