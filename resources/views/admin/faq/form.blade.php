<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('Title') !!}
            {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter Title', 'required' => 'required']) !!}
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('Content') !!}
            {!! Form::textarea('content', null, ['class' => 'form-control', 'placeholder' => 'Enter Content', 'id' => 'content']) !!}
        </div>
    </div>
</div>

<hr/>

<button type="submit" class="btn btn-info pull-right waves-effect waves-light">Submit</button>

@section('page_js')
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
  //tinymce.init({selector: '#content'});
  tinymce.init({
      selector: '#content',
      height: 250,
      menubar: false,
      plugins: [
          'advlist autolink lists link image charmap print preview anchor',
          'searchreplace visualblocks code fullscreen',
          'insertdatetime media table contextmenu paste code'
      ],
      toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
      content_css: '//www.tinymce.com/css/codepen.min.css'
  });
</script>
@stop