<?php

use Illuminate\Support\Facades\DB; ?>
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse slimscrollsidebar">
        <ul class="nav" id="side-menu">
            <li> <a href="{{ url('member/dashboard') }}" class="waves-effect"><i class="linea-icon linea-basic fa-fw" data-icon="v"></i> <span class="hide-menu"> Dashboard <span class="fa arrow"></span> </span></a></li>
            <li> <a href="javascript:void;" class="waves-effect"><i data-icon="7" class="linea-icon linea-basic fa-fw text-danger"></i> <span class="hide-menu"> My Profile <span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">
                    <li> <a href="{{ url('member/my-page') }}">My Page</a> </li>
                    <li> <a href="{{ url('member/profile') }}"> Edit profile </a> </li>
                    <li> <a href="{{ url('member/change-password') }}">Change password </a> </li>
                    <li> <a href="{{ url('member/change-avatar') }}">Change Avatar</a></li>
                    <li> <a href="{{ url('member/letter-of-happiness') }}">Send Letter of Happiness</a> </li>
                </ul>
            </li>
            <li> <a href="#" class="waves-effect"><i data-icon="7" class="linea-icon linea-basic fa-fw text-danger"></i> <span class="hide-menu"> My Team <span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">
                    <li> <a href="{{ url('member/add-member') }}">Register new member</a> </li>
                    <li>
                        <a href="{{ url('member/my-downline') }}" class="waves-effect">My Downline<span class="fa arrow"></span></a>
                        <?php $levels = \App\MemberLog::where('user_id', '=', Auth::user()->id)->groupBy('level_number')->select(['level_number', DB::raw("count(*) as total")])->orderBy('level_number')->get() ?>
                        @if (count($levels) > 0)
                        <ul class="nav nav-third-level">
                            @foreach ($levels as $level)
                            <li class="level-menu">
                                <a href="{{ url('member/my-levels/' . $level->level_number) }}">
                                    Level {{ $level->level_number }}
                                    <span class="label pull-right label-info text-left">{{ $level->total }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </li>
                    <li> <a href="{{ url('member/directors') }}">Director </a> </li>
                </ul>
            </li>
            <li> <a href="#" class="waves-effect"><i data-icon="7" class="linea-icon linea-basic fa-fw text-danger"></i> <span class="hide-menu"> Provide Help <span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">
                    <li> <a href="{{ url('member/provide-help') }}">Provide Help Request</a> </li>
                    <li> <a href="{{ url('member/provide-help-history') }}">Provide Help History</a> </li>
                    <li> <a href="{{ url('member/my-ph-profit-history') }}">Profit History</a> </li>
                    <li> <a href="{{ url('member/my-downline-ph-profit-history') }}">Downline Profit History</a> </li>
                    @if (Auth::user()->manager_id > 0)
                    <li> <a href="{{ url('member/director-ph-profit-history') }}">Directors Profit History</a> </li>
                    @endif
                </ul>
            </li>
            <li> <a href="#" class="waves-effect"><i data-icon="7" class="linea-icon linea-basic fa-fw text-danger"></i> <span class="hide-menu"> GET Help <span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">
                    <li> <a href="{{ url('member/get-help') }}">Get Help Request</a> </li>
                    <li> <a href="#">Get Bonus Request</a> </li>
                    <li> <a href="{{ url('member/get-help-history') }}">Get Help History</a> </li>
                </ul>
            </li>
            <li> <a href="#" class="waves-effect"><i data-icon="&#xe00b;" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu"> Messages<span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{ url('member/compose-message') }}">Compose</a></li>
                    <li><a href="{{ url('member/inbox') }}">Inbox</a></li>
                </ul>
            </li>
            <li> <a href="#" class="waves-effect"><i class="linea-icon linea-basic fa-fw" data-icon="v"></i> <span class="hide-menu"> Banners <span class="fa arrow"></span> </span></a></li>


        </ul>
    </div>
</div>