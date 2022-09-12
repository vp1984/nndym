@extends('admin.layouts.default')

@section('title', 'Edit '.VIEW_INFO['title'])

@section('content_header')
<h3 class="kt-subheader__title">{{ VIEW_INFO['title'] }} Managment</h3>
<span class="kt-subheader__separator kt-hidden"></span>
<div class="kt-subheader__breadcrumbs">
    <a href="{{ url('admin/dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ url('admin/user') }}" class="kt-subheader__breadcrumbs-link">{{VIEW_INFO['title']}}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="#" class="kt-subheader__breadcrumbs-link">Update {{ VIEW_INFO['title'] }} Details</a>

    <!-- <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Active link</span> -->
</div>
@stop

@section('content')
<!-- Main content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-md-12">
    
                <!--begin::Portlet-->
                <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                        Edit {{ VIEW_INFO['title'] }}
                                </h3>
                            </div>
                        </div>
                        <!--begin::Form-->
                        <form enctype="multipart/form-data" id="frmAddEdit" name="frmAddEdit" action="{{ url(VIEW_INFO['url'].'/edit/'.$data->id) }}" class="form-horizontal" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" id="id" value="{{ $data->id }}">
                            <div class="kt-portlet__body">
                                    <div class="form-group form-group-last">
                                            <div class="alert alert-secondary" role="alert">
                                                <div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
                                                <div class="alert-text">
                                                        <code>*</code> indicates a required field.
                                                </div>
                                            </div>
                                        </div>

                                        @include('admin.includes.errormessage')
                                      
                                        <div class="form-group">
                                <label>Name<span class="required">*</span></label>
                                <input type="text" id="name" name="name" data-toggle="tooltip" title=" Name" class="form-control" placeholder="Enter  Name" value="{{ $data['name'] }}" />
                            </div>
                            <div class="form-group">
                                <label>Email<span class="required">*</span></label>
                                <input type="text" id="email" name="email" data-toggle="tooltip" title="Email"
                                        class="form-control" placeholder="Email" value="{{ $data['email']    }}">
                            </div>
                            <div class="form-group">
                                <label>Role<span class="required"><code>*</code></span></label>
                                <div>
                                <select name="role_id[]" id="role_id" class="form-control select2" multiple="multiple">
                                    <option value="">-Select Role-</option>
                                        @if(isset($arrRole) && !empty($arrRole))
                                            @foreach($arrRole as $key=>$val)
                                            <option value="{{ $val->id }}" {{ in_array($val->id,explode(",",$data['role_id'])) ? 'selected' : '' }} >{{ $val->name }}</option>
                                            @endforeach
                                        @endif
                                </select>
                                </div>
                            </div>  
                            <div class="form-group">
                                <label>Image Upload<span class="required">*</span></label>
                                <input type="file" id="file" name="file" data-toggle="tooltip" title="file"
                                        class="form-control" placeholder="profile photo" value="{{ old('profile_photo') }}">
                                @if(in_array(pathinfo($data->profile_photo, PATHINFO_EXTENSION),array('png','jpg','jpeg','bmp')))
                                    <img src="{{url($arrFile['path'].$arrFile['resize'].'x'.$arrFile['resize'].'/'.$data->profile_photo)}}" alt="image">
                                @elseif(in_array(pathinfo($data->profile_photo, PATHINFO_EXTENSION),array('mp4')))
                                    <img src="{{url($arrFile['path'].$arrFile['resize'].'x'.$arrFile['resize'].'/'.str_replace(pathinfo($data->profile_photo, PATHINFO_EXTENSION),'png',$data->media_file))}}" alt="image">
                                @else
                                    <a href="{{url($arrFile['path'].$arrFile['resize'].'x'.$arrFile['resize'].'/'.$data->profile_photo)}}">{{$data->profile_photo}}</a>
                                @endif        
                            </div>
                                <div class="form-group">
                                    <label for="exampleSelect1">Status<span class="required">*</span></label>
                                    <select class="form-control" id="status" name="status">
                                        <option {{($data['status'] == 1 ? 'selected' : '')}} value="1">Active</option>
                                        <option {{($data['status'] == 0 ? 'selected' : '')}} value="0">Inactive</option>
                                    </select>
                                </div>
    
                                
                            <div class="kt-portlet__foot">
                                <div class="kt-form__actions">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" id="reset" class="btn btn-secondary">Reset</button>
                                    <a href="{{ url(VIEW_INFO['url']) }}"><button type="button" class="btn btn-success"
                                        id="back">Cancel</button></a>
                                </div>
                            </div>
                        </form>
    
                        <!--end::Form-->
                    </div>
    
                    <!--end::Portlet-->
            </div>
        </div>
    </div>
<!-- Main content -->
@stop

@section('metronic_js')
<script src="{{ asset('admin/assets/js/pages/custom/user.js') }}"></script>
@stop