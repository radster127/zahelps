<div class="white-box">
    @if (isset($moduleTitle))
    <h5 class="panel-title"><b>Search {{ $moduleTitle }}</b></h5>
    <hr/>
    @endif
    <form role="form" method="get">
        <input type="hidden" name="record_per_page" id="record_per_page" value="{{ Request::get('record_per_page') }}"/>
        <div class="row">
            @if(isset($with_date) && $with_date == 1)
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1">Start Date</label>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="dd/mm/yyyy" name="from_date" value="{{ Request::get('from_date') }}" id="start_date">
                        <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1">End Date</label>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="dd/mm/yyyy" name="to_date" value="{{ Request::get('to_date') }}" id="end_date">
                        <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                    </div>
                </div>
            </div>
            @endif
            <div class="col-md-3">
                <div class="form-group">
                    <label for="search_field">Search By</label>
                    <select name="search_field" class="form-control">
                        @foreach($searchColumns as $column => $title)
                        <option value="{{ $column }}" {{ Request::get('search_field') == $column ? 'selected="selected"' : "" }}>{{ $title }}</option>                        
                        @endforeach 
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="search_text">Search Text</label>
                    <input type="text" class="form-control" name="search_text" value="{{ Request::get('search_text') }}">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="">&nbsp;</label>
                    <div class="clearfix"></div>
                    <button type="submit" class="btn btn-primary">Search</button>
                    <button type="button" class="btn btn-black btn-reset">Reset</button>
                </div>
            </div>
        </div>
    </form>
</div>
