<?php

Use \App\Custom; ?>

@if (count($ph_paired_list) > 0)
@foreach ($ph_paired_list as $item)
<?php $userInformation = json_decode($item->GH->user_information, true); ?>
<div class="panel panel-primary paired-panel">
    <a href="{{ route('ph-detail', ['token' => $item->token]) }}">
        <div class="panel-heading panel-header"> 
            PH Request Order: #{{ $item->PH->transaction_code }}
            @if($item->status == 'paired' && $item->payment_type == 'pending')
            <label class="pull-right label label-inverse">{{ $item->status }}</label>
            @elseif($item->status == 'paired' && $item->payment_type != 'pending')
            <label class="pull-right label label-warning">Payment Confirmed</label>
            @elseif($item->payment_type != 'approved')
            <label class="pull-right label label-purple">{{ $item->status }}</label>
            @endif
        </div>
    </a>
    <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
            <h4>Make Payment to: </h4>
            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <p>
                        <i class="fa fa-user"></i> Username: <b>{{ $item->GH->user->username }}</b> <br/>  
                        <i class="fa fa-phone"></i> Tel: <b>{{ $item->GH->user->phone }}</b> <br/>
                        <i class="fa fa-envelope"></i> Email: <b>{{ $item->GH->user->email }}</b>
                    </p>
                </div>

                <div class="col-md-5 col-sm-12">
                    <p>
                        @if (isset($userInformation->bitcoin) && $userInformation->bitcoin != '')
                        <i class="fa fa-bitcoin"></i> Bitcoin: <b>{{ $userInformation->bitcoin }}</b> <br/>
                        @endif
                        <i class="fa fa-bank"></i> Bank: <b>{{ $userInformation['bank_name'] }}</b> <br/>
                        <i class="fa fa-briefcase"></i> Acc. No: <b>{{ $userInformation['bank_account_number'] }}</b> <br/> 
                        <i class="fa fa-user"></i> Name: <b>{{ $userInformation['bank_account_name'] }}</b> 
                    </p>
                </div>

                <div class="col-md-3 col-sm-12">
                    <p class="pull-right"><b>{{ $web_settings['currency_type'] }} {{ number_format($item->amount,2) }}</b><br/>
                        <a href="{{ route('ph-detail', ['token' => $item->token]) }}#messages" class="btn btn-success panel-button"><i class="fa fa-comments"></i> Message</a>
                    </p>
                </div>
            </div>

            <hr/>
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <p>Order Number:<br/>
                        <b>#{{ $item->PH->transaction_code }}</b></p>
                </div>

                <div class="col-md-3 col-sm-12">
                    <p><b>Bitcoin</b><br/>
                        ---</p>
                </div>

                <div class="col-md-6 col-sm-12">

                    <p>Please Contact sponsor if the member has not responded to her PO on time: <br/>
                        @if ($item->PH->user->user_id > 0)
                        {{ $item->PH->user->sponsor->username }}:  <b>{{ $item->PH->user->sponsor->phone }}</b>
                        @else
                        <b> -- No Sponsor -- </b>
                        @endif
                    </p>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <p><b>Order Creation Date :</b> <br/>
                        <i class="fa fa-calendar"></i> {{ Custom::showDateTime($item->PH->created_at, 'd/m/Y H:i A') }}</p>
                </div>

                
                <div class="col-md-3 col-sm-12">
                    @if ($item->expired_on != '0000-00-00 00:00:00')
                    <p><b>Expiring Date:</b> <br/>
                        <i class="fa fa-calendar"></i> {{ Custom::showDateTime($item->expired_on, 'd/m/Y H:i A') }}</p>
                    @endif
                </div>

                <div class="col-md-6 col-sm-12">
                    <a href="{{ route('ph-detail', ['token' => $item->token]) }}" class="btn btn-info panel-button pull-right"><i class="fa fa-check"></i> Confirm</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endforeach
@endif
