<?php
$moduleSingularName = 'User';
$modulePluralName = 'Users';

$pageTitle = "Edit Profile";
$module = 'users';
$update_url = 'admin.' . $module . '.update';
$list_url = route('admin.' . $module . ".index");

$form_file = 'admin.' . $module . '.form';

$breadCrumbArray = array(
    'Home' => url('/'),
    $pageTitle => '',
);
?>

@extends('admin.layout')
@section('title', $pageTitle)

@section ('content')

@include('admin.includes.breadcrumb')
@include('admin.includes.flashMsg')


<div class="box box-block bg-white">

    <!-- end row -->

    <div class="row">
        <div class="col-sm-12">
            @include('admin.includes.formErrors')

            {!! Form::model($formObj, ['method' => 'POST', 'url' => 'admin/update-profile', 'class' => 'module_form', 'files' => true,]) !!}
            @include($form_file)
            {!! Form::close() !!}

        </div> <!-- end col -->
    </div>
    <!-- end row -->





</div>

@stop
