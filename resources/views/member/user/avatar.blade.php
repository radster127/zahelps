<?php
$pageTitle = "Change Avatar";

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
    <div class="col-md-4 col-md-offset-4">

        <div class="white-box">


            {!! Form::open(['url' => url('member/update-avatar'), 'class' => 'module_form', 'files' => true]) !!}

            <div class="form-body">
                <h3 class="box-title">{{ $pageTitle }}</h3>
                <hr>

                @include('member.includes.formErrors')
                @include('member.includes.flashMsg')

                <div class="row">
                    <div class="col-md-12">

                        <div class="form-group">
                            <label class="control-label">Avatar Image</label>
                            <div class="input-group">
                                {!! Form::file('avatar', ['class' => 'form-control', 'placeholder' => 'Enter old password', 'required' => 'required']) !!}
                                <div class="input-group-addon"><i class="ti-image"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions text-right">
                        <button type="submit" class="btn btn-lg btn-success"> <i class="fa fa-check"></i> Change Avatar</button>
                    </div>
                </div>



                {!! Form::close() !!}

            </div>  
        </div>
    </div>
</div>

@stop