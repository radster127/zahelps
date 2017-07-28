<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('GH User') !!}
            {!! Form::text('gh_user_id', null, ['id' => 'gh_user_id', 'class' => 'form-control', 'placeholder' => 'GH User', 'required' => 'required']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('PH User') !!}
            {!! Form::text('ph_user_id', null, ['id' => 'ph_user_id', 'class' => 'form-control', 'placeholder' => 'PH User', 'required' => 'required']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('Amount') !!}
            {!! Form::text('amount', null, ['class' => 'form-control', 'placeholder' => 'Amount', 'required' => 'required']) !!}
        </div>
    </div>
    <?php /*<div class="col-md-6">
        <div class="form-group">
            {!! Form::label('Status') !!}
            {!! Form::select('status', ['approved' => 'Approved', 'paired' => 'Pair Only'], null, ['class' => 'form-control', 'required' => 'required']) !!}
        </div>
    </div>*/ ?>
</div>

<hr/>

<button type="submit" class="btn btn-info pull-right waves-effect waves-light">Submit</button>