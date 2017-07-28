<?php
$pageTitle = "Dashboard";

$breadCrumbArray = array(
    'Home' => url('/member'),
    $pageTitle => '',
);
?>
@extends('member.layout')

@section('title', $pageTitle)
@section('content')
@include('member.includes.breadcrumb')

<div class="col-md-12">
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="white-box dashboard-white-box">
                <div class="row row-in">
                    <div class="col-lg-3 col-sm-6 row-in-br">
                        <div class="col-in row">
                            <div class="col-md-6 col-sm-6 col-xs-6"> <i data-icon="E" class="fa fa-gift" ></i>
                                <h5 class="text-muted vb">Total Provide Help</h5>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span class="counter text-right text-danger">{{ isset($ph_total->total_ph) ? $ph_total->total_ph : 0 }}</span>
                                <span class="text-right text-danger">R</span>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 row-in-br  b-r-none">
                        <div class="col-in row">
                            <div class="col-md-6 col-sm-6 col-xs-6"> <i class="fa fa-money" data-icon="&#xe01b;"></i>
                                <h5 class="text-muted vb">Total Get Help</h5>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span class="counter text-right text-danger">{{ isset($gh_total->total_gh) ? $gh_total->total_gh : 0 }}</span>
                                <span class="text-right text-danger">R</span>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 row-in-br">
                        <div class="col-in row">
                            <div class="col-md-6 col-sm-6 col-xs-6"> <i class="fa fa-heart" data-icon="&#xe00b;"></i>
                                <h5 class="text-muted vb">Account Balance</h5>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span class="counter text-right text-danger">{{ isset($user->account_balance) ? $user->account_balance : 0 }}</span>
                                <span class="text-right text-danger">R</span>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6  b-0">
                        <div class="col-in row">
                            <div class="col-md-6 col-sm-6 col-xs-6"> <i class="fa fa-usd" data-icon="&#xe016;"></i>
                                <h5 class="text-muted vb">Bonus Balance</h5>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span class="counter text-right text-danger">{{ isset($user->member_commision) ? $user->member_commision : 0 }}</span>
                                <span class="text-right text-danger">R</span>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="clearfix">&nbsp;</div>
                <div class="row row-in">
                    <div class="col-lg-3 col-sm-6 row-in-br">
                        <div class="col-in row">
                            <div class="col-md-6 col-sm-6 col-xs-6"> <i data-icon="E" class="fa fa-trophy" ></i>
                                <h5 class="text-muted vb">Manager Level</h5>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <h4 class="text-right text-danger">
                                    @if (Auth::user()->manager_id > 0)
                                    {{ Auth::user()->manager->name }}
                                    @endif
                                </h4>
                            </div>

                        </div>
                    </div>
                    @if ($user->user_id > 0)
                    <div class="col-lg-3 col-sm-6 row-in-br">
                        <div class="col-in row">
                            <div class="col-md-6 col-sm-6 col-xs-6"> <i class="fa fa-user" data-icon="&#xe00b;"></i>
                                <h5 class="text-muted vb">Upline</h5>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <h4 class="text-right text-primary">{{ $user->user_id > 0 ? $user->sponsor->username : '' }}</h4>
                            </div>

                        </div>
                    </div>
                    @endif

                    <div class="col-lg-3 col-sm-6  b-0">
                        <a href="{{ url('member/my-levels') }}">
                            <div class="col-in row">
                                <div class="col-md-6 col-sm-6 col-xs-6"> <i class="fa fa-users" data-icon="&#xe016;"></i>
                                    <h5 class="text-muted vb">Total Referrals</h5>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h3 class="counter text-right text-success">{{ $total_referrals }}</h3>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-sm-6  b-0">
                        <a href="{{ url('member/my-levels/1') }}">
                            <div class="col-in row">
                                <div class="col-md-8 col-sm-8 col-xs-6"> <i class="fa fa-users" data-icon="&#xe016;"></i>
                                    <h5 class="text-muted vb">Total Direct Referrals</h5>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <h3 class="counter text-right text-success">{{ $total_direct_referrals }}</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-sm-12">
            <a href="{{ url('member/provide-help') }}" class="btn btn-success btn-lg btn-block provide_help_button">Provide Help</a>
        </div>

        <div class="col-md-6 col-sm-12">
            <a href="{{ url('member/get-help') }}" class="btn btn-danger btn-lg btn-block get_help_button">Get Help</a>
        </div>

    </div>

    <div class="row">

        <div class="col-lg-8 col-sm-12">

            @include('member.dashboard._ph_paired_list')
            @include('member.dashboard._gh_paired_list')

        </div>

        <div class="col-lg-4 col-sm-12">
            @include('member.dashboard._ph_pending_list')
            @include('member.dashboard._gh_pending_list')
        </div>
    </div>

    <?php /*
      <div class="row">
      <div class="col-sm-6">
      <div class="white-box">
      <h3 class="box-title">Provide Help History</h3>
      <div>
      <canvas id="chart2" height="150"></canvas>
      </div>
      </div>
      </div>
      <div class="col-sm-6">
      <div class="white-box">
      <h3 class="box-title">Get Help History</h3>
      <div>
      <canvas id="chart3" height="150"></canvas>
      </div>
      </div>
      </div>
      </div>
     * 
     */ ?>


