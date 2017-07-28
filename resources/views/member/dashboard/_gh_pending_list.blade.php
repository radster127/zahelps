<?php

Use \App\Custom; ?>
@if (count($gh_pending_list) > 0)
@foreach ($gh_pending_list as $item)
<div class="panel panel-info">
    <div class="panel-heading panel-header"> {{ $gh_settings['identity_called'] }} >> {{ $item->transaction_code }} </div>
    <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
            <p><b>Request {{ $gh_settings['identity_called'] }} {{ $item->transaction_code }}</b></p>
            <p> Date : {{ Custom::showDateTime($item->created_at, 'l j F Y h:i A') }}<br/>
                Amount : {{ $web_settings['currency_type'] }} {{ $item->amount }}<br/>
                Pending Amount : {{ $web_settings['currency_type'] }} {{ $item->pending_amount }}<br/>
                Status : <span class="label label-success">{{ $item->status }}</span>
            </p>
        </div>
    </div>
</div>
@endforeach
@endif