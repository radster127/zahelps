<?php
$pageTitle = "Compose Message";

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
                <div class="">
                    <a href="{{ url('member/compose-message') }}" class="btn btn-info btn-block waves-effect waves-light">Compose</a>
                    <div class="list-group mail-list m-t-20">
                        <a href="{{ url('member/inbox') }}" class="list-group-item">Inbox <span class="label label-rouded label-success pull-right">{{ $unreadCounter }}</span></a> 
                        <a href="{{ url('member/outbox') }}" class="list-group-item">Sent Mail</a> 
                    </div>
                </div>
            </div>
            <div class="col-lg-10 col-md-9 col-sm-8 col-xs-12 mail_listing ">
                @include('member.includes.formErrors')
                @include('member.includes.flashMsg')
                {!! Form::open(['method' => 'POST', 'url' => 'member/send-message']) !!}
                <h3 class="box-title">Compose New Message</h3>
                <div class="form-group">
                    {!! Form::label ('To:') !!}
                    {!! Form::text('to_id', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'To:', 'id' => 'to_id']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label ('Subject:') !!}
                    {!! Form::text('subject', null, ['class' => 'form-control', 'placeholder' => 'Subject:', 'required' => 'required']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label ('Message:') !!}
                    {!! Form::textarea('message', null, ['class' => 'textarea_editor form-control', 'rows' => 15, 'placeholder' => 'Your Message...']) !!}
                </div>

                <hr>
                <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
                <button class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
                {!! Form::close() !!}
            </div>
        </div>

    </div>
</div>


@stop

@section ('page_js')

<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('/') }}thirdparty/autocomplete/css/token-input-facebook.css" />
<script type="text/javascript" src="{{ asset('/') }}thirdparty/autocomplete/js/jquery.tokeninput.js"></script>

<script type="text/javascript">
$(function () {

    $("#to_id").tokenInput(
            '{{ url("member/get-users?current_user=no")}}', {
                queryParam: 'q',
                theme: "facebook",
                preventDuplicates: true,
                tokenLimit: 1,
            }
    );

});
</script>


<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
//tinymce.init({selector: '#content'});
tinymce.init({
    selector: '.textarea_editor',
    height: 250,
    menubar: false,
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code'
    ],
    toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
    content_css: '//www.tinymce.com/css/codepen.min.css'
});
</script>

@stop
