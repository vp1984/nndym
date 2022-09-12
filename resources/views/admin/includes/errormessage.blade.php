@if(Session::has('flash_error') || Session::has('flash_message_error'))

<div class="alert alert-bold alert-solid-danger alert-dismissible" role="alert">
    <div class="alert-text">
        {!! session('flash_message_error') ? session('flash_message_error') : session('flash_error'); !!}    
        @php Session::forget('flash_message_error'); Session::forget('flash_error'); @endphp
    </div>
    <div class="alert-close"><i class="flaticon2-cross kt-icon-sm" data-dismiss="alert"></i></div>
</div>
@endif
@if(Session::has('flash_message_success'))
<div class="alert alert-bold alert-solid-success alert-dismissible" role="alert">
    <div class="alert-text">
        {!! session('flash_message_success') !!}
        @php Session::forget('flash_message_success') @endphp
    </div>
    <div class="alert-close"><i class="flaticon2-cross kt-icon-sm" data-dismiss="alert"></i></div>
</div>
@endif