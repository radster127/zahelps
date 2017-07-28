<?php
$pageTitle = "Outbox";

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
    <div class="white-box">
        <div class="row">
            <div class="col-lg-2 col-md-3  col-sm-12 col-xs-12 inbox-panel">

                <a href="{{ url('member/compose-message') }}" class="btn btn-info btn-block waves-effect waves-light">Compose</a>
                <div class="list-group mail-list m-t-20">
                    <a href="{{ url('member/inbox') }}" class="list-group-item ">Inbox <span class="label label-rouded label-success pull-right">{{ $unreadCounter }}</span></a> 
                    <a href="{{ url('member/outbox') }}" class="list-group-item active">Sent Mail</a> 
                </div>

            </div>
            <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12 mail_listing">
                <div class="inbox-center">
                    <table class="table table-hover table-striped inbox-table">
                        <tbody>
                            @if (count($messages) > 0)
                            @foreach ($messages as $message)
                            <tr class="{{ $message->is_read=='0' ? 'unread' : ''  }}">

                                <td class="text-center col-md-1">
                                    <a href="{{ route('message-detail', ['id' => $message->id]) }}">
                                        @if ($message->from->avatar != '')
                                        <img src="{{ asset('/') }}uploads/members/{{ $message->from_id }}/thumb_50X50_{{ $message->from->avatar }}" style="max-width: 28px;" />
                                        @else
                                        <img src="{{ asset('/') }}images/user.png" style="max-width: 28px;" />
                                        @endif
                                    </a>
                                </td>
                                <td class="col-md-2">
                                    <a href="{{ route('message-detail', ['id' => $message->id]) }}">{{ $message->from->username }}</a>
                                </td>
                                <td class="max-texts"><a href="{{ route('message-detail', ['id' => $message->id]) }}">{{ $message->subject }}</a></td>
                                <td class="text-right">{{ $message->created_at->diffForHumans() }}</td>

                            </tr>
                            @endforeach
                            @else
                        <th><h4 class="text-muted text-center">Sorry! No Messages...</h4></th>
                        @endif


                        </tbody>
                    </table>
                </div>
                <div class="pagination-area text-center">
                    {!! $messages->render() !!}
                </div>

            </div>
        </div>

    </div>
</div>


@stop
