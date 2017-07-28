<?php
$pageTitle = "Letter of Happiness";

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


            {!! Form::open(['url' => url('member/letter-of-happiness'), 'class' => 'module_form']) !!}

            <div class="form-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Subject/Title</label>
                            {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter Subject/Title', 'required' => 'required']) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Content/Message</label>
                            {!! Form::textarea('content', null, ['class' => 'form-control', 'placeholder' => 'Enter Content/Message', 'required' => 'required']) !!}
                        </div>
                    </div>
                </div>

            </div>
            <hr/>
            <div class="form-actions text-right">
                <button type="submit" class="btn btn-lg btn-success">Submit</button>
            </div>

            {!! Form::close() !!}

        </div>  
    </div>
</div>

@stop

@section('page_js')

@stop