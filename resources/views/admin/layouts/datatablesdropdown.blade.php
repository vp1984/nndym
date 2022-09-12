@php
    $arrActionUrls = [ 
        $action_url.'/add',
        $action_url.'/view',
        $action_url.'/toggle',
        $action_url.'/delete',
        $action_url.'/export'
    ];    
@endphp    

@if(count(array_intersect($arrActionUrls, Session::get('routes'))) > 0)
    <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">Action
        <span class="fa fa-caret-down"></span></button>
    <ul class="dropdown-menu">
        @if(in_array($action_url.'/add',Session::get('routes')))
            <li><a href="{{ url($action_url.'/add') }}">Add</a></li>
        @endif
        @if(in_array($action_url.'/toggle',Session::get('routes')))
            <li><a class="dropdown-item toggle_status" data-type="1" href="#">Bulk Active</a></li>
        @endif
        @if(in_array($action_url.'/toggle',Session::get('routes')))
            <li><a class="dropdown-item toggle_status" data-type="0" href="#">Bulk Inactive</a></li>
        @endif
        @if(in_array($action_url.'/delete',Session::get('routes')))
            <li><a class="dropdown-item delete_rows" href="#">Bulk Delete</a></li>
        @endif
        @if(in_array($action_url.'/export',Session::get('routes')))
            <li><a class="dropdown-item" href="{{ url($action_url.'/export') }}">Export</a></li>
        @endif    
    </ul>
@endif