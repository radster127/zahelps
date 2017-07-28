<h5>Personal Information</h5>
<hr/>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('Full Name') !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter full name', 'required' => 'required']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('Mobile Number') !!}
            {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Enter mobile number']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('Username') !!}
            {!! Form::text('username', null, ['class' => 'form-control', 'placeholder' => 'Enter username', 'readonly' => 'readonly']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('Registration Date') !!}
            {!! Form::text('joining_datetime', null, ['class' => 'form-control', 'placeholder' => 'Registration Date', 'readonly' => 'readonly']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('Email') !!}
            {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Enter email', 'readonly' => 'readonly']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('Upline Username') !!}
            {!! Form::text('uplineusername', $formObj->user_id > 0 ? $formObj->sponsor->username : null, ['class' => 'form-control', 'placeholder' => 'Enter username', 'readonly' => 'readonly']) !!}
        </div>
    </div>
</div>

<h5 class="box-title">Bank Information</h5>
<hr/>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('Bank Name') !!}
            {!! Form::text('bank_name', null, ['class' => 'form-control', 'placeholder' => 'Enter bank name', 'required' => 'required']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('Bank Account Number') !!}
            {!! Form::text('bank_account_number', null, ['class' => 'form-control', 'placeholder' => 'Enter bank account number', 'required' => 'required']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('Bank Account Holder') !!}
            {!! Form::text('bank_account_name', null, ['class' => 'form-control', 'placeholder' => 'Enter bank account name', 'required' => 'required']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('Bitcoin Address') !!}
            {!! Form::text('bitcoin', null, ['class' => 'form-control', 'placeholder' => 'Enter bitcoin address']) !!}
        </div>
    </div>
</div>

<h5 class="box-title m-t-40">Address Information</h5>
<hr/>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('Address') !!}
            {!! Form::text('address', null, ['class' => 'form-control', 'placeholder' => 'Enter address']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('City') !!}
            {!! Form::text('city', null, ['class' => 'form-control', 'placeholder' => 'Enter City']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('Country') !!}
            {!! Form::select('country_id', $countries, null , ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('Postal Code') !!}
            {!! Form::text('pincode', null, ['class' => 'form-control', 'placeholder' => 'Enter postal code']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('Referral Link') !!}
            {!! Form::text('referral_link', env('APP_URL') . '/member/' . $formObj->username, ['class' => 'form-control', 'readonly' => 'readonly', 'placeholder' => 'Enter referral link']) !!}
        </div>
    </div>
</div>

<h5 class="box-title m-t-40">Social Information</h5>
<hr/>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('Facebook') !!}
            {!! Form::text('facebook', null, ['class' => 'form-control', 'placeholder' => 'Enter Facebook Url']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('Twitter') !!}
            {!! Form::text('twitter', null, ['class' => 'form-control', 'placeholder' => 'Enter Twitter Url']) !!}
        </div>
    </div>
</div>

<hr/>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Subscribe for newsletter</label>
            {!! Form::select('newsletter', ['0' => 'No', '1' => 'Yes'], null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<hr/>

<button type="submit" class="btn btn-info pull-right waves-effect waves-light">Submit</button>