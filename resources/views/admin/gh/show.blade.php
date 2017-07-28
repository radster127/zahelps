<?php

use \App\Custom;

$moduleSingularName = $gh_settings['identity_called'];
$modulePluralName = $gh_settings['identity_called'];

$pageTitle = $modulePluralName . ' - ' . $gh_item->transaction_code . ' Detail';
$moduleTitle = $modulePluralName;
$module = 'gh';

$itemStatus = $gh_item->status;

$show_url = 'admin.' . $module . '.show';
$list_url = route( $module . ".index");

$breadCrumbArray = array(
    'Home' => url('admin'),
    $gh_settings['identity_called'] . ' List' => url('admin/gh'),
    $modulePluralName => '',
);
?>


@extends('admin.layout')

@section('title', $pageTitle)
@section('content')

@include('admin.includes.breadcrumb')
@include('admin.includes.flashMsg')

<div class="box box-block bg-white">

    <p class="text-xs-right">{{ $gh_settings['identity_called'] }} Created at : {{ $gh_item->created_at }}</p>

    <div class="table-responsive">


        <br/>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Transaction Code</th>
                    <th class="text-xs-right">Amount</th>
                    <th class="text-xs-right">Pending Amount</th>
                </tr>

            </thead>
            <tbody>
                <tr>
                    <td>{{ $gh_item->transaction_code }}</td>
                    <td class="text-xs-right">{{ $web_settings['currency_type'] }} {{ $gh_item->amount }}</td>
                    <td class="text-xs-right">{{ $web_settings['currency_type'] }} {{ $gh_item->pending_amount }}</td>
                </tr>
            </tbody>
        </table>

        <?php $user_information = json_decode($gh_item->user_information); ?>

        <table class = "table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="col-md-4">{{ $gh_settings['identity_called'] }} User Details</th>
                    <th class="col-md-4">Address Details</th>
                    <th class="col-md-4">Bank Details</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class = "col-md-4">
                        <p>
                            <b>Username:</b> {{ $user_information->username }}<br/>
                            <b>Name:</b> {{ $user_information->name }}<br/>
                            <b>Email:</b> {{ $user_information->email }}<br/>
                            <b>Contact Number:</b> {{ $user_information->phone }}<br/>
                        </p>
                        @if ($gh_item->user_id > 0)
                        @if ($gh_item->user->user_id > 0)
                        <h6><u>Referer</u></h6>
                        <p>
                            <b>Username:</b> {{ $gh_item->user->sponsor->username }}<br/>
                            <b>Name:</b> {{ $gh_item->user->sponsor->name }}<br/>
                            <b>Email:</b> {{ $gh_item->user->sponsor->email }}<br/>
                            <b>Contact Number:</b> {{ $gh_item->user->sponsor->phone }}<br/>
                        </p>
                        @endif
                        @endif
                    </td>
                    <td class="col-md-4">
                        <p>
                            <b>Address:</b> {{ $user_information->address }}<br/>
                            <b>City:</b> {{ $user_information->city }}<br/>
                            <b>Pincode:</b> {{ $user_information->pincode }}<br/>
                        </p>
                    </td>
                    <td class="col-md-4">
                        <p>
                            <b>Bank Name:</b> {{ $user_information->bank_name }}<br/>
                            <b>Bank Account Name:</b> {{ $user_information->bank_account_name }}<br/>
                            <b>Bank Account Number:</b> {{ $user_information->bank_account_number }}<br/>
                            <b>Bitcoin:</b> {{ $user_information->bitcoin }}<br/>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>

        <hr/>

        @if (count ($pairs) > 0)
        <h4>Pairs</h4>

        @foreach ($pairs as $pair_item)
        <table class="table">
            <tr>
                <th class="col-md-4">
                    Pair: {{ $pair_item->token }}
                    @if ($pair_item->status == 'paired')
                    <span class="tag tag-info">{{ ucwords($pair_item->status) }}</span>
                    @elseif($pair_item->status == 'approved')
                    <span class="tag tag-success">{{ ucwords($pair_item->status) }}</span>
                    @endif
                </th>
                <th class="col-md-4">
                    <b class="font-16">{{ $web_settings['currency_type'] }} {{ number_format($pair_item->amount,2) }}</b>
                </th>
                <th class="col-md-4">
                    @if ($pair_item->payment_type == 'expired')
                    <a href="javascript:;" class="btn btn-danger btn-block">Expired on Date: {{ Custom::showDateTime($pair_item->created_at, 'D j M Y h:i A') }}</a>
                    @elseif ($pair_item->payment_type == 'pending' && $pair_item->status == 'paired')
                    <a href="javascript:;" class="btn btn-danger btn-block">Expire on Date: {{ Custom::showDateTime($pair_item->created_at, 'D j M Y h:i A') }}</a>
                    @elseif ($pair_item->payment_type != 'pending' && $pair_item->status == 'paired')
                    <a href="javascript:;" class="btn btn-danger btn-block">Auto Approve on Date: {{ Custom::showDateTime($pair_item->auto_approved_on, 'D j M Y h:i A') }}</a>
                    @elseif ($pair_item->status == 'approved')
                    <a href="javascript:;" class="btn btn-info btn-block"><i class="fa fa-check"></i> Approved</a>
                    @endif
                </th>
            </tr>

            <tr>
                <td colspan="3">
                    <?php $user_information = json_decode($pair_item->PH->user_information); ?>

                    <table class = "table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="col-md-4">{{ $ph_settings['identity_called'] }} User Details</th>
                                <th class="col-md-4">Address Details</th>
                                <th class="col-md-4">Bank Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class = "col-md-4">
                                    <p>
                                        <b>Username:</b> {{ $user_information->username }}<br/>
                                        <b>Name:</b> {{ $user_information->name }}<br/>
                                        <b>Email:</b> {{ $user_information->email }}<br/>
                                        <b>Contact Number:</b> {{ $user_information->phone }}<br/>
                                    </p>
                                    @if ($pair_item->PH->user_id > 0)
                                    @if ($pair_item->PH->user->user_id > 0)
                                    <h6><u>Referer</u></h6>
                                    <p>
                                        <b>Username:</b> {{ $pair_item->PH->user->sponsor->username }}<br/>
                                        <b>Name:</b> {{ $pair_item->PH->user->sponsor->name }}<br/>
                                        <b>Email:</b> {{ $pair_item->PH->user->sponsor->email }}<br/>
                                        <b>Contact Number:</b> {{ $pair_item->PH->user->sponsor->phone }}<br/>
                                    </p>
                                    @endif
                                    @endif
                                </td>
                                <td class="col-md-4">
                                    <p>
                                        <b>Address:</b> {{ $user_information->address }}<br/>
                                        <b>City:</b> {{ $user_information->city }}<br/>
                                        <b>Pincode:</b> {{ $user_information->pincode }}<br/>
                                    </p>
                                </td>
                                <td class="col-md-4">
                                    <p>
                                        <b>Bank Name:</b> {{ $user_information->bank_name }}<br/>
                                        <b>Bank Account Name:</b> {{ $user_information->bank_account_name }}<br/>
                                        <b>Bank Account Number:</b> {{ $user_information->bank_account_number }}<br/>
                                        <b>Bitcoin:</b> {{ $user_information->bitcoin }}<br/>
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
        <hr/>
        @endforeach

        @endif

    </div>


</div>

@stop