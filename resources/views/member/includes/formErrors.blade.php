@if (count($errors) > 0)
<div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Whoops!</strong> There were some problems with your input.
    <div class="clearfix m-b-5"></div>
    @foreach ($errors->all() as $error)
    {{ $error }}
    <div class="clearfix m-b-5"></div>
    @endforeach
</div>
@endif
