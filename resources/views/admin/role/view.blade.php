@extends('admin.layouts.default')  

@section('title', 'View '.VIEW_INFO['title'])

@section('content_header')
<h3 class="kt-subheader__title">{{ VIEW_INFO['title'] }} Managment</h3>
<span class="kt-subheader__separator kt-hidden"></span>
<div class="kt-subheader__breadcrumbs">
    <a href="{{ url('admin/dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ url('admin/role') }}" class="kt-subheader__breadcrumbs-link">{{VIEW_INFO['title']}}</a>
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
					<form id="frmAddEdit" name="frmAddEdit" action="{{ url(VIEW_INFO['url'].'/view/'.$roleDetails->id) }}" class="form-horizontal" method="post">{{ csrf_field() }}
						<input type="hidden" name="id" id="id" value="{{ $roleDetails->id }}">
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
									<input type="text" id="name" name="name" data-toggle="tooltip" title="Enter Name" class="form-control" placeholder="Enter Name" value="{{ $roleDetails->name }}" readonly>
								</div> 

								<div class="form-group">
									<label class="col-md-3">Status<span class="required"><code>*</code></span></label>
									<select name="status" id="status" class="form-control" disabled>
										<option {{($roleDetails->status == 1 ? 'selected' : '')}} value="1">Active</option>
										<option {{($roleDetails->status == 0 ? 'selected' : '')}} value="0">Inactive</option>
									</select>
								</div>
						
								<div class="kt-portlet__foot">
									<div class="kt-form__actions">
										<!-- <button type="submit" class="btn btn-primary">Submit</button>
										<button type="button" id="reset" class="btn btn-secondary">Reset</button> -->
										<a href="{{ url(VIEW_INFO['url']) }}"><button type="button" class="btn btn-danger"
											id="back">Back</button></a>
									</div>
								</div>
			
							<div class="card">
								<div class="card-body">
									<h4 class="card-title">Module Permission</h4>
									<div class="card m-b-0 no-border">
										<div class="col-md-12">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input" id="checkAll">
												<label class="custom-control-label" for="checkAll">Check / Uncheck Permission</label>
											</div>
											<div class="row row-eq-height">
											@if(isset($moduelsRights) && !empty($moduelsRights))
												@php
													$arrModules = array();
												@endphp
												@foreach($moduelsRights as $key => $val)
													@php
														if($key== 0){
															$preModules = $val['moduleName'];
														}else{
															$preModules = $moduelsRights[$key-1]['moduleName'];
															if($preModules != $val['moduleName']){
													@endphp	
													</div>
													</div>
													</div>
													</fieldset>
													</div>
													@php
															}
														}
													@endphp
													@if(!in_array($val['moduleName'],$arrModules))
														<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 col-container m10" id="heading-{{$key}}" >
															<div class="card-header col bdr-full">
															<?php
																$moduleName = str_replace(' ', '_', $val['moduleName']);
															?>
															<fieldset class="group"> 
															<legend>
															<div class="custom-control custom-checkbox bdr">
																<input type="checkbox" class="checkAllByModule custom-control-input" id="{{$moduleName}}">
																<label class="custom-control-label header" for="{{$moduleName}}">{{ $val['moduleName'] }}</label>
															</div>
															</legend>
												@endif
												@if(!in_array($val['moduleName'],$arrModules))
													<div id="{{$key}}" class="" style="padding-bottom:20px;">
														<div class="card-body widget-content">
														@php
															$arrModules[] = $val['moduleName'];
														@endphp
												@endif
														<div class="col-md-6" style="float:left">
															<div class="custom-control custom-checkbox">
																@php
																	$existRights = explode(",",$roleDetails->rights)
																@endphp
																@if(in_array($val->rightsId,$existRights))
																<input type="checkbox" checked class="checkbox custom-control-input {{$moduleName}}" id="rights-{{ $key }}" name="rights[]" value="{{ $val->rightsId }}">
																@else
																<input type="checkbox" class="checkbox custom-control-input {{$moduleName}}" id="rights-{{ $key }}" name="rights[]" value="{{ $val->rightsId }}">
																@endif
																<label class="custom-control-label" for="rights-{{ $key }}">{{ $val->rightsName }}</label>
															</div>
														</div>
											@endforeach
										@endif
										</div>
										</div>
									</div>
								</div>
								</div>
						</div>
						<div class="row">
				<div class="card-body">
					<button type="submit" class="btn btn-success">Save</button>
					<a href="{{ url('/admin/role') }}"><button type="button" class="btn btn-danger" id="back">Back</button></a>
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
@stop