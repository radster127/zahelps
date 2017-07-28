<?php
$moduleSingularName = 'GH';
$modulePluralName = 'GH';

$pageTitle = "Create GH Manual";
$module = 'gh';
$store_url = route( $module . '.store');
$list_url = route( $module . ".index");

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

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('Member') !!}
                        {!! Form::text('user_id', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Member', 'id' => 'user_id']) !!}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('Amount') !!}
                        <?php $options = explode(',', $gh_settings['packed']); ?>
                        {!! Form::select('amount', array_combine($options, $options), null, ['class' => 'form-control', 'placeholder' => 'Select Amount', 'required' => 'required']) !!}
                    </div>
                </div>
            </div>

            <hr/>

            <button type="submit" class="btn btn-info pull-right waves-effect waves-light">Submit</button>


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

    $("#user_id").tokenInput(
            '{{ url("member/get-users")}}', {
                theme: "facebook",
                preventDuplicates: true,
                tokenLimit: 1,
            }
    );


});

</script>

@stop