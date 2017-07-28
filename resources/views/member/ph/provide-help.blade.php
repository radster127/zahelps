<?php
$pageTitle = "Provide Help";

$breadCrumbArray = array(
    'Home' => url('/member'),
    $pageTitle => '',
);
?>
@extends('../member.layout')

@section('title', $pageTitle)
@section('content')
@include('member.includes.breadcrumb')

<div class="col-md-12">


    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">

            <div class="panel panel-info">
                <div class="panel-heading">{{ $pageTitle }}</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">

                        @if ($ph_settings['feature'] == 0)
                        <h4 class="text-danger text-center">Sorry, PH Request Was Closed. Please wait to activated.</h4>
                        <?php /*@elseif ($last_30_days_ph_req_count >= 5)
                        <h4 class="text-danger text-center">Sorry, You can not provide help more. You already provide help 5 times in last 30 days.</h4>*/ ?>
                        @else

                        {!! Form::open(['url' => url('member/provide-help'), 'class' => 'module_form']) !!}
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">

                                    @include('member.includes.formErrors')
                                    @include('member.includes.flashMsg')

                                    <div class="form-group">
                                        <label class="control-label">Amount ({{ $web_settings['currency_type'] }})</label>
                                        <?php $options = explode(',', $ph_settings['packed']); ?>
                                        {!! Form::select('amount', array_combine($options, $options), null, ['class' => 'form-control', 'placeholder' => 'Select Amount', 'required' => 'required']) !!}
                                    </div>

                                    <div class="form-group">
                                        <img src='{{ Captcha::src() }}' class="captcha_image" />
                                        {!! Form::text('captcha', null, ['class' => 'form-control', 'placeholder' => 'Enter captcha code', 'required' => 'required']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions text-right">
                            <button type="submit" class="btn btn-lg btn-success">Provide Help Request</button>
                        </div>
                        {!! Form::close() !!}

                        <hr/>
                        <p class="text-danger">WARNING, I'm fully understand all the risks. I make decision being of sound mind and memory to participate in HelpGivers VIP Platform.</p>

                        @endif



                    </div>
                </div>
            </div>


        </div>
    </div>

</div>
@stop



@section('page_js')
<script type="text/javascript">
</script>
@stop