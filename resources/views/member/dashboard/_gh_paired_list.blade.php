<?php

Use \App\Custom; ?>

@if (count($gh_paired_list) > 0)
@foreach ($gh_paired_list as $item)
<div class="panel panel-info paired-panel">
    <a href="{{ route('gh-detail', ['token' => $item->token]) }}">
        <div class="panel-heading panel-header">
            GH Request Order: #{{ $item->GH->transaction_code }}
            @if($item->status == 'paired' && $item->payment_type == 'pending')
            <label class="pull-right label label-inverse">{{ $item->status }}</label>
            @elseif($item->status == 'paired' && $item->payment_type != 'pending')
            <label class="pull-right label label-purple">Payment Confirmed</label>
            @elseif($item->payment_type != 'approved')
            <label class="pull-right label label-purple">{{ $item->status }}</label>
            @endif
        </div>
    </a>
    <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
            @if ($item->PH->user_id > 0)
            <div class="row">
                <h4>Received Payment From:</h4>
                <div class="col-md-4 col-sm-12">
                    <p>
                        <i class="fa fa-user"></i> Username: <b>{{ $item->PH->user->username }}</b> <br/>  
                        <i class="fa fa-phone"></i> Tel: <b>{{ $item->PH->user->phone }}</b> <br/>
                        <i class="fa fa-envelope"></i> Email: <b>{{ $item->PH->user->email }}</b>
                    </p>
                </div>

                <div class="col-md-5 col-sm-12">
                    <p>
                        @if ($item->PH->user->bitcoin != '')
                        <i class="fa fa-bitcoin"></i> Bitcoin: <b>{{ $item->PH->user->bitcoin }}</b> <br/>
                        @endif
                        <i class="fa fa-bank"></i> Bank: <b>{{ $item->PH->user->bank_name }}</b> <br/>
                        <i class="fa fa-briefcase"></i> Acc. No: <b>{{ $item->PH->user->bank_account_number }}</b> <br/> 
                        <i class="fa fa-user"></i> Name: <b>{{ $item->PH->user->bank_account_name }}</b> 
                    </p>
                </div>

                <div class="col-md-3 col-sm-12">
                    <p class="pull-right"><b>{{ $web_settings['currency_type'] }} {{ number_format($item->amount,2) }}</b><br/>
                        <a href="{{ route('gh-detail', ['token' => $item->token]) }}#messages" class="btn btn-success panel-button"><i class="fa fa-comments"></i> Message</a>
                    </p>
                </div>
            </div>
            @endif
            <hr/>
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <p>Order Number:<br/>
                        <b>#{{ $item->GH->transaction_code }}</b></p>
                </div>

                <div class="col-md-3 col-sm-12">
                    <p><b>Bitcoin</b><br/>
                        ---</p>
                </div>

                <div class="col-md-6 col-sm-12">

                    <p>Please Contact sponsor if the member has not made payment to you on time: <br/>
                        @if ($item->PH->user_id > 0)
                        @if ($item->PH->user->user_id > 0)
                        {{ $item->PH->user->sponsor->username }}:  <b>{{ $item->PH->user->sponsor->phone }}</b>
                        @else
                        <b> -- No Sponsor -- </b>
                        @endif
                        @endif
                    </p>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <p><b>Order Creation Date :</b> <br/>
                        <i class="fa fa-calendar"></i> {{ Custom::showDateTime($item->GH->created_at, 'd/m/Y H:i A') }}</p>
                </div>

                <div class="col-md-3 col-sm-12">
                    <p><b>Expiring Date:</b> <br/>
                        <i class="fa fa-calendar"></i> {{ Custom::showDateTime($item->expired_on, 'd/m/Y H:i A') }}</p>
                </div>

                <div class="col-md-6 col-sm-12">
                    <a href="{{ route('gh-detail', ['token' => $item->token]) }}" class="btn btn-info panel-button"><i class="fa fa-check"></i> Confirm</a>
                    <a href="{{ route('gh-detail', ['token' => $item->token]) }}" class="btn btn-danger panel-button"><i class="fa fa-close"></i> Reject</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endforeach
@endif
