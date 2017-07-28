@extends('admin.layout')

@section('title', $pageTitle)
@section('content')

<?php
$breadCrumbArray = array(
    'Home' => url('admin'),
    $pageTitle => '',
);
?>

@include('admin.includes.breadcrumb')


<div class="box box-block bg-white">

    <?php /* <h5>Form controls</h5>
      <p class="font-90 text-muted mb-1">Bootstrap provides several form control styles, layout options, and custom components for creating a wide variety of forms.</p>

      <hr/> */ ?>

    @include('admin.includes.formErrors')
    @include('admin.includes.flashMsg')


    {!! Form::open(['url' => url('admin/settings'), 'method' => 'post', 'class' => 'setting_form module_form', 'id' => 'setting_form']) !!}
    <div class="row">
        <div class="col-md-6">



            @if (isset($settings) && count($settings) > 0)

            @foreach ($settings as $key=>$item)

            @if ($item->name == 'hr')
            <hr/>

            @elseif ($item->name == 'h4')
            <h4>{{ $item->title }}</h4>

            @elseif ($item->name == 'br')
        </div><div class="col-md-6">
            @elseif($item->field_type == 'text')
            <div class="form-group">
                <label>{{ $item->title }}</label>

                <?php
                $field_array = [ 'class' => 'form-control'];

                if ($item->required == '1') {
                  $field_array['data-parsley-required'] = 'required';
                }
                if ($item->min_length > 0) {
                  $field_array['data-parsley-minlength'] = $item->min_length;
                }
                if ($item->max_length > 0) {
                  $field_array['data-parsley-maxlength'] = $item->max_length;
                }
                if ($item->min_value > 0) {
                  $field_array['data-parsley-min'] = $item->min_value;
                }
                if ($item->max_value > 0) {
                  $field_array['data-parsley-max'] = $item->max_value;
                }
                ?>

                {!! Form::text('settings[' . $item->id . ']', $item->value, $field_array) !!}
                @if ($item->help_text != '')
                <small id="emailHelp" class="form-text text-muted">{!! $item->help_text !!}</small>
                @endif
            </div>
            @elseif($item->field_type == 'textarea')
            <div class="form-group">
                <label>{{ $item->title }}</label>

                <?php
                $field_array = [ 'class' => 'form-control'];

                if ($item->required == '1') {
                  $field_array['data-parsley-required'] = 'required';
                }
                if ($item->min_length > 0) {
                  $field_array['data-parsley-minlength'] = $item->min_length;
                }
                if ($item->max_length > 0) {
                  $field_array['data-parsley-maxlength'] = $item->max_length;
                }
                if ($item->min_value > 0) {
                  $field_array['data-parsley-min'] = $item->min_value;
                }
                if ($item->max_value > 0) {
                  $field_array['data-parsley-max'] = $item->max_value;
                }
                ?>

                {!! Form::textarea('settings[' . $item->id . ']', $item->value, $field_array) !!}
                @if ($item->help_text != '')
                <small id="emailHelp" class="form-text text-muted">{!! $item->help_text !!}</small>
                @endif
            </div>
            @elseif($item->field_type == 'radio')
            <div class="form-group">
                <label>{{ $item->title }}</label>

                @if ($item->field_options != '')
                <?php $options = explode(",", $item->field_options); ?>

                <?php foreach ($options as $optVal): ?>
                  <?php $option = explode(":", $optVal); ?>
                  <div class="form-check">
                      <label class="form-check-label">
                          <input class="form-check-input" name="settings[{{ $item->id }}]" id="exampleRadios1" value="{{ $option[0] }}" <?php echo $item->value == $option[0] ? 'checked' : '' ?> type="radio">
                          {{ $option[1] }}
                      </label>
                  </div>
                <?php endforeach; ?>
                @if ($item->help_text != '')
                <small id="emailHelp" class="form-text text-muted">{!! $item->help_text !!}</small>
                @endif

                @endif

            </div>
            @elseif($item->field_type == 'select')
            <div class="form-group">
                <label>{{ $item->title }}</label>

                <select name="settings[{{ $item->id }}]" class="form-control"> 
                    @if ($item->field_options != '')
                    <?php $options = explode(",", $item->field_options); ?>
                    <?php foreach ($options as $optVal): ?>
                      <?php $option = explode(":", $optVal); ?>
                      <option value="{{ $option[0] }}" <?php echo $item->value == $option[0] ? 'selected' : '' ?>>{{ $option[1] }}</option>
                    <?php endforeach; ?>
                </select>
                @if ($item->help_text != '')
                <small id="emailHelp" class="form-text text-muted">{!! $item->help_text !!}</small>
                @endif

                @endif

            </div>
            @endif

            @endforeach

            @endif

        </div>
    </div>
    <hr/>
    <button type="submit" class="btn btn-primary btn-lg">Submit</button>

    {!! Form::close() !!}



</div>

@stop