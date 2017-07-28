<?php

Use \App\Custom;

$pageTitle = $ph_settings['identity_called'] . " Detail: #" . $pair_item->PH->transaction_code;

$breadCrumbArray = array(
    'Home' => url('/member'),
    $ph_settings['name'] . ' History' => url('/member/provide-help-history'),
    $pageTitle => '',
);
?>
@extends('member.layout')

@section('title', $pageTitle)
@section('content')
@include('member.includes.breadcrumb')

<div class="col-md-12">
    <div class="row">

        <div class="col-md-12">
            @include('member.includes.flashMsg')
            @include('member.includes.formErrors')
        </div>

        <div class="col-md-8">

            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">{{ $ph_settings['name'] }} User</div>
                        <div class="panel-wrapper collapse in" aria-expanded="true">
                            <div class="panel-body">
                                <h4>From</h4>
                                <?php $phUserInformation = json_decode($pair_item->PH->user_information, true); ?>
                                <p>
                                    <i class="fa fa-user"></i> <b>User:</b> {{ $pair_item->PH->user->username }}<br/>
                                    <i class="fa fa fa-male"></i> <b>Name:</b> {{ $phUserInformation['name'] }}<br/>
                                    <i class="fa fa-envelope"></i> <b>Email:</b> {{ $pair_item->PH->user->email }}<br/>
                                    <i class="fa fa-phone"></i> <b>Mobile:</b> {{ $pair_item->PH->user->phone }}<br/><br>
                                    <i class="fa fa-bank"></i> <b>Bank:</b> {{ $phUserInformation['bank_name'] }}<br/>
                                    <i class="fa fa-user-plus"></i> <b>Account Name:</b> {{ $phUserInformation['bank_account_name'] }}<br/>
                                    <i class="fa fa-star"></i> <b>Account Number:</b> {{ $phUserInformation['bank_account_number'] }}<br/>
                                    <i class="fa fa-bitcoin"></i> <b>Bitcoin:</b> {{ $phUserInformation['bitcoin'] }}<br/>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>    

                <div class="col-md-6">
                    <div class="panel panel-warning">
                        <div class="panel-heading">{{ $gh_settings['name'] }} User</div>
                        <div class="panel-wrapper collapse in" aria-expanded="true">
                            <div class="panel-body">
                                <h4>To</h4>
                                <?php $ghUserInformation = json_decode($pair_item->GH->user_information, true); ?>
                                <p>
                                    <i class="fa fa-user"></i> <b>User:</b> {{ $pair_item->GH->user->username }}<br/>
                                    <i class="fa fa fa-male"></i> <b>Name:</b> {{ $ghUserInformation['name'] }}<br/>
                                    <i class="fa fa-envelope"></i> <b>Email:</b> {{ $pair_item->GH->user->email }}<br/>
                                    <i class="fa fa-phone"></i> <b>Mobile:</b> {{ $pair_item->GH->user->phone }}<br/><br>
                                    <i class="fa fa-bank"></i> <b>Bank:</b> {{ $ghUserInformation['bank_name'] }}<br/>
                                    <i class="fa fa-user-plus"></i> <b>Account Name:</b> {{ $ghUserInformation['bank_account_name'] }}<br/>
                                    <i class="fa fa-star"></i> <b>Account Number:</b> {{ $ghUserInformation['bank_account_number'] }}<br/>
                                    <i class="fa fa-bitcoin"></i> <b>Bitcoin:</b> {{ $ghUserInformation['bitcoin'] }}<br/>
                                </p>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>  

            <div class="panel panel-info">
                <div class="panel-heading">To finish this transaction, Please follow steps</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Step</th>
                                    <th class="col-md-7">Instruction</th>
                                    <th class="col-md-4">Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Contact Your Pair To Ask ready or not And Is Bank or Ecurrency is right or not	</td>
                                    <td>
                                        <i class="fa fa-envelope"></i>&nbsp;&nbsp;{{ $pair_item->GH->user->email }}<br/>
                                        <i class="fa fa-phone"></i>&nbsp;&nbsp;&nbsp;{{ $pair_item->GH->user->phone }}
                                    </td>

                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Transfer your PH Add 3 unique digits To Easy Checking. Example: PH $100, Transfer : $100.003</td>
                                    <td>
                                        <i class="fa fa-bank"></i>&nbsp;&nbsp;{{ $ghUserInformation['bank_name'] }} {{ $ghUserInformation['bank_account_number'] }} {{ $ghUserInformation['bank_account_name'] }}<br/>
                                        <i class="fa fa-bitcoin"></i>&nbsp;&nbsp;&nbsp;{{ $ghUserInformation['bitcoin'] }}
                                    </td>

                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Confirm your transfer with Upload Payment proof. Dont confirm before transfer or your account will be banned	Confirm Transfer</td>
                                    <td>
                                        @if ($pair_item->payment_type == 'pending' && $pair_item->status == 'paired')
                                        <a data-toggle="modal" data-target=".bs-example-modal-lg" class="btn btn-block btn-danger white_font">Confirm Transfer</a>
                                        @elseif (($pair_item->payment_type != 'pending' && $pair_item->status == 'paired') || $pair_item->status == 'approved')
                                        <a class="btn btn-block btn-danger white_font swal_btn" data-message-title="Already Confirmed!" data-message="You already have confirmed payment, Kindly wait for GH member to approve your payment or contact him" data-message-type="success" >Confirm Transfer</a>
                                        @elseif ($pair_item->status == 'expired')
                                        <a class="btn btn-block btn-danger white_font swal_btn" data-message-title="Expired!" data-message="You missed to approve your pair on time." data-message-type="error" >Confirm Transfer</a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Contact Your Pair <br/>
                                        to Approve soon. Get Fast Transfer Commission for you and your pair if your transactions completed before 12 hours	Sent Messages</td>
                                    <td><a href='javascript: ;' class="btn send_message btn-inverse btn-block white_font">Send Message</a></td>
                                </tr>
                            </tbody>
                        </table>


                        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    {!! Form::open(['method' => 'POST','url' => url('member/confirm-ph-payment'),'id' => 'confirm_ph_payment', 'files' => true]) !!}
                                    {!! Form::hidden('pair_id', $pair_item->id) !!}
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 class="modal-title" id="mySmallModalLabel">Confirm {{ $ph_settings['identity_called'] . ": #" . $pair_item->PH->transaction_code }} <span class="username"></span></h4>
                                    </div>
                                    <div class="modal-body">

                                        <div class='alert alert-success hide'></div>        

                                        <div class="form-group">
                                            {!! Form::label('Payment Type') !!}
                                            <div class="radio radio-info">
                                                {!! Form::radio('payment_type', 'bank', null, ['id' => 'bank', 'checked' => 'checked']) !!}
                                                <label for="bank"> <i class="fa fa-bank"></i>&nbsp;&nbsp;{{ $ghUserInformation['bank_name'] }} {{ $ghUserInformation['bank_account_number'] }} {{ $ghUserInformation['bank_account_name'] }}</label>
                                            </div>
                                            <div class="radio radio-info">
                                                {!! Form::radio('payment_type', 'bitcoin', null, ['id' => 'bitcoin',]) !!}
                                                <label for="bitcoin"> <i class="fa fa-bitcoin"></i>&nbsp;&nbsp;&nbsp;{{ $ghUserInformation['bitcoin'] }}</label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            {!! Form::label('Transferred Amount') !!}
                                            <div class="col-md-12">
                                                {!! Form::text('transferred_amount', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                            </div>
                                        </div>

                                        <div class="clearfix">&nbsp;</div>

                                        <div class="form-group">
                                            {!! Form::label('Payment Proof') !!}
                                            <div class="col-md-12">
                                                {!! Form::file('proof_picture', ['class' => 'form-control', 'required' => 'required']) !!}
                                            </div>
                                        </div>
                                        <div class="clearfix">&nbsp;</div>

                                        <div class="form-group">
                                            {!! Form::label('Send Message') !!}
                                            <div class="col-md-12">
                                                {!! Form::textarea('message', null, ['class' => 'form-control message-box']) !!}
                                            </div>
                                        </div>
                                        <div class="clearfix">&nbsp;</div>
                                        <hr/>
                                        <button type="submit" class="btn btn-info pull-right waves-effect waves-light">Submit</button>
                                        <div class="clearfix"></div>
                                    </div>

                                    {!! Form::close() !!}
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->


                    </div>
                </div>
            </div>

            <div class="clearfix"></div>



            <div class="panel panel-warning">
                <div class="panel-heading">Messages</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">


                        <div class="chat-box">

                            <a name="messages"></a>
                            <ul class="chat-list">


                                <li class="odd hidden_chat hide">
                                    <div class="chat-image"> <img alt="" src="{{ asset('/') }}images/user.png"> </div>
                                    <div class="chat-body">
                                        <div class="chat-text">
                                            <h4></h4>
                                            <p></p>
                                            <b></b>
                                        </div>
                                    </div>
                                </li>

                                @if (count($pair_messages) > 0)
                                @foreach ($pair_messages as $message)

                                <?php
                                $oddClass = '';
                                $userImage = asset('/') . 'images/user.png';
                                if ($message->from->avatar != '') {
                                  $userImage = asset('/') . 'uploads/members/' . $message->from->id . '/thumb_50X50_' . $message->from->avatar;
                                }
                                $username = $message->from->username;
                                if ($message->from_id == Auth::user()->id) {
                                  $oddClass = 'odd';
                                }
                                ?>
                                <li class="{{ $oddClass }}">
                                    <div class="chat-image">
                                        <img alt="member" src="{{ $userImage }}">
                                    </div>
                                    <div class="chat-body">
                                        <div class="chat-text">
                                            <h4>{{ $username }}</h4>
                                            <p>{{ $message->message }}</p>
                                            <b>{{ $message->created_at->diffForHumans() }}</b> 
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                                @endif


                            </ul>



                        </div>
                        <div class="clearfix"></div>

                        {!! Form::open(['method' => 'POST', 'url' => url('member/send-pair-message'), 'id' => 'message_form',]) !!}
                        {!! Form::hidden('pair_id', $pair_item->id) !!}
                        <div class="row send-chat-box">
                            <div class="col-sm-12">
                                <hr/>
                                {!! Form::textarea('message', null ,['class' => 'form-control message_txt', 'placeholder' => 'Type your message', 'required' => 'required']) !!}
                                <div class="custom-send text-right"> <button class="btn btn-info" type="submit">Send</button></div>
                            </div>
                        </div>
                        {!! Form::close() !!}


                    </div>
                </div>
            </div>




        </div>    

        <div class="col-md-4">
            <div class="panel panel-danger you_can_transfer_panel">
                <div class="panel-heading">You Can Transfer</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <table class="table table-bordered table-hover table-active">
                            <tr>
                                <th>BTC</th>
                                <th>USD</th>
                            </tr>
                            <tr>
                                <td>---</td>
                                <td>{{ $web_settings['currency_type'] }} {{ number_format($pair_item->amount, 2) }}</td>
                            </tr>
                        </table>
                        <a href="javascript:;" class="btn btn-info btn-block">{{ $web_settings['currency_type'] }} {{ number_format($pair_item->amount, 2) }}</a>
                        <a href="javascript:;" class="btn btn-warning btn-block">Date: {{ Custom::showDateTime($pair_item->PH->created_at, 'D j M Y h:i A') }}</a>

                        @if ($pair_item->payment_type == 'expired')
                        <a href="javascript:;" class="btn btn-danger btn-block">Expired on Date: {{ Custom::showDateTime($pair_item->created_at, 'D j M Y h:i A') }}</a>
                        @elseif ($pair_item->payment_type == 'pending' && $pair_item->status == 'paired')
                        <a href="javascript:;" class="btn btn-danger btn-block">Will Expire after: <span id="expire_on"></span></a>
                        @elseif ($pair_item->payment_type != 'pending' && $pair_item->status == 'paired')
                        <a href="javascript:;" class="btn btn-danger btn-block">Auto Approve on Date: {{ Custom::showDateTime($pair_item->auto_approved_on, 'D j M Y h:i A') }}</a>
                        @elseif ($pair_item->status == 'approved')
                        @if($pair_item->approved_on != '0000-00-00 00:00:00')
                        <a href="javascript:;" class="btn btn-danger btn-block">Completed on Date: {{ Custom::showDateTime($pair_item->approved_on, 'D j M Y h:i A') }}</a>
                        @else
                        <a href="javascript:;" class="btn btn-danger btn-block">Completed</a>
                        @endif
                        @endif

                    </div>

                </div>
            </div>

            @if ($pair_item->proof_picture != '')
            <div class="panel panel-danger">
                <div class="panel-heading">Payment Proof</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body text-center">
                        <a href="{{ asset('/') }}uploads/payment_proof/{{ $pair_item->id }}/{{ $pair_item->proof_picture }}" class="colorbox">
                            <img onerror="proofPictureImgError(this)" class="img-responsive m-0-auto" src="{{ asset('/') }}uploads/payment_proof/{{ $pair_item->id }}/thumb_250_{{ $pair_item->proof_picture }}" class="img-responsive margin_0_auto" />
                        </a>
                    </div>

                </div>
            </div>

            <div class="panel panel-danger">
                <div class="panel-heading">Payment Amount</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body text-left">
                        <p>
                            <b>Payment Method:</b> {{ ucwords($pair_item->payment_type) }}<br/>
                            <b>Payment Amount:</b> {{ ucwords($pair_item->transferred_amount) }}<br/>
                        </p>
                    </div>

                </div>
            </div>
            @endif

            <div class="panel panel-danger">
                <div class="panel-heading">Contact Upline / Sponsor Receiver</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <h4>If Receiver cannot contact, please contact Sponsor / Upline</h4>
                        @if ($pair_item->GH->user->user_id > 0)
                        <i class="fa fa-user"></i> <b>Sponsor:</b> {{ $pair_item->GH->user->sponsor->username }}<br/>
                        <i class="fa fa fa-male"></i> <b>Name:</b> {{ $pair_item->GH->user->sponsor->name }}<br/>
                        <i class="fa fa-envelope"></i> <b>Email:</b> {{ $pair_item->GH->user->sponsor->email }}<br/>
                        <i class="fa fa-phone"></i> <b>Mobile:</b> {{ $pair_item->GH->user->sponsor->phone }}
                        @else
                        -- No Sponsor --
                        @endif

                    </div>

                </div>
            </div>

            <div class="panel panel-danger">
                <div class="panel-heading">Contact Our Support</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <h4>If Receiver cannot contact, Sponsor / Upline cannot contact too, please contact Our Customer Service</h4>
                        <i class="fa fa-globe"></i> <b>Support:</b> Support naijahelpsgivers.net<br/>
                        <i class="fa fa fa-male"></i> <b>Name:</b> Ryan Moore<br/>
                        <i class="fa fa-envelope"></i> <b>Email:</b> admin@naijahelpsgivers.net <br/>
                        <i class="fa fa-phone"></i> <b>Mobile:</b> 08123456789

                    </div>

                </div>
            </div>
        </div>    



    </div>
</div>



</div>


@stop
@section('page_js')

<link href="{{ asset('/') }}thirdparty/colorbox/colorbox.css" rel="stylesheet">
<script type="text/javascript" src="{{ asset('/') }}thirdparty/colorbox/jquery.colorbox-min.js"></script>

<script type="text/javascript" src="{{ asset('/') }}thirdparty/countdown/jquery.countdown.js"></script>

<script type="text/javascript">
$(function () {

    $("#expire_on")
            .countdown("{{ Custom::showDateTime($pair_item->expired_on, 'Y/m/d H:i:s') }}", function (event) {
                $(this).text(
                        event.strftime('%D days %H:%M:%S')
                        );
            });



    $('#confirm_ph_payment').parsley();
    $('#message_form').parsley();
    $('a.colorbox').colorbox();

    $('.swal_btn').click(function () {
        swal($(this).data('message-title'), $(this).data('message'), $(this).data('message-type'))
    });

    $('#message_form').submit(function () {

        $.ajax({
            type: 'post',
            url: $('#message_form').attr('action'),
            data: $('#message_form').serialize(),
            success: function (data) {

                if (data.status == '1') {
                    $('#message_form')[0].reset();

                    $chatLi = $('.chat-list').find('.hidden_chat').clone()
                    $chatLi.removeClass('hide');

                    $chatLi.find('h4').html(data.message_content.username);
                    $chatLi.find('b').html(data.message_content.time);
                    $chatLi.find('p').html(data.message_content.message);
                    $chatLi.find('img').attr('src', data.message_content.image);

                    $chatLi.appendTo('.chat-list');

                } else {
                    swal('Error!', data.message, 'error');
                }
            },
            error: function (e) {
                swal('Error!', 'Error while connecting with server.', 'error');
            }
        });

        return false;
    });

    $('.send_message').click(function () {
        $("html, body").animate({scrollTop: $(document).height()}, 1000);
    });

});
</script>
@stop