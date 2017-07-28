<?php

Use \App\Custom;

$pageTitle = 'My ' . $ph_settings['name'] . " Profit History";

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
            <th>{!! \App\Custom::getSortingLink($list_url, 'Date', 'tb_ph.created_at', $sortBy, $sortOrd, $searchBy, $searchByVal, $qs) !!}</th>
            <th>{{ $ph_settings['identity_called'] }}</th>
            <th>{!! \App\Custom::getSortingLink($list_url, $ph_settings['identity_called'] . ' Amount', 'tb_ph.amount', $sortBy, $sortOrd, $searchBy, $searchByVal, $qs) !!}</th>
            <th class="text-right">{!! \App\Custom::getSortingLink($list_url, 'Profit Percentage(%)', 'tb_ph.profit_per_day_percentage', $sortBy, $sortOrd, $searchBy, $searchByVal, $qs) !!}</th>
            <th class="text-right">{!! \App\Custom::getSortingLink($list_url, 'Profit Amount(' . $web_settings["currency_type"] . ')', 'tb_ph.amount', $sortBy, $sortOrd, $searchBy, $searchByVal, $qs) !!}</th>
        </tr>

        @if(isset($ph_list) && count($ph_list) > 0)
        @foreach($ph_list as $ph_item)
        <tr>
            <td>{{ Custom::showDateTime($ph_item->created_at, 'd M, Y') }}</td>
            <td>{{ $ph_settings['identity_called'] }} #{{ $ph_item->transaction_code }}</td>
            <td class="text-right">{{ number_format( $ph_item->amount ,2) }}</td>
            <td class="text-right">{{ number_format( $ph_item->profit_per_day_percentage * $ph_item->profit_day_counter ,2) }}</td>
            <td class="text-right">{{ number_format( ($ph_item->amount * $ph_item->profit_per_day_percentage / 100) * $ph_item->profit_day_counter ,2) }}</td>
        </tr>
        @endforeach
        @endif

    </table>


    <div class="pagination-area text-center">
        {!! $ph_list->appends($pageLinksParams)->render() !!}
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
});
</script>
@stop