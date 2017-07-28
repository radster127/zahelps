<?php
$pageTitle = 'Message Detail';

$breadCrumbArray = array(
    'Home' => url('admin'),
    $pageTitle => '',
);
?>
@extends('admin.layout')

@section('title', $pageTitle)
@section('content')
@include('admin.includes.breadcrumb')

<div class="row row-md mb-2">
    <div class="col-md-12">


        <div class="mb-1">
            <div class="clearfix">
                <a href="{{ url('admin/compose-message') }}" class="btn btn-success pull-right mr-0-5 label-left waves-effect waves-light">
                    <span class="btn-label"><i class="ti-pencil"></i></span>
                    Compose
                </a>
            </div>
        </div>



        <div class="box box-block bg-white">
            <div class="row">
                <div class="col-lg-12 mail_listing">
                    <div class="media m-b-30 p-t-20">
                        <h4 class="font-bold m-t-0">
                            {{ $message->subject }}
                            <span class="media-meta pull-right text-muted">{{ $message->created_at->diffForHumans() }}</span>
                        </h4>
                        <hr>
                        <div class="col-lg-6">
                            <h5>From</h5>
                            <div class="row">
                                <div class="col-md-1">
                                    <a class="pull-left" href="#">
                                        @if ($message->from->avatar != '')
                                        <img src="{{ asset('/') }}uploads/members/{{ $message->from_id }}/thumb_50X50_{{ $message->from->avatar }}" class="media-object thumb-sm img-circle" style="max-width: 36px;" />
                                        @else
                                        <img src="{{ asset('/') }}images/user.png" class="media-object thumb-sm img-circle" style="max-width: 36px;" />
                                        @endif
                                    </a>
                                </div>
                                <div class="col-md-11">
                                    <div class="media-body"> 
                                        <h5 class="text-danger m-0">{{ $message->from->username }}</h5>
                                        <small class="text-muted">From: {{ $message->from->email }}</small> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h5>To</h5>
                            <div class="row">

                                <div class="col-md-1">
                                    <a class="pull-left" href="#">
                                        @if ($message->to->avatar != '')
                                        <img src="{{ asset('/') }}uploads/members/{{ $message->to_id }}/thumb_50X50_{{ $message->to->avatar }}" class="media-object thumb-sm img-circle" style="max-width: 36px;" />
                                        @else
                                        <img src="{{ asset('/') }}images/user.png" class="media-object thumb-sm img-circle" style="max-width: 36px;" />
                                        @endif
                                    </a>
                                </div>
                                <div class="col-md-11">
                                    <div class="media-body"> 
                                        <h5 class="text-danger m-0">{{ $message->to->username }}</h5>
                                        <small class="text-muted">To: jonathan@domain.com</small> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <hr/>
                        <b>Message:</b><br/>
                        {!! $message->message !!}
                    </div>



                </div>
            </div>

            <div class="clearfix"></div>
        </div>




    </div>
</div>

@stop
@section('page_js')

@stop