<?php

use \App\Custom;

$moduleSingularName = 'Letter Of Happiness';
$modulePluralName = 'Letters Of Happiness';

$pageTitle = "Manage " . $modulePluralName;
$moduleTitle = $modulePluralName;
$module = 'letter-of-happiness';

//$add_url = route('admin.' . $module . '.create');
$edit_url = $module . '.edit';
$delete_url = $module . '.destroy';
$list_url = route( $module . ".index");

$breadCrumbArray = array(
    'Home' => url('admin'),
    $modulePluralName => '',
);

$sortBy = $list_params['sort_by'];
$sortOrd = $list_params['sort_order'];
$searchBy = $list_params['search_field'];
$searchByVal = $list_params['search_text'];
$from_date = $list_params['from_date'];
$to_date = $list_params['to_date'];
$record_per_page = 1;

$qs = "from_date=" . $from_date . "&to_date=" . $to_date . "&record_per_page=" . $record_per_page;

$rows->setPath($list_url);

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


@extends('admin.layout')

@section('title', $pageTitle)

@section('content')

@include('admin.includes.breadcrumb')
@include('admin.includes.flashMsg')


@include('admin.includes.searchForm')


<div class="box box-block bg-white">


    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="col-md-8">{!! \App\Custom::getSortingLink($list_url, 'Subject/Title', 'testimonials.title', $sortBy, $sortOrd, $searchBy, $searchByVal, $qs) !!}</th>
                    <th class="col-md-2">{!! \App\Custom::getSortingLink($list_url, 'Status', 'testimonials.status', $sortBy, $sortOrd, $searchBy, $searchByVal, $qs) !!}</th>
                    <th class="col-md-2">Action</th>
                </tr>
            </thead>


            <tbody>
                @if(isset($rows) && count($rows) > 0)
                @foreach($rows as $row)
                <tr>

                    <td class="col-md-8">{{ $row->title }}</td>
                    <td class="col-md-2">{{ ucfirst($row->status) }}</td>
                    <td class="col-md-2">
                        <div class="btn-group btn-group-solid">
                            <a title="Edit {{ $moduleSingularName }}" href="{{ route($edit_url, ['id' => $row->id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                            <a title="Delete {{ $moduleSingularName }}" href="{{ route($delete_url,array('id' => $row->id))}}" class="btn btn-danger delete_btn btn-sm" data-id="{{ $row->id }}"><i class="fa fa-trash"></i></a>
                        </div>
                    </td>

                </tr>
                @endforeach 
                @else
                <tr>
                    <td colspan="3">No Records Found.</td>
                </tr>                    
                @endif

            </tbody>

        </table>


        <div class="pagination-area text-center">
            {!! $rows->appends($pageLinksParams)->render() !!}
        </div>
    </div>  


</div>


{!! Form::open(['method' => 'delete','id' => 'global_delete_form']) !!}
{!! Form::hidden('id', 0,['id' => 'row_id']) !!}
{!! Form::close() !!}

@stop