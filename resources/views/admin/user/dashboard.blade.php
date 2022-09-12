
@extends('admin.layouts.default')
@section('title', 'Dashboard')

@section('content_header')
  <h3 class="kt-subheader__title">Dashboard </h3>
  <span class="kt-subheader__separator kt-hidden"></span>
  <div class="kt-subheader__breadcrumbs">
      <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
      <span class="kt-subheader__breadcrumbs-separator"></span>
      <a href="{{ url('admin/dashboard') }}" class="kt-subheader__breadcrumbs-link">Dashboard</a>

      <!-- <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Active link</span> -->
  </div>
@stop

@section('content')
<!-- Main content -->      
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
  <div class="lightbackground">
      <!--Begin::Dashboard 1-->
      <!--Begin::Row-->
      <div class="row">
        <div class="col-xl-12 order-lg-1 order-xl-1">
        <!--Begin::Portlet-->
          <div class="kt-portlet kt-portlet--height-fluid">
            <div class="kt-portlet__head">
              <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                  Select An App
                </h3>
              </div>          
            </div>       
          <!--End::Portlet-->
        </div>
      </div>  
      <!--End::Row-->
    </div>

    <div class="row">
      @if(isset($data) && !empty($data))
        @foreach($data as $key=>$val)
        <div class="col-sm-3">
            <!--begin::Stats Widget 4-->
          <div class="text-center">
              <!--begin::Body-->
              <div class="">
                  <a href="{{$val->website}}" target="_blank">
                    <img src="{{url($arrFile['path'].$arrFile['resize'].'x'.$arrFile['resize'].'/'.$val->img)}}" alt="image">
                    <br />
                    <p style="padding:10px 0px">{{$val->name}}</p>
                  </a>
              </div>
              <!--end::Body-->
          </div>
          <!--end::Stats Widget 4-->
        </div>
        @endforeach
      @endif 
    </div>
  </div>
</div>
@stop
@section('metronic_js')
<script src="{{ asset('admin/assets/js/pages/dashboard.js') }}" type="text/javascript"></script>
@stop