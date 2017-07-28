<?php

Use \App\Custom; ?>
@if (count($ph_pending_list) > 0)
@foreach ($ph_pending_list as $item)
<div class="panel panel-primary">
    <div class="panel-heading panel-header"> {{ $ph_settings['identity_called'] }} >> {{ $item->transaction_code }}
        @if ($item->status == 'pending')
        <div class="pull-right">
            <a href="javascript:;" data-ph_id="{{ $item->id }}" class="btn btn-danger btn-xs delete-ph">Cancel</a> 
        </div>
        @endif
    </div>
    <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
            <p><b>Request {{ $ph_settings['identity_called'] }} {{ $item->transaction_code }}</b></p>
            <p> Date : {{ Custom::showDateTime($item->created_at, 'l j M Y h:i A') }}<br/>
                Amount : {{ $web_settings['currency_type'] }} {{ $item->amount }}<br/>
                Pending Amount : {{ $web_settings['currency_type'] }} {{ $item->pending_amount }}<br/>
                Status : <span class="label label-success">{{ $item->status }}</span>
            </p>
        </div>
    </div>
</div>
@endforeach
@endif