</div>


@stop
@section('page_js')
<!--Counter js -->
<script src="{{ asset('/') }}themes/eliteadmin/plugins/bower_components/waypoints/lib/jquery.waypoints.js"></script>
<script src="{{ asset('/') }}themes/eliteadmin/plugins/bower_components/counterup/jquery.counterup.min.js"></script>

<!-- Chart JS -->
<!--<script src="{{ asset('/') }}/themes/eliteadmin/plugins/bower_components/Chart.js/chartjs.init.js"></script>-->
<script src="{{ asset('/') }}themes/eliteadmin/plugins/bower_components/Chart.js/Chart.min.js"></script>

<script type="text/javascript">
$(function () {
    $(".counter").counterUp({
        delay: 100,
        time: 1200
    });
    //Warning Message
    $('.delete-ph').click(function () {
        var ph_id = $(this).data('ph_id');
        var panel = $(this).closest('.panel');
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this ph request again!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function () {

            $.ajax({
                type: 'post',
                url: '{{ url("member/cancel-ph") }}',
                data: {'_token': "{{ csrf_token() }}", 'ph_id': ph_id},
                success: function (data) {
                    if (data.status == 0) {
                        swal("Error!", data.message, "error");
                    } else {
                        panel.remove();
                        swal("Deleted!", data.message, "success");
                    }
                },
                error: function (e) {
                    swal("Error!", "There is an error to delete your PH, Kindly try again or contact Admin.", "error");
                }

            });
            swal("Deleted!", "Your imaginary file has been deleted.", "success");
        });
    });
});
//provide help chart
var ctx2 = document.getElementById("chart2").getContext("2d");
var data2 = {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec"],
    datasets: [
        {
            label: "Provide Help",
            fillColor: "rgba(252,201,186,0.8)",
            strokeColor: "rgba(252,201,186,0.8)",
            highlightFill: "rgba(252,201,186,1)",
            highlightStroke: "rgba(252,201,186,1)",
            data: [10, 30, 80, 61, 26, 75, 40, 30, 65, 62, 21, 60]
        }
    ]
};
var chart2 = new Chart(ctx2).Bar(data2, {
    scaleBeginAtZero: true,
    scaleShowGridLines: true,
    scaleGridLineColor: "rgba(0,0,0,.005)",
    scaleGridLineWidth: 0,
    scaleShowHorizontalLines: true,
    scaleShowVerticalLines: true,
    barShowStroke: true,
    barStrokeWidth: 0,
    tooltipCornerRadius: 2,
    barDatasetSpacing: 3,
    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
    responsive: true
});
//get help chart
var ctx3 = document.getElementById("chart3").getContext("2d");
var data3 = {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec"],
    datasets: [
        {
            label: "Get Help",
            fillColor: "rgba(180,193,215,0.8)",
            strokeColor: "rgba(180,193,215,0.8)",
            highlightFill: "rgba(180,193,215,1)",
            highlightStroke: "rgba(180,193,215,1)",
            data: [28, 48, 40, 19, 86, 27, 90, 50, 59, 69, 29, 60]
        }
    ]
};
var chart3 = new Chart(ctx3).Bar(data3, {
    scaleBeginAtZero: true,
    scaleShowGridLines: true,
    scaleGridLineColor: "rgba(0,0,0,.005)",
    scaleGridLineWidth: 0,
    scaleShowHorizontalLines: true,
    scaleShowVerticalLines: true,
    barShowStroke: true,
    barStrokeWidth: 0,
    tooltipCornerRadius: 2,
    barDatasetSpacing: 3,
    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
    responsive: true
});

</script>
@stop