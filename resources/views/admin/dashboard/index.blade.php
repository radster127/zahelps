<?php $pageTitle = 'Dashboard'; ?>
@extends('admin.layout')

@section('title', $pageTitle)
@section('content')
<div class="row row-md">
    <div class="col-lg-3 col-md-6 col-xs-12">
        <div class="box box-block bg-white tile tile-1 mb-2">
            <div class="t-icon right"><span class="bg-success"></span><i class="fa fa-users"></i></div>
            <div class="t-content">
                <h6 class="text-uppercase mb-1">Total Members</h6>
                <h1 class="mb-1">{{ number_format($total_users) }}</h1>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-xs-12">
        <a href="{{ url('admin/users/suspended-users') }}">
            <div class="box box-block bg-white tile tile-1 mb-2">
                <div class="t-icon right"><span class="bg-danger"></span><i class="fa fa-users"></i></div>
                <div class="t-content">
                    <h6 class="text-uppercase mb-1">Suspended Members</h6>
                    <h1 class="mb-1">{{ number_format($suspended_users) }}</h1>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6 col-xs-12">
        <div class="box box-block bg-white tile tile-1 mb-2">
            <div class="t-icon right"><span class="bg-primary"></span><i class="fa fa-users"></i></div>
            <div class="t-content">
                <h6 class="text-uppercase mb-1">Joined in last Week</h6>
                <h1 class="mb-1">{{ number_format($users_in_last_week) }}</h1>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-xs-12">
        <div class="box box-block bg-white tile tile-1 mb-2">
            <div class="t-icon right"><span class="bg-info"></span><i class="fa fa-users"></i></div>
            <div class="t-content">
                <h6 class="text-uppercase mb-1">Joined in last 30 days</h6>
                <h1 class="mb-1">{{ number_format($users_in_30_days) }}</h1>
            </div>
        </div>
    </div>




    <div class="col-lg-3 col-md-6 col-xs-12">
        <div class="box box-block bg-white tile tile-1 mb-2">
            <div class="t-icon right"><span class="bg-skype"></span><i class="fa fa-money"></i></div>
            <div class="t-content">
                <h6 class="text-uppercase mb-1">Total GH</h6>
                <h1 class="mb-1">₦ {{ number_format($total_gh) }}</h1>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-xs-12">
        <div class="box box-block bg-white tile tile-1 mb-2">
            <div class="t-icon right"><span class="bg-skype"></span><i class="fa fa-money"></i></div>
            <div class="t-content">
                <h6 class="text-uppercase mb-1">Total Approved GH</h6>
                <h1 class="mb-1">₦ {{ number_format($total_approved_gh) }}</h1>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-xs-12">
        <div class="box box-block bg-white tile tile-1 mb-2">
            <div class="t-icon right"><span class="bg-facebook"></span><i class="fa fa-money"></i></div>
            <div class="t-content">
                <h6 class="text-uppercase mb-1">Total PH</h6>
                <h1 class="mb-1">₦ {{ number_format($total_ph) }}</h1>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-xs-12">
        <div class="box box-block bg-white tile tile-1 mb-2">
            <div class="t-icon right"><span class="bg-facebook"></span><i class="fa fa-money"></i></div>
            <div class="t-content">
                <h6 class="text-uppercase mb-1">Total Approved PH</h6>
                <h1 class="mb-1">₦ {{ number_format($total_approved_ph) }}</h1>
            </div>
        </div>
    </div>


</div>

@if (count($recently_joined_members) > 0)
<div class="row row-md mb-2">
    <div class="col-md-12">

        <h4>Recently Joined Members</h4>
        <div class="box bg-white">

            <table class="table table-grey-head mb-md-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Reference</th>
                        <th>Account Balance</th>
                        <th>Joined At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $counter = 1; ?>
                    @foreach ($recently_joined_members as $member)
                    <tr>
                        <th>{{ $counter++ }}</th>
                        <td>{{ $member->username }}</td>
                        <td>{{ $member->name }}</td>
                        <td>
                            @if ($member->user_id > 0)
                            {{ $member->sponsor->username }}
                            @endif
                        </td>
                        <td>{{ $member->account_balance }}</td>
                        <td>
                            @if ($member->created_at != '0000-00-00 00:00:00' && $member->created_at != NULL)
                            {{ $member->created_at->diffForHumans() }}
                            @endif
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

<div class="box box-block bg-white">
    <div class="row">
        <div class="col-md-12">
            <h5 class="mb-1">Members</h5>
            <canvas id="bar" class="chart-container"></canvas>
        </div>
    </div>
</div>

@stop
@section('page_js')

<script type="text/javascript" src="{{ asset('/') }}themes/neptune/vendor/chartjs/Chart.bundle.min.js"></script>
<!--<script type="text/javascript" src="{{ asset('/') }}themes/neptune/js/charts-chartjs.js"></script>-->
<script type="text/javascript">

/* [Start Bar chart] */
var ctx = document.getElementById("bar");

var data = {
    labels: ["January", "February", "March", "April", "May", "June", "July",
        "August", "September", "October", "November", "December"],
    datasets: [{
            label: 'Members',
            data: [20, 22, 16, 10, 23, 18, 21, 25, 20, 25, 19, 16],
            backgroundColor: 'rgba(62,112,201,0.2)',
            borderColor: '#3E70C9',
            borderWidth: 1
        }, {
            label: 'Members1',
            data: [20, 22, 16, 10, 23, 18, 21, 25, 20, 25, 19, 16],
            backgroundColor: 'rgba(62,112,201,0.2)',
            borderColor: '#ff0000',
            borderWidth: 1
        }]
};

var myChart = new Chart(ctx, {
    type: 'bar',
    data: data,
    options: {
        scales: {
            yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
        }
    }
});
/* [End Bar chart]*/

</script>

@stop