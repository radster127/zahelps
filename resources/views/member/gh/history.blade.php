<?php
$pageTitle = $gh_settings['name']." history";

$breadCrumbArray = array(
    'Home' => url('/member'),
    $pageTitle => '',
);
?>
@extends('member.layout')

@section('title', $pageTitle)
@section('content')
@include('member.includes.breadcrumb')

<div class="col-md-12">

    <div class="row">

        <div class="col-lg-8 col-sm-12">

            @include('member.dashboard._gh_paired_list')


        </div>

        <div class="col-lg-4 col-sm-12">
            @include('member.dashboard._ph_pending_list')
            @include('member.dashboard._gh_pending_list')
        </div>
    </div>



</div>


@stop
@section('page_js')


<script type="text/javascript">
  $(function () {
      //Warning Message
      $('.delete-ph').click(function () {
          var ph_id = $(this).data('ph_id');
          var panel = $(this).closest('.panel');
          swal({
              title: "Are you sure?",
              text: "You will not be able to recover this ph request again!",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Yes, delete it!",
              closeOnConfirm: false
          }, function () {

              $.ajax({
                  type: 'post',
                  url: '{{ url("member/cancel-ph") }}',
                  data: {'_token': "{{ csrf_token() }}", 'ph_id': ph_id},
                  success: function (data) {
                      if (data.status == 0) {
                          swal("Error!", data.message, "error");
                      } else {
                          panel.remove();
                          swal("Deleted!", data.message, "success");
                      }
                  },
                  error: function (e) {
                      swal("Error!", "There is an error to delete your PH, Kindly try again or contact Admin.", "error");
                  }

              });
              swal("Deleted!", "Your imaginary file has been deleted.", "success");
          });
      });
  });

</script>
@stop