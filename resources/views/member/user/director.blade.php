<?php

use \App\Custom;

$pageTitle = "Directors";

$breadCrumbArray = array(
    'Home' => url('/member'),
    $pageTitle => '',
);
?>
@extends('member.layout')

@section('title', $pageTitle)
@section('content')

@include('member.includes.breadcrumb')

<div class="row">
    <div class="col-md-12">

        <div class="white-box">

            @include('member.includes.flashMsg')

            @if (count($manager_list) > 0)

            @foreach ($manager_list as $manager_item)

            @if (count($directors[$manager_item->id]) > 0)
            <h4>{{ $manager_item->name }}</h4>
            <div class="table-responsive">
                <table class="table color-table table-striped table-bordered info-table">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Joining Date</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach ($directors[$manager_item->id] as $row)
                        <tr>
                            <td>{{ $row->username }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->email }}</td>
                            <td>{{ $row->phone }}</td>
                            <td>{{ Custom::showDateTime($row->created_at, 'd-m-Y H:i') }}</td>
                            <td>
                                <div class="btn-group btn-group-solid">
                                    <a title="Member Detail" href="javascript:;" class="btn btn-info btn-sm" data-target=".bs-example-modal-lg-{{ $row->id }}"  data-toggle="modal"><i class="fa fa-list"></i></a>
                                </div>

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

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>


                            </td>
                        </tr>
                        @endforeach
                        

                    </tbody>
                </table>
            </div>
            @endif
            @endforeach

            @endif
        </div>  
    </div>
</div>

@stop

@section('page_js')
@stop