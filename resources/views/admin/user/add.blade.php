@extends('admin.layouts.default')

@section('title', 'Add '.VIEW_INFO['title'])


@section('content_header')
<h3 class="kt-subheader__title">{{ VIEW_INFO['title'] }} Managment</h3>
<span class="kt-subheader__separator kt-hidden"></span>
<div class="kt-subheader__breadcrumbs">
    <a href="{{ url('admin/dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ url('admin/module') }}" class="kt-subheader__breadcrumbs-link">{{VIEW_INFO['title']}}</a>
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
                                    Add {{ VIEW_INFO['title'] }}
                            </h3>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form enctype="multipart/form-data" id="frmAddEdit" name="frmAddEdit" action="{{ url(VIEW_INFO['url'].'/add') }}" class="kt-form" method="post">
                        {{ csrf_field() }}
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
                                <input type="text" id="name" name="name" data-toggle="tooltip" title=" Name" class="form-control" placeholder="Enter  Name" value="{{ old('name') }}" />
                            </div>
                            <div class="form-group">
                                <label>Email<span class="required">*</span></label>
                                <input type="text" id="email" name="email" data-toggle="tooltip" title="Email"
                                        class="form-control" placeholder="Email" value="{{ old('email') }}">
                            </div>
                            <div class="form-group">
                                <label>Password<span class="required">*</span></label>
                                <input type="password" id="password" name="password" data-toggle="tooltip" title="Password"
                                        class="form-control" placeholder="Password" value="{{ old('password') }}">
                            </div>
                            <!-- <div class="form-group">
                                <label>Re-Password<span class="required">*</span></label>
                                <input type="text" id="re_password" name="re_password" data-toggle="tooltip" title="Re-Password"
                                        class="form-control" placeholder="Re-Password" value="{{ old('re_password') }}">
                            </div> -->
                       
                            <div class="form-group">
                                <label>Role<span class="required"><code>*</code></span></label>
                                <div>
                                <select name="role_id" id="role_id" class="form-control">
                                    <option value="">-Select Role-</option>
                                        @if(isset($arrRole) && !empty($arrRole))
                                            @foreach($arrRole as $key=>$val)
                                            <option value="{{ $val->id }}" {{ old('role_id') == $val->id ? 'selected' : '' }} >{{ $val->name }}</option>
                                            @endforeach
                                        @endif
                                </select>
                                </div>
                            </div>  
                            <!-- <div class="form-group form-group-last ">
                                <label>Upload Image</label>
                                <div class="col-lg-9">
                                <div class="dropzone dropzone-multi" id="kt_dropzone_4">
                                    <div class="dropzone-panel">
                                        <a class="dropzone-select btn btn-label-brand btn-bold btn-sm">Attach files</a>
                                        <a class="dropzone-upload btn btn-label-brand btn-bold btn-sm">Upload All</a>
                                        <a class="dropzone-remove-all btn btn-label-brand btn-bold btn-sm">Remove All</a>
                                    </div>
                                    <div class="dropzone-items">
                                        <div class="dropzone-item" style="display:none">
                                            <div class="dropzone-file">
                                                <div class="dropzone-filename" title="some_image_file_name.jpg"><span data-dz-name>some_image_file_name.jpg</span> <strong>(<span  data-dz-size>340kb</span>)</strong></div>
                                                <div class="dropzone-error" data-dz-errormessage></div>
                                            </div>
                                            <div class="dropzone-progress">
                                                <div class="progress">
                                                    <div class="progress-bar kt-bg-brand" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" data-dz-uploadprogress></div>
                                                </div>
                                            </div>
                                            <div class="dropzone-toolbar">
                                                <span class="dropzone-start"><i class="flaticon2-arrow"></i></span>
                                                <span class="dropzone-cancel" data-dz-remove style="display: none;"><i class="flaticon2-cross"></i></span>
                                                <span class="dropzone-delete" data-dz-remove><i class="flaticon2-cross"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <span class="form-text text-muted">Max file size is 1MB and max number of files is 5.</span>
                                </div>
                                </div>
                            </div> -->
                            <div class="form-group">
                                <label>Image Upload<span class="required">*</span></label>
                                <input type="file" id="file" name="file" data-toggle="tooltip" title="file"
                                        class="form-control" placeholder="profile photo" value="{{ old('profile_photo') }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleSelect1">Status<span class="required">*</span></label>
                                <select class="form-control" id="status" name="status">
                                        <option value="1" selected>Active</option>
                                        <option value="0">Inactive</option>
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
<script src="{{ asset('admin/assets/js/pages/crud/file-upload/dropzonejs.js')}}" type="text/javascript"></script>
@stop