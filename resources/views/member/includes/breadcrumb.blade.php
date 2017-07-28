@if ((isset($breadCrumbArray) && count ($breadCrumbArray) > 0) || (isset($pageTitle) && $pageTitle != ''))
<div class="row bg-title">
    @if(isset($pageTitle) && $pageTitle != '')
    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
        <h4 class="page-title">{{ $pageTitle }}</h4>
    </div>
    @endif
    
    @if (isset($breadCrumbArray) && count ($breadCrumbArray) > 0)
    <div class="col-lg-7 col-sm-7 col-md-7 col-xs-12">
        <ol class="breadcrumb">
            @foreach ($breadCrumbArray as $itemKey=>$itemVal)
            @if ($itemVal != '')
            <li><a href="{{ url($itemVal) }}">{{ $itemKey }}</a></li>
            @else
            <li class="active">{{ $itemKey }}</li>
            @endif
            @endforeach
        </ol>
    </div>
    @endif
</div>
@endif
