@extends('admin.layouts.default')  

@section('title', 'View '.VIEW_INFO['title'])

@section('content_header')
<h3 class="kt-subheader__title">{{ VIEW_INFO['title'] }} Managment</h3>
<span class="kt-subheader__separator kt-hidden"></span>
<div class="kt-subheader__breadcrumbs">
    <a href="{{ url('admin/dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ url('admin/user') }}" class="kt-subheader__breadcrumbs-link">{{VIEW_INFO['title']}}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="#" class="kt-subheader__breadcrumbs-link">View {{ VIEW_INFO['title'] }} Details</a>

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
								View {{ VIEW_INFO['title'] }}
						</h3>
					</div>
				</div>
					<!--begin::Form-->
					<form id="frmAddEdit" name="frmAddEdit" action="{{ url(VIEW_INFO['url'].'/view/'.$userDetails->id) }}" class="form-horizontal" method="post">{{ csrf_field() }}
						<input type="hidden" name="id" id="id" value="{{ $userDetails->id }}">
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
							<div class="box-body">
								<div class="form-group">
									<label class="col-md-3">Name<span class="required"><code>*</code></span></label>
									<input type="text" id="name" name="name" data-toggle="tooltip" title="Enter Name" 
										class="form-control" placeholder="Enter Name" value="{{ $userDetails->name }}" readonly>
								</div> 
								<div class="form-group">
									<label>Email<span class="required">*</span></label>
									<input type="text" id="email" name="email" data-toggle="tooltip" title="Email"
										class="form-control" placeholder="Email" value="{{ $userDetails->email}}">
                            	</div>		
								<div class="form-group">
								<label>Role <span class="text-danger">*</span></label>
								<select name="role_id[]" id="role_id" class="form-control select2" multiple="multiple">
									<option value="">-Select-</option>
									<?php
									if(isset($roles) && !empty($roles)){
										foreach($roles as $key=>$val){
											echo "<option  value =".$val->id." ".(in_array($val->id,explode(',',$userDetails->role_id)) ? " selected='selected' " : '' )."> $val->name </option>"; 						
										}
									}
									?>
								</select>
						@if($errors->has('practice_id'))
							<div class="error text-danger">{{ $errors->first('practice_id') }}</div>
						@endif	
					</div>
					<div class="kt-portlet__foot">
									<div class="kt-form__actions">
										<!-- <button type="submit" class="btn btn-primary">Submit</button>
										<button type="button" id="reset" class="btn btn-secondary">Reset</button> -->
										<a href="{{ url(VIEW_INFO['url']) }}"><button type="button" class="btn btn-danger"
											id="back">Back</button></a>
									</div>
								</div>	
					<div class="rights"></div>
					<br>
								<div class="form-group">
									<label class="col-md-3">Status<span class="required"><code>*</code></span></label>
									<select name="status" id="status" class="form-control" disabled>
										<option {{($userDetails->status == 1 ? 'selected' : '')}} value="1">Active</option>
										<option {{($userDetails->status == 0 ? 'selected' : '')}} value="0">Inactive</option>
									</select>
								</div>
									
								
								</div>
						</div>
						<div class="border-top">
				<div class="card-body">
					<button type="submit" class="btn btn-success">Save</button>
					<a href="{{ url('/admin/user') }}"><button type="button" class="btn btn-danger" id="back">Back</button></a>
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
<script src="{{ asset('admin/assets/js/pages/custom/rights_of_roles.js') }}"></script>
<script src="{{ asset('admin/assets/js/pages/custom/role.js') }}"></script>
<script src="{{ asset('admin/assets/js/pages/custom/user.js') }}"></script>

@stop