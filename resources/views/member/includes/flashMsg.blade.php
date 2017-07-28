@if(Session::has('success_message'))
<div class='alert alert-success'>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {{ Session::get('success_message')}}
</div>        
@endif

@if(Session::has('error_message'))
<div class='alert alert-danger'>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {{ Session::get('error_message')}}
</div>
@endif
