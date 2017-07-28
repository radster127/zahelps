<?php
$moduleSingularName = 'Letter Of Happiness';
$modulePluralName = 'Letters Of Happiness';

$pageTitle = "Edit " . $moduleSingularName;
$module = 'letter-of-happiness';
$update_url = $module . '.update';
$list_url = route( $module . ".index");

$form_file = 'admin.' . $module . '.form';

$breadCrumbArray = array(
    'Home' => url('/'),
    $modulePluralName => $list_url,
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

            {!! Form::model($formObj, ['method' => 'PUT', 'route' => [$update_url, $formObj->id], 'class' => 'module_form', 'files' => true,]) !!}
            @include($form_file)
            {!! Form::close() !!}

        </div> <!-- end col -->
    </div>
    <!-- end row -->





</div>

@stop
