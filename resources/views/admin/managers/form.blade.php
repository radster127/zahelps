<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('Name') !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Name', 'required' => 'required']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('Minimum Down Line') !!}
            {!! Form::text('minimum_down_line', null, ['class' => 'form-control', 'placeholder' => 'Enter Minimum Down Line', 'required' => 'required', 'data-parsley-type' => 'integer']) !!}
        </div>
    </div>
</div>
<hr/>
<button type="submit" class="btn btn-info pull-right waves-effect waves-light">Submit</button>