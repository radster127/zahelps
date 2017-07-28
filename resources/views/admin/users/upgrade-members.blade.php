<?php

use \App\Custom;

$moduleSingularName = 'User';
$modulePluralName = 'Users';

$pageTitle = "Upgrade Members";
$moduleTitle = $pageTitle;
$module = 'users';

//$add_url = route('admin.' . $module . '.create');
$edit_url = 'admin.' . $module . '.edit';
$suspend_url = 'admin.' . $module . '.suspend';
$delete_url = 'admin.' . $module . '.destroy';
$list_url = route('admin.' . $module . ".index");

$breadCrumbArray = array(
    'Home' => url('admin'),
    'Upgrade To Directors' => '',
);
?>


@extends('admin.layout')

@section('title', $pageTitle)
@section('content')

@include('admin.includes.breadcrumb')
@include('admin.includes.flashMsg')


<div class="box box-block bg-white">


    <h4>Directors</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Full name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Direct Referrals</th>
                    <th>Action</th>
                </tr>
            </thead>


            <tbody>
                @if(isset($directors) && count($directors) > 0)
                @foreach($directors as $row)
                <tr>

                    <td>{{ $row->username }}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->email }}</td>
                    <td>{{ $row->phone }}</td>
                    <td>{{ $row->counter }}</td>

                    <td>
                        <div class="btn-group btn-group-solid">
                            <a onclick="return confirm('Are you sure to upgrade this user to director?')" title="Upgrade to Sr. Director" href="{{ route('upgrade-to-director', ['id' => $row->id, 'manager_id' => '1']) }}" class="btn btn-danger btn-sm"><i class="fa fa-heart-o"></i></a>
                        </div>
                    </td>

                </tr>
                @endforeach 
                @else
                <tr>
                    <td colspan="6">No Records Found.</td>
                </tr>                    
                @endif

            </tbody>

        </table>

    </div>  


</div>


<div class="box box-block bg-white">
    <h4>Sr. Directors</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Full name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Number of Directors</th>
                    <th>Action</th>
                </tr>
            </thead>


            <tbody>
                @if(isset($sr_directors) && count($sr_directors) > 0)
                @foreach($sr_directors as $row)
                <tr>

                    <td>{{ $row->username }}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->email }}</td>
                    <td>{{ $row->phone }}</td>
                    <td>{{ $row->counter }}</td>

                    <td>
                        <div class="btn-group btn-group-solid">
                            <a onclick="return confirm('Are you sure to upgrade this user to Sr. director?')" title="Upgrade to Director" href="{{ route('upgrade-to-director', ['id' => $row->id, 'manager_id' => '2']) }}" class="btn btn-danger btn-sm"><i class="fa fa-heart-o"></i></a>
                        </div>
                    </td>

                </tr>
                @endforeach 
                @else
                <tr>
                    <td colspan="6">No Records Found.</td>
                </tr>                    
                @endif

            </tbody>

        </table>

    </div>  
</div>

<div class="box box-block bg-white">
    <h4>Principal Directors</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Full name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Number of Sr. Directors</th>
                    <th>Action</th>
                </tr>
            </thead>


            <tbody>
                @if(isset($principal_directors) && count($principal_directors) > 0)
                @foreach($principal_directors as $row)
                <tr>

                    <td>{{ $row->username }}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->email }}</td>
                    <td>{{ $row->phone }}</td>
                    <td>{{ $row->counter }}</td>

                    <td>
                        <div class="btn-group btn-group-solid">
                            <a onclick="return confirm('Are you sure to upgrade this user to Principal director?')" title="Upgrade to Principal Director" href="{{ route('upgrade-to-director', ['id' => $row->id, 'manager_id' => '3']) }}" class="btn btn-danger btn-sm"><i class="fa fa-heart-o"></i></a>
                        </div>
                    </td>

                </tr>
                @endforeach 
                @else
                <tr>
                    <td colspan="6">No Records Found.</td>
                </tr>                    
                @endif

            </tbody>

        </table>

    </div>  
</div>

<div class="box box-block bg-white">
    <h4>Chief Directors</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Full name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Number of Principal Directors</th>
                    <th>Action</th>
                </tr>
            </thead>


            <tbody>
                @if(isset($chief_directors) && count($chief_directors) > 0)
                @foreach($chief_directors as $row)
                <tr>

                    <td>{{ $row->username }}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->email }}</td>
                    <td>{{ $row->phone }}</td>
                    <td>{{ $row->counter }}</td>

                    <td>
                        <div class="btn-group btn-group-solid">
                            <a onclick="return confirm('Are you sure to upgrade this user to Chief director?')" title="Upgrade to Chief Director" href="{{ route('upgrade-to-director', ['id' => $row->id, 'manager_id' => '4']) }}" class="btn btn-danger btn-sm"><i class="fa fa-heart-o"></i></a>
                        </div>
                    </td>

                </tr>
                @endforeach 
                @else
                <tr>
                    <td colspan="6">No Records Found.</td>
                </tr>                    
                @endif

            </tbody>

        </table>

    </div>  
</div>

@stop

@section ('page_js')
<script type="text/javascript">
  $(function () {
      $('#change_password_form').parsley();

      $('.resetPasswordBtn').click(function () {
          $id = $(this).data('id');
          $user = $(this).data('user');

          $('#change_password_form').find('span').html($user);
          $('#change_password_form').find('#user_id').val($id);
          $('#change_password_form').find('.alert').addClass('hide');

      });

      $('#change_password_form').submit(function (e) {
          $.ajax({
              type: 'post',
              url: $('#change_password_form').attr('action'),
              data: $('#change_password_form').serialize(),
              success: function (data) {
                  $('#change_password_form')[0].reset();
                  $('#change_password_form').find('.alert').html(data.message).removeClass('hide');
              },
              error: function () {
                  $('#change_password_form').find('.alert').html(data.message).removeClass('hide').addClass('alert-danger');
              }
          });
          e.preventDefault();
          return false;
      })
  })
</script>
@stop