<div class="row">
    @if ((isset($breadCrumbArray) && count ($breadCrumbArray) > 0) || (isset($pageTitle) && $pageTitle != ''))

    <div class="col-sm-8">
        @if(isset($pageTitle) && $pageTitle != '')
        <h4>{{ $pageTitle }}</h4>
        @endif

        @if (isset($breadCrumbArray) && count ($breadCrumbArray) > 0)
        <ol class="breadcrumb no-bg mb-1">
            @foreach ($breadCrumbArray as $itemKey=>$itemVal)
            @if ($itemVal != '')
            <li class="breadcrumb-item"><a href="{{ url($itemVal) }}">{{ $itemKey }}</a></li>
            @else
            <li class="breadcrumb-item active">
                {{ $itemKey }}
            </li>
            @endif
            @endforeach
        </ol>
        @endif
    </div>
    @endif
    @if(isset($add_url) && $add_url != '')
    <div class="col-sm-4">
        <a href="{{ $add_url }}" class="btn w-min-lg btn-lg btn-primary pull-right">Add New</a>
    </div>
    @endif
    @if(isset($itemStatus) && $itemStatus != '')
    <div class="col-sm-4">
        @if ($itemStatus == 'pending')
        <a href="javascript:;" class="btn w-min-lg btn-lg btn-danger pull-right">{{ ucwords($itemStatus) }}</a>
        @elseif ($itemStatus == 'paired')
        <a href="javascript:;" class="btn w-min-lg btn-lg btn-info pull-right">{{ ucwords($itemStatus) }}</a>
        @elseif ($itemStatus == 'approved')
        <a href="javascript:;" class="btn w-min-lg btn-lg btn-success pull-right">{{ ucwords($itemStatus) }}</a>
        @endif
    </div>
    @endif
</div>