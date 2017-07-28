<?php
$moduleSingularName = 'News';
$modulePluralName = 'News';

$pageTitle = "Create " . $moduleSingularName;
$module = 'news';
$store_url = route('admin.' . $module . '.store');
$list_url = route('admin.' . $module . ".index");

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

            {!! Form::open(['url' => $store_url, 'class' => 'module_form', 'files' => true, ]) !!}
            @include($form_file)
            {!! Form::close() !!}

        </div> <!-- end col -->
    </div>
    <!-- end row -->

</div>

@stop
