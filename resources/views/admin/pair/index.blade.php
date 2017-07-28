<?php

use \App\Custom;

$moduleSingularName = 'Pair';
$modulePluralName = 'Pair';

$pageTitle = "Manage " . $modulePluralName;
$moduleTitle = $modulePluralName;
$module = 'pair';

$add_url = route(  $module . '.create');
$show_url = 'admin.' . $module . '.show';
$delete_url = 'admin.' . $module . '.destroy';
$list_url = 'admin.' . $module . ".index";

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
                    <th>Token</th>
                    <th>{!! \App\Custom::getSortingLink($list_url, 'PH Code', 'ph_user.username', $sortBy, $sortOrd, $searchBy, $searchByVal, $qs) !!}</th>
                    <th>{!! \App\Custom::getSortingLink($list_url, 'GH Code', 'gh_user.username', $sortBy, $sortOrd, $searchBy, $searchByVal, $qs) !!}</th>
                    <th>{!! \App\Custom::getSortingLink($list_url, 'Amount (' . $web_settings['currency_type']. ')', 'tb_pair.amount', $sortBy, $sortOrd, $searchBy, $searchByVal, $qs) !!}</th>
                    <th>{!! \App\Custom::getSortingLink($list_url, 'Date', 'tb_pair.created_at', $sortBy, $sortOrd, $searchBy, $searchByVal, $qs) !!}</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>


            <tbody>
                @if(isset($rows) && count($rows) > 0)
                @foreach($rows as $row)
                <tr>
                    <td>
                        {{ $row->token }}
                        @if ($row->admin_generated == '1')
                        <br/><span class="tag tag-warning">Admin Generated</span>
                        @endif
                    </td>
                    <td>
                        {{ $row->PH->transaction_code }}<br/>
                        @if ($row->PH->user_id > 0)
                        <b>User: </b>{{ $row->PH->user->username }}
                        @endif
                    </td>
                    <td>
                        {{ $row->GH->transaction_code }}<br/>
                        @if ($row->GH->user_id > 0)
                        <b>User: </b>{{ $row->GH->user->username }}
                        @endif
                    </td>

                    <td>{{ number_format($row->amount,2) }}</td>
                    <td>{{ Custom::showDateTime($row->created_at, 'd-m-Y H:i') }}</td>
                    <td>
                        @if ($row->status == 'pending')
                        <span class="tag tag-danger">{{ ucwords($row->status) }}</span>
                        @elseif ($row->status == 'paired')
                        <span class="tag tag-info">{{ ucwords($row->status) }}</span>
                        @elseif ($row->status == 'approved')
                        <span class="tag tag-success">{{ ucwords($row->status) }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group btn-group-solid">
                            <a data-target=".bs-example-modal-lg-{{ $row->id }}"  data-toggle="modal" title="{{ $moduleSingularName }} Detail" href="javascript:;" class="btn btn-primary btn-sm"><i class="fa fa-list"></i></a>
                            @if ($row->payment_type == 'pending' && $row->status == 'paired')
                            <a title="Delete {{ $moduleSingularName }}" href="{{ route($delete_url,array('id' => $row->id))}}" class="btn btn-danger delete_btn btn-sm" data-id="{{ $row->id }}"><i class="fa fa-trash"></i></a>
                            @endif



                            <?php $pair_item = $row ?>

                            <div class="modal fade bs-example-modal-lg-{{ $row->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h5 class="modal-title" id="myLargeModalLabel">Pair Information: #{{ $row->token }}

                                                @if ($pair_item->status == 'paired')
                                                <span class="tag tag-info">{{ ucwords($pair_item->status) }}</span>
                                                @elseif($pair_item->status == 'approved')
                                                <span class="tag tag-success">{{ ucwords($pair_item->status) }}</span>
                                                @endif

                                                &nbsp;
                                                @if ($pair_item->admin_generated == '1')
                                                <span class="tag tag-warning">Admin Generated</span>
                                                @endif

                                            </h5>



                                        </div>
                                        <div class="modal-body">



                                            <table class="table">
                                                <tr>
                                                    <th class="col-md-6">
                                                        Pair: {{ $pair_item->token }}

                                                    </th>
                                                    <th class="col-md-6">
                                                        <b class="font-16">{{ $web_settings['currency_type'] }} {{ number_format($pair_item->amount,2) }}</b>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th class="col-md-6">
                                                        <a href="javascript:;" class="btn btn-info btn-block">Generated Date: {{ Custom::showDateTime($pair_item->created_at, 'D j M Y h:i A') }}</a>
                                                    </th>
                                                    <th class="col-md-6">
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
                                            </table>

                                            <table class="table">
                                                <tr>
                                                    <td>
                                                        <?php $user_information = json_decode($pair_item->GH->user_information); ?>
                                                        <table class = "table">
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

                                                <tr>
                                                    <td >
                                                        <?php $user_information = json_decode($pair_item->PH->user_information); ?>
                                                        <table class="table">
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
                    <td colspan="9">No Records Found.</td>
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


@section('page_js')
<script type="text/javascript">
  $(function () {

      $('.freeze_btn').click(function () {
          var $id = $(this).data('id');
          var $btn = $(this);
          $.ajax({
              url: $(this).attr('href'),
              type: 'post',
              data: {'_token': "{{ csrf_token() }}", id: $id},
              success: function (data) {
                  if (data.status == '0') {
                      alert(data.message);
                  } else {
                      if (data.freeze_status == '0') {
                          $btn.removeClass('btn-success').addClass('btn-warning');
                          $btn.find('i').removeClass('fa-unlock').addClass('fa-lock');
                          $btn.closest('tr').find('.freezed').addClass('hide');
                      } else {
                          $btn.removeClass('btn-warning').addClass('btn-success');
                          $btn.find('i').removeClass('fa-lock').addClass('fa-unlock');
                          $btn.closest('tr').find('.freezed').removeClass('hide');
                      }
                      //alert(data.message);
                  }
              },
              error: function (data) {
                  alert('error');
              }
          });
          return false;
      });

  });
</script>
@stop