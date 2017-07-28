@if(Session::has('success_message'))
<div class='container'>
    <div class='row'>
        <div class='alert alert-success'>
            {{ Session::get('success_message')}}
        </div>        
    </div>
</div>    
@endif

@if(Session::has('error_message'))
<div class='container'>
    <div class='row'>
        <div class='alert alert-danger'>
            {{ Session::get('error_message')}}
        </div>
    </div>
</div>    
@endif
