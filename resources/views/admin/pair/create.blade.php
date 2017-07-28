<?php
$moduleSingularName = 'Pair';
$modulePluralName = 'Pair';

$pageTitle = "Create " . $moduleSingularName;
$module = 'pair';
$store_url = url('admin.' . $module . '.store');
$list_url = url('admin.' . $module . ".index");

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


@section ('page_js')

<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('/') }}/thirdparty/autocomplete/css/token-input-facebook.css" />
<script type="text/javascript" src="{{ asset('/') }}/thirdparty/autocomplete/js/jquery.tokeninput.js"></script>

<script type="text/javascript">

$(function () {

    $("#gh_user_id").tokenInput(
            '{{ url("member/get-users")}}', {
                theme: "facebook",
                preventDuplicates: true,
                tokenLimit: 1,
                resultsLimit: 10
            }
    );
    $("#ph_user_id").tokenInput(
            '{{ url("member/get-users")}}', {
                theme: "facebook",
                preventDuplicates: true,
                tokenLimit: 1,
                resultsLimit: 10
            }
    );


});

</script>

@stop