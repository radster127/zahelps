<?php

use \App\Custom;

$moduleSingularName = 'GH';
$modulePluralName = 'GH';

$pageTitle = "Manage " . $modulePluralName;
$moduleTitle = $modulePluralName;
$module = 'gh';

$show_url =  $module . '.show';
$delete_url =  $module . '.destroy';
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
        <p class="text-xs-right"><b>Total Rows: {{ $rows->total() }}</b></p>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>{!! \App\Custom::getSortingLink($list_url, 'GH User', 'users.username', $sortBy, $sortOrd, $searchBy, $searchByVal, $qs) !!}</th>
                    <th>{!! \App\Custom::getSortingLink($list_url, 'Amount (' . $web_settings['currency_type']. ')', 'tb_gh.amount', $sortBy, $sortOrd, $searchBy, $searchByVal, $qs) !!}</th>
                    <th>{!! \App\Custom::getSortingLink($list_url, 'Pending Amount (' . $web_settings['currency_type']. ')', 'tb_gh.pending_amount', $sortBy, $sortOrd, $searchBy, $searchByVal, $qs) !!}</th>
                    <th>{!! \App\Custom::getSortingLink($list_url, 'Date', 'tb_gh.created_at', $sortBy, $sortOrd, $searchBy, $searchByVal, $qs) !!}</th>
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
                        @endif
                    </td>
                    <td>{{ number_format($row->amount,2) }}</td>
                    <td>{{ number_format($row->pending_amount,2) }}</td>
                    <td>{{ Custom::showDateTime($row->created_at, 'd-m-Y H:i') }}</td>
                    <td>
                        @if ($row->status == 'pending')
                        <span class="tag tag-danger">{{ ucwords($row->status) }}</span>
                        @elseif ($row->status == 'paired')
                        <span class="tag tag-info">{{ ucwords($row->status) }}</span>
                        @elseif ($row->status == 'approved')
                        <span class="tag tag-success">{{ ucwords($row->status) }}</span>
                        @endif

                        <span class="tag freezed {{ $row->is_freeze == '1' ? '' : 'hide' }} tag-warning">Freezed</span>

                    </td>
                    <td>
                        <div class="btn-group btn-group-solid">
                            <a target="_blank" title="{{ $moduleSingularName }} Detail" href="{{ route($show_url, ['id' => $row->id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-list"></i></a>
                            @if ($row->status == 'pending' && $row->amount == $row->pending_amount)
                            <a title="Delete {{ $moduleSingularName }}" href="{{ route($delete_url,array('id' => $row->id))}}" class="btn btn-danger delete_btn btn-sm" data-id="{{ $row->id }}"><i class="fa fa-trash"></i></a>
                            @endif
                            @if ($row->status == 'pending' || $row->status == 'paired' || $row->pending_amount > 0)
                            <a title="{{ $row->is_freeze == '0' ? 'Freeze' : 'Defreeze' }} {{ $moduleSingularName }}" href="{{ route('gh-freeze',array('id' => $row->id))}}" class="btn  {{ $row->is_freeze == '0' ? 'btn-warning' : 'btn-success' }}  freeze_btn btn-sm" data-id="{{ $row->id }}">
                                @if ($row->is_freeze == '0')
                                <i class="fa fa-lock"></i>
                                @else
                                <i class="fa fa-unlock"></i>
                                @endif
                            </a>
                            @endif
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