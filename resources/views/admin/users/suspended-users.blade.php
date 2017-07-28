<?php

use \App\Custom;

$moduleSingularName = 'User';
$modulePluralName = 'Users';

$pageTitle = "Manage Suspended " . $modulePluralName;
$moduleTitle = $modulePluralName;
$module = 'users';

//$add_url = route('admin.' . $module . '.create');
$edit_url =  $module . '.edit';
$suspend_url = 'admin.' . $module . '.suspend';
$delete_url = 'admin.' . $module . '.destroy';
$list_url = url('admin/' . $module . "/suspended-users");

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
        <p class="text-xs-right"><b>Total Rows: {{ $rows->total() }}</b></p>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>{!! \App\Custom::getSortingLink($list_url, 'Username', 'users.username', $sortBy, $sortOrd, $searchBy, $searchByVal, $qs) !!}</th>
                    <th>{!! \App\Custom::getSortingLink($list_url, 'Full name', 'users.name', $sortBy, $sortOrd, $searchBy, $searchByVal, $qs) !!}</th>
                    <th>{!! \App\Custom::getSortingLink($list_url, 'Email', 'users.email', $sortBy, $sortOrd, $searchBy, $searchByVal, $qs) !!}</th>
                    <th>{!! \App\Custom::getSortingLink($list_url, 'Account Balance', 'users.account_balance', $sortBy, $sortOrd, $searchBy, $searchByVal, $qs) !!}</th>
                    <th>{!! \App\Custom::getSortingLink($list_url, 'Joining Date', 'users.joining_datetime', $sortBy, $sortOrd, $searchBy, $searchByVal, $qs) !!}</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>


            <tbody>
                @if(isset($rows) && count($rows) > 0)
                @foreach($rows as $row)
                <tr>

                    <td>{{ $row->username }}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->email }}</td>
                    <td>${{ $row->account_balance }}</td>
                    <td>{{ Custom::showDateTime($row->created_at, 'd-m-Y H:i') }}</td>
                    <td>
                        @if ($row->status == 'active')
                        <span class="tag tag-primary">{{ ucfirst($row->status) }}</span>
                        @else
                        <span class="tag tag-danger">{{ ucfirst($row->status) }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group btn-group-solid">
                            <a title="Edit {{ $moduleSingularName }}" href="{{ route($edit_url, ['id' => $row->id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                            <a onclick="confirm('Are you sure to unsuspend this user?')" title="Unsuspend {{ $moduleSingularName }}" href="{{ route('unsuspend-user', ['id' => $row->id]) }}" class="btn btn-success btn-sm"><i class="fa fa-heart"></i></a>
                            <a title="View {{ $moduleSingularName }}" href="javascript:;" class="btn btn-info btn-sm" data-target=".bs-example-modal-lg-{{ $row->id }}"  data-toggle="modal"><i class="fa fa-list"></i></a>

                            <div class="modal fade bs-example-modal-lg-{{ $row->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h5 class="modal-title" id="myLargeModalLabel">{{ $row->name }} Information</h5>
                                        </div>
                                        <div class="modal-body">

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <table class="table table-striped table-hover table-bordered">
                                                        <tr>
                                                            <th colspan="2">Personal Information</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Username</td>
                                                            <td>{{ $row->username }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Fullname</td>
                                                            <td>{{ $row->name }}</td>
                                                        </tr>

                                                        <tr>
                                                            <td>Sponsor</td>
                                                            <td>{{ $row->user_id > 0 ? $row->sponsor->username : '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Joining Date</td>
                                                            <td>{{ Custom::showDateTime($row->created_at, 'd-m-Y H:i') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Last Login</td>
                                                            <td>{{ Custom::showDateTime($row->last_login_datetime, 'd-m-Y H:i') }}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-md-6">
                                                    <table class="table table-striped table-hover table-bordered">

                                                        <tr>
                                                            <th colspan="2">Contact & Address Information</th>
                                                        </tr>

                                                        <tr>
                                                            <td>Address</td>
                                                            <td>{{ $row->address }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>City</td>
                                                            <td>{{ $row->city }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Postal Code</td>
                                                            <td>{{ $row->pincode }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Country</td>
                                                            <td>{{ $row->country_id > 0 ? $row->country->country_name : '' }}</td>
                                                        </tr>

                                                        <tr>
                                                            <td>Email</td>
                                                            <td>{{ $row->email }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Mobile</td>
                                                            <td>{{ $row->phone }}</td>
                                                        </tr>



                                                    </table>
                                                </div>
                                            </div>
                                            <div class="clearfix">&nbsp;</div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <table class="table table-striped table-hover table-bordered">
                                                        <tr>
                                                            <th colspan="2">Bank Information</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Bank Name</td>
                                                            <td>{{ $row->bank_name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Bank Account Number</td>
                                                            <td>{{ $row->bank_account_number }}</td>
                                                        </tr>

                                                        <tr>
                                                            <td>Bank Account Name</td>
                                                            <td>{{ $row->bank_account_name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Bitcoin Address</td>
                                                            <td>{{ $row->bitcoin }}</td>
                                                        </tr>

                                                    </table>
                                                </div>
                                                <div class="col-md-6">
                                                    <table class="table table-striped table-hover table-bordered">

                                                        <tr>
                                                            <th colspan="2">Transaction Information</th>
                                                        </tr>

                                                        <tr>
                                                            <td>Total PH</td>
                                                            <td>$0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Total GH</td>
                                                            <td>$0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Total Fee</td>
                                                            <td>$0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Total Ticket</td>
                                                            <td>0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Total Referal</td>
                                                            <td>0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Account Balance</td>
                                                            <td>$0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Profit Balance</td>
                                                            <td>$0</td>
                                                        </tr>
                                                    </table>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>


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