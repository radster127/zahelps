<?php
$pageTitle = "Broadcast Message";

$breadCrumbArray = array(
    'Home' => url('admin'),
    $pageTitle => '',
);
?>
@extends('admin.layout')

@section('title', $pageTitle)
@section('content')
@include('admin.includes.breadcrumb')
@include('admin.includes.flashMsg')

<div class="box box-block bg-white">

    <!-- end row -->

    <div class="row">
        <div class="col-sm-12">
            @include('admin.includes.formErrors')

            {!! Form::open(['method' => 'POST', 'url' => url('admin/send-broadcast'), 'class' => 'module_form']) !!}

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('Send To') !!}
                        {!! Form::select('send_to', ['all' => 'All', 'newsletter' => 'Newsletter Subscribers', 'active_users' => 'Active Users' , 'suspended_users' => 'Suspended Users'], null ,['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('Subject') !!}
                        {!! Form::text('subject', null, ['class' => 'form-control', 'placeholder' => 'Subject:', 'required' => 'required']) !!}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label ('Message:') !!}
                        {!! Form::textarea('message', null, ['class' => 'textarea_editor form-control', 'rows' => 15, 'placeholder' => 'Your Message...']) !!}
                        <input name="image" type="file" id="upload" class="hide" onchange="">
                    </div>
                </div>
            </div>

            <hr/>

            <button type="submit" class="btn btn-info pull-right waves-effect waves-light">Send</button>

            {!! Form::close() !!}

        </div> <!-- end col -->
    </div>
    <!-- end row -->

</div>

@stop
@section('page_js')

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script type="text/javascript">

  $(document).ready(function () {
      tinymce.init({
          selector: ".textarea_editor",
          theme: "modern",
          paste_data_images: true,
          plugins: [
              "advlist autolink lists link image charmap print preview hr anchor pagebreak",
              "searchreplace wordcount visualblocks visualchars code fullscreen",
              "insertdatetime media nonbreaking save table contextmenu directionality",
              "emoticons template paste textcolor colorpicker textpattern"
          ],
          toolbar1: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
          toolbar2: "print preview media | forecolor backcolor emoticons",
          image_advtab: true,
          file_picker_callback: function (callback, value, meta) {
              if (meta.filetype == 'image') {
                  $('#upload').trigger('click');
                  $('#upload').on('change', function () {
                      var file = this.files[0];
                      var reader = new FileReader();
                      reader.onload = function (e) {
                          callback(e.target.result, {
                              alt: ''
                          });
                      };
                      reader.readAsDataURL(file);
                  });
              }
          },
          templates: [{
                  title: 'Test template 1',
                  content: 'Test 1'
              }, {
                  title: 'Test template 2',
                  content: 'Test 2'
              }]
      });
  });

</script>


@stop