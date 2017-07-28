<?php
$pageTitle = "Outbox";

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



        <div class="box bg-white">
            <div class="col-md-12">

                <table class="table mail-items mb-0">
                    <tbody>
                        @if (count($messages) > 0)
                        @foreach ($messages as $message)

                        <tr class="{{ $message->is_read=='0' ? 'unread' : 'unread'  }}">
                            <td class="mail-item-sender">

                                <a class="avatar box-32 mr-0-5" href="{{ route('admin-message-detail', ['id' => $message->id]) }}">
                                    @if ($message->from->avatar != '')
                                    <img class="b-a-radius-circle" src="{{ asset('/') }}uploads/members/{{ $message->from_id }}/thumb_50X50_{{ $message->from->avatar }}" style="max-width: 28px;" />
                                    @else
                                    <img class="b-a-radius-circle" src="{{ asset('/') }}images/user.png" style="max-width: 28px;" />
                                    @endif
                                </a>
                                <a href="{{ route('admin-message-detail', ['id' => $message->id]) }}">{{ $message->from->username }}</a>
                            </td>
                            <td>
                                <a href="{{ route('admin-message-detail', ['id' => $message->id]) }}">{{ $message->subject }}</a>
                            </td>

                            <td class="mail-item-time">
                                {{ $message->created_at->diffForHumans() }}
                            </td>

                        </tr>




                        @endforeach
                        @endif

                    </tbody>
                </table>


                <div class="clearfix"></div>
                <div class="pagination-area text-center">
                    {!! $messages->render() !!}
                </div>
                <div class="clearfix"></div>
            </div>



            <div class="clearfix"></div>
        </div>




    </div>
</div>

@stop
@section('page_js')

@stop