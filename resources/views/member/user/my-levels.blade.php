<?php
$pageTitle = "My Levels";

$breadCrumbArray = array(
    'Home' => url('/member'),
    $pageTitle => '',
);
?>
@extends('member.layout')

@section('title', $pageTitle)
@section('content')

@include('member.includes.breadcrumb')

@if (count($levels) > 0)
<div class="row my-levels">

    <div class="col-md-12">
        @include('member.includes.flashMsg')
    </div>
    @foreach ($levels as $key=>$level)
    @if ($key < 10)
    <div class="col-md-3 col-sm-4">
        <a href="{{ route('level-members', ['level' => $level->level_number]) }}">
            <div class="white-box {{ $colors[$key] }} text-white">
                <h3 class="box-title text-white">Level {{ $level->level_number }}</h3>
                <ul class="list-inline two-part">
                    <li><i class="icon-people text-white"></i></li>
                    <li class="text-right"><span class="counter">{{ $level->total }}</span></li>
                </ul>
            </div>
        </a>
    </div>
    @endif
    @endforeach



</div>
@else
<div class="white-box">
    <h3 class="text-capitalize text-center">Sorry you don't have any member in downline</h3>
</div>
@endif;

@stop

@section('page_js')
<!--Counter js -->
<script src="{{ asset('/') }}/themes/eliteadmin/plugins/bower_components/waypoints/lib/jquery.waypoints.js"></script>
<script src="{{ asset('/') }}/themes/eliteadmin/plugins/bower_components/counterup/jquery.counterup.min.js"></script>

<script type="text/javascript">
$(function () {
    $(".counter").counterUp({
        delay: 100,
        time: 1200
    });
})

</script>
@stop