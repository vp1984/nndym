@php
    $arrActionUrls = [ 
        $action_url.'/add',
		$action_url.'/edit',
        $action_url.'/view',
        $action_url.'/toggle',
        $action_url.'/delete',
        $action_url.'/export',
        $action_url.'/order',
        $action_url.'/copy',
    ];    
@endphp    

@if(count(array_intersect($arrActionUrls, Session::get('routes'))) > 0)
    <button type="button" class="btn btn-brand btn-icon-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="flaticon2-plus"></i> Add New
    </button>
    <div class="dropdown-menu dropdown-menu-right">
        <ul class="kt-nav">
            <li class="kt-nav__section kt-nav__section--first">
                <span class="kt-nav__section-text">Choose an action:</span>
            </li>
            @if(in_array($action_url.'/add',Session::get('routes')))
            <li class="kt-nav__item">
                <a href="{{ url($action_url.'/add') }}" class="kt-nav__link">
                    <i class="kt-nav__link-icon flaticon-add"></i>
                    <span class="kt-nav__link-text">Add</span>
                </a>
            </li>
            @endif
            @if(in_array($action_url.'/export',Session::get('routes')))
            <li class="kt-nav__item">
                <a href="{{ url($action_url.'/export') }}" class="kt-nav__link">
                    <i class="kt-nav__link-icon flaticon2-download-1"></i>
                    <span class="kt-nav__link-text">Export</span>
                </a>
            </li>
            @endif
        </ul>
    </div>
    <script>
        isViewStatus = false;
        isChangeStatus = false;
        isUpdateStatus = false;
        isDeleteStatus = false;
        isExportStatus = false;
        isOrderStatus = false;
        isCopyStatus = false;
    </script>
    @if(in_array($action_url.'/view',Session::get('routes')))
    <script>
        isViewStatus = true;
        viewURL = '<?php echo $action_url;?>'+'/view';
    </script>
    @endif
    @if(in_array($action_url.'/toggle',Session::get('routes')))
    <script>
        isChangeStatus = true;
        toggleURL = '<?php echo $action_url;?>'+'/toggle';
    </script>
    @endif
    @if(in_array($action_url.'/edit',Session::get('routes')))
    <script>
        isUpdateStatus = true;
        editURL = '<?php echo $action_url;?>'+'/edit';
    </script>
    @endif
    @if(in_array($action_url.'/delete',Session::get('routes')))
    <script>
        isDeleteStatus = true;
        deleteURL = '<?php echo $action_url;?>'+'/delete';
    </script>
    @endif
    @if(in_array($action_url.'/export',Session::get('routes')))
    <script>
        isExportStatus = true;
        exportURL = '<?php echo $action_url;?>'+'/export';
    </script>
    @endif
    @if(in_array($action_url.'/order',Session::get('routes')))
    <script>
        isOrderStatus = true;
        orderURL = '<?php echo $action_url;?>'+'/order';
    </script>
    @endif
    @if(in_array($action_url.'/copy',Session::get('routes')))
    <script>
        isCopyStatus = true;
        copyURL = '<?php echo $action_url;?>'+'/copy';
    </script>
    @endif
@endif