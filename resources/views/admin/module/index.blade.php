@extends('admin.layouts.default')

@section('title', VIEW_INFO['title'])

@section('content_header')
<h3 class="kt-subheader__title">{{ VIEW_INFO['title'] }} Management </h3>
<span class="kt-subheader__separator kt-hidden"></span>
<div class="kt-subheader__breadcrumbs">
    <a href="{{ url('admin/dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ url('admin/module') }}" class="kt-subheader__breadcrumbs-link">{{VIEW_INFO['title']}}</a>

    <!-- <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Active link</span> -->
</div>
@stop

@section('content')
<!-- begin:: Content -->
<form id="list-form" name="list-form" action="{{ url( VIEW_INFO['url'] ) }}" class="" method="post">
    {{ csrf_field() }}
<input type="hidden" name="is_globle" id="is_globle" value="1">    
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
							<div class="kt-portlet kt-portlet--mobile">
								<div class="kt-portlet__head kt-portlet__head--lg">
									<div class="kt-portlet__head-label">
										<span class="kt-portlet__head-icon">
											<i class="kt-font-brand flaticon2-line-chart"></i>
										</span>
										<h3 class="kt-portlet__head-title">
											{{VIEW_INFO['title']}} List
										</h3>
									</div>
									<div class="kt-portlet__head-toolbar">
										<div class="kt-portlet__head-wrapper">
											<div class="dropdown dropdown-inline">
												@include('admin.includes.datatablesdropdown',['action_url' => VIEW_INFO['url']])
											</div>
										</div>
									</div>
								</div>
								<div class="kt-portlet__body">
									@include('admin.includes.errormessage')
									<!-- begin:: Aside -->
									@include('admin.layouts.filteraction')
									<!-- end:: Aside Menu -->									
								</div>
								<div class="kt-portlet__body kt-portlet__body--fit">

									<!--begin: Datatable -->
									<div class="kt-datatable" id="local_data"></div>

									<!--end: Datatable -->
								</div>
							</div>
                        </div>
</form>
<!-- Main content -->

@include('admin.layouts.delete',['action_url' => VIEW_INFO['url'].'/delete'])
@include('admin.layouts.select')
@include('admin.layouts.toggle',['action_url' => VIEW_INFO['url'].'/toggle'])

<!-- /.content -->
@stop
@section('metronic_js')
<script src="{{ asset('admin/assets/js/pages/custom/module-selection.js')}}" type="text/javascript"></script>
@stop