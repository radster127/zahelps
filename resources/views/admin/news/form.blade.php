<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('Subject') !!}
            {!! Form::text('subject', null, ['class' => 'form-control', 'placeholder' => 'Enter Subject', 'required' => 'required']) !!}
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('News') !!}
            {!! Form::textarea('news', null, ['class' => 'form-control', 'placeholder' => 'Enter News', 'required' => 'required']) !!}
        </div>
    </div>
</div>

<hr/>

<button type="submit" class="btn btn-info pull-right waves-effect waves-light">Submit</button>