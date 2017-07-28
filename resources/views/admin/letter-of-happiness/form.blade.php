<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('Subject/Title') !!}
            {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter Subject/Title', 'required' => 'required']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('Status') !!}
            {!! Form::select('status', ['pending' => 'Pending', 'approved' => 'Approved'], null, ['class' => 'form-control', 'required' => 'required']) !!}
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('Content/Message') !!}
            {!! Form::textarea('content', null, ['class' => 'form-control', 'placeholder' => 'Enter Content/Message', 'required' => 'required']) !!}
        </div>
    </div>
</div>

<hr/>

<button type="submit" class="btn btn-info pull-right waves-effect waves-light">Submit</button>