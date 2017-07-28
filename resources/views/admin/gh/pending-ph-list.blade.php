<?php

use \App\Custom;

$moduleSingularName = 'GH';
$modulePluralName = 'GH';

$pageTitle = "Make Pair " . $modulePluralName;
$moduleTitle = $modulePluralName;
$module = 'gh';

$show_url = 'admin.' . $module . '.show';
$delete_url = 'admin.' . $module . '.destroy';
$make_pair_url = 'admin-make-manual-pair';
$pending_ph_list_url = url('admin/' . $module . '/pending/' . $gh_item->id);

$breadCrumbArray = array(
    'Home' => url('admin'),
    $modulePluralName => url('admin/gh'),
    $pageTitle => ''
);


$sortBy = $list_params['sort_by'];
$sortOrd = $list_params['sort_order'];
$searchBy = $list_params['search_field'];
$searchByVal = $list_params['search_text'];
$from_date = $list_params['from_date'];
$to_date = $list_params['to_date'];
$record_per_page = 1;

$qs = "from_date=" . $from_date . "&to_date=" . $to_date . "&record_per_page=" . $record_per_page;

$rows->setPath($pending_ph_list_url);

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



<div class="box box-block bg-white">


    <div class="table-responsive">
        <h4>GH Details</h4>
        <table class="table table-bordered table-striped">
            <tr>
                <th>Code</th>
                <th>User</th>
                <th>Amount</th>
                <th>Pending Amount</th>
                <th>Date</th>
            </tr>
            <tr>
                <td>{{ $gh_item->transaction_code }}</td>
                <td>
                    @if ($gh_item->user_id > 0)
                    {{ $gh_item->user->username }}
                    @endif
                </td>
                <td>{{ $gh_item->amount }}</td>
                <td>{{ $gh_item->pending_amount }}</td>
                <td>{{ Custom::showDateTime($gh_item->created_at, 'd-m-Y H:i') }}</td>
            </tr>
        </table>
    </div>

    <div class="table-responsive">
        <h4>Pending PH List</h4>
        <p class="text-xs-right"><b>Total Rows: {{ $rows->total() }}</b></p>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>PH User</th>
                    <th>PH Amount ({{ $web_settings['currency_type'] }})</th>
                    <th>PH Pending Amount ({{ $web_settings['currency_type'] }})</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>


            <tbody>
                @if(isset($rows) && count($rows) > 0)
                @foreach($rows as $row)
                <tr>
                    <td>{{ $row->transaction_code }}</td>
                    <td>
                        @if ($row->user_id > 0)
                        {{ $row->user->username }}
                        @endif</td>
                    <td>{{ $row->amount }}</td>
                    <td>{{ $row->pending_amount }}</td>
                    <td>{{ Custom::showDateTime($row->created_at, 'd-m-Y H:i') }}</td>
                    <td>
                        @if ($row->status == 'pending')
                        <span class="tag tag-danger">{{ ucwords($row->status) }}</span>
                        @elseif ($row->status == 'paired')
                        <span class="tag tag-info">{{ ucwords($row->status) }}</span>
                        @elseif ($row->status == 'frozen')
                        <span class="tag tag-warning">{{ ucwords($row->status) }}</span>
                        @elseif ($row->status == 'approved')
                        <span class="tag tag-success">{{ ucwords($row->status) }}</span>
                        @endif

                        <span class="tag freezed {{ $row->is_freeze == '1' ? '' : 'hide' }} tag-warning">Freezed</span>
                    </td>
                    <td>
                        <div class="btn-group btn-group-solid">
                            <a title="Make Pair" onclick="return confirm('Are you sure you want to pair this requests?')" href="{{ route($make_pair_url,array('gh_id' => $gh_item->id ,'ph_id' => $row->id,))}}" class="btn btn-info btn-sm" data-id="{{ $row->id }}"><i class="fa fa-hand-peace-o"></i></a>
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