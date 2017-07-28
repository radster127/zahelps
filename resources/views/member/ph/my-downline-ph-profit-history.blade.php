<?php

Use \App\Custom;

$pageTitle = 'My Downline ' . $ph_settings['name'] . " Profit History";

$breadCrumbArray = array(
    'Home' => url('/member'),
    $pageTitle => '',
);

$list_url = url('member/my-ph-profit-history');

$sortBy = $list_params['sort_by'];
$sortOrd = $list_params['sort_order'];
$searchBy = $list_params['search_field'];
$searchByVal = $list_params['search_text'];
$from_date = $list_params['from_date'];
$to_date = $list_params['to_date'];
$record_per_page = 1;


$qs = "from_date=" . $from_date . "&to_date=" . $to_date . "&record_per_page=" . $record_per_page;

$pageLinksParams = [
    'sortBy' => $sortBy,
    'sortOrd' => $sortOrd,
    'search_field' => $searchBy,
    'search_text' => $searchByVal,
    'from_date' => $from_date,
    'to_date' => $to_date,
    'record_per_page' => $record_per_page,
];
?>
@extends('member.layout')

@section('title', $pageTitle)
@section('content')
@include('member.includes.breadcrumb')

<div class="col-md-12">

    @include('member.includes.searchForm')

    <table class="table table-bordered">
        <tr>
            <th>{!! \App\Custom::getSortingLink($list_url, 'Date', 'ph_profit_history.created_at', $sortBy, $sortOrd, $searchBy, $searchByVal, $qs) !!}</th>
            <th>{{ $ph_settings['identity_called'] }}</th>
            <th>{{ $ph_settings['identity_called'] . ' Member' }}</th>
            <th class="text-right">{!! \App\Custom::getSortingLink($list_url, 'Level', 'ph_profit_history.level_number', $sortBy, $sortOrd, $searchBy, $searchByVal, $qs) !!}</th>
            <th class="text-right">{!! \App\Custom::getSortingLink($list_url, 'Profit Percentage(%)', 'ph_profit_history.profit_percentage', $sortBy, $sortOrd, $searchBy, $searchByVal, $qs) !!}</th>
            <th class="text-right">{!! \App\Custom::getSortingLink($list_url, 'Profit Amount(' . $web_settings["currency_type"] . ')', 'ph_profit_history.profit_amount', $sortBy, $sortOrd, $searchBy, $searchByVal, $qs) !!}</th>
        </tr>

        @if(isset($profits) && count($profits) > 0)
        @foreach($profits as $profit)
        <tr>
            <td>{{ Custom::showDateTime($profit->created_at, 'd M, Y') }}</td>
            <td>{{ $ph_settings['identity_called'] }} #{{ $profit->PH->transaction_code }}</td>
            <td>
                @if ($profit->PH->user_id > 0)
                {{ $profit->PH->user->username }}
                @endif
            </td>
            <td class="text-right">{{ $profit->level_number }}</td>
            <td class="text-right">{{ $profit->profit_percentage }}</td>
            <td class="text-right">{{ $profit->profit_amount }}</td>
        </tr>
        @endforeach
        @endif

    </table>


    <div class="pagination-area text-center">
        {!! $profits->appends($pageLinksParams)->render() !!}
    </div>
</div>

@stop


@section ('page_js')
<!-- Date picker plugins css -->
<link href="{{ asset('/') }}themes/eliteadmin/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<!-- Date Picker Plugin JavaScript -->
<script src="{{ asset('/') }}themes/eliteadmin/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>

<script type="text/javascript">
$(function () {
    $('#start_date, #end_date').datepicker();
    $('.btn-reset').click(function () {
        $(this).closest('form')[0].reset();
    })
});
</script>
@stop