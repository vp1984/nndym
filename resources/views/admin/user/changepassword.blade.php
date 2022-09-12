@extends('admin.layouts.default')
@section('title', 'Edit '.VIEW_INFO['title'] )

@section('content_header')
<h3 class="kt-subheader__title">{{ VIEW_INFO['title'] }} Management </h3>
<span class="kt-subheader__separator kt-hidden"></span>
<div class="kt-subheader__breadcrumbs">
    <a href="{{ url('admin/dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ url('admin/user') }}" class="kt-subheader__breadcrumbs-link">{{VIEW_INFO['title']}}</a>
</div>
@stop

@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
	<!-- begin:: Subheader -->
	<div class="kt-subheader   kt-grid__item" id="kt_subheader">
		<div class="kt-container  kt-container--fluid ">
			<div class="kt-subheader__main">
				<h3 class="kt-subheader__title">
					<button class="kt-subheader__mobile-toggle kt-subheader__mobile-toggle--left" id="kt_subheader_mobile_toggle"><span></span></button>
					Profile 1 
				</h3>
				<span class="kt-subheader__separator kt-hidden"></span>
				<div class="kt-subheader__breadcrumbs">
					<a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
					<span class="kt-subheader__breadcrumbs-separator"></span>
						<a href="" class="kt-subheader__breadcrumbs-link">Applications</a>
					<span class="kt-subheader__breadcrumbs-separator"></span>
						<a href="" class="kt-subheader__breadcrumbs-link">Users</a>
					<span class="kt-subheader__breadcrumbs-separator"></span>
						<a href="" class="kt-subheader__breadcrumbs-link">	Profile 1</a>
					<span class="kt-subheader__breadcrumbs-separator"></span>
						<a href="" class="kt-subheader__breadcrumbs-link">Personal Information </a>
				</div>
			</div>
		</div>
	</div>
	<!-- end:: Subheader -->
	<!-- begin:: Content -->
	<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
		<!--Begin::App-->
		<div class="kt-grid kt-grid--desktop kt-grid--ver kt-grid--ver-desktop kt-app">
			<!--Begin:: App Aside Mobile Toggle-->
			<button class="kt-app__aside-close" id="kt_user_profile_aside_close">
				<i class="la la-close"></i>
			</button>
			<!--End:: App Aside Mobile Toggle-->
			<!--Begin:: App Aside-->
			<div class="kt-grid__item kt-app__toggle kt-app__aside" id="kt_user_profile_aside">
				<!--begin:: Widgets/Applications/User/Profile1-->
				<div class="kt-portlet ">
					<div class="kt-portlet__head  kt-portlet__head--noborder">
						<div class="kt-portlet__head-label">
							<h3 class="kt-portlet__head-title">
							</h3>
						</div>
						<div class="kt-portlet__head-toolbar">
							<a href="#" class="btn btn-clean btn-sm btn-icon btn-icon-md" data-toggle="dropdown">
								<i class="flaticon-more-1"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right dropdown-menu-fit dropdown-menu-md">
								<!--begin::Nav-->
								<ul class="kt-nav">
									<li class="kt-nav__head">
										Export Options
										<span data-toggle="kt-tooltip" data-placement="right" title="Click to learn more...">
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--brand kt-svg-icon--md1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24" />
													<circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10" />
													<rect fill="#000000" x="11" y="10" width="2" height="7" rx="1" />
													<rect fill="#000000" x="11" y="7" width="2" height="2" rx="1" />
												</g>
											</svg> 
										</span>
									</li>
									<li class="kt-nav__separator"></li>
									<li class="kt-nav__item">
										<a href="#" class="kt-nav__link">
											<i class="kt-nav__link-icon flaticon2-drop"></i>
											<span class="kt-nav__link-text">Activity</span>
										</a>
									</li>
									<li class="kt-nav__item">
										<a href="#" class="kt-nav__link">
											<i class="kt-nav__link-icon flaticon2-calendar-8"></i>
											<span class="kt-nav__link-text">FAQ</span>
										</a>
									</li>
									<li class="kt-nav__item">
										<a href="#" class="kt-nav__link">
											<i class="kt-nav__link-icon flaticon2-telegram-logo"></i>
											<span class="kt-nav__link-text">Settings</span>
										</a>
									</li>
									<li class="kt-nav__item">
										<a href="#" class="kt-nav__link">
											<i class="kt-nav__link-icon flaticon2-new-email"></i>
											<span class="kt-nav__link-text">Support</span>
											<span class="kt-nav__link-badge">
												<span class="kt-badge kt-badge--success kt-badge--rounded">5</span>
											</span>
										</a>
									</li>
									<li class="kt-nav__separator"></li>
									<li class="kt-nav__foot">
										<a class="btn btn-label-danger btn-bold btn-sm" href="#">Upgrade plan</a>
										<a class="btn btn-clean btn-bold btn-sm" href="#" data-toggle="kt-tooltip" data-placement="right" title="Click to learn more...">Learn more</a>
									</li>
								</ul>	
							<!--end::Nav-->
							</div>
						</div>
					</div>
					<div class="kt-portlet__body kt-portlet__body--fit-y">
						<!--begin::Widget -->
						<div class="kt-widget kt-widget--user-profile-1">
							<div class="kt-widget__head">
									<div class="kt-widget__media">
									<img src="assets/media/users/100_13.jpg" alt="image">
								</div>
								<div class="kt-widget__content">
									<div class="kt-widget__section">
										<a href="#" class="kt-widget__username">
										{{ $data->name }}
											<i class="flaticon2-correct kt-font-success"></i>
										</a>												
									</div>														
								</div>
							</div>
							<div class="kt-widget__body">
								<div class="kt-widget__content">
									<div class="kt-widget__info">
										<span class="kt-widget__label">Email:</span>
										<a href="#" class="kt-widget__data">{{ $data->email }}</a>
									</div>				
								</div>
								<div class="kt-widget__items">
									<a href="/admin/myprofile/{{ $data->id }}" class="kt-widget__item ">
										<span class="kt-widget__section">
											<span class="kt-widget__icon">
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<polygon points="0 0 24 0 24 24 0 24" />
														<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
														<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
													</g>
												</svg> </span>
											<span class="kt-widget__desc">
												Personal Information
											</span>
										</span>
									</a>
									<a href="changepassword/1" class="kt-widget__item kt-widget__item--active">
									<span class="kt-widget__section">
											<span class="kt-widget__icon">
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<rect x="0" y="0" width="24" height="24" />
														<path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3" />
														<path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z" fill="#000000" opacity="0.3" />
														<path d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z" fill="#000000" opacity="0.3" />
													</g>
												</svg> </span>
											<span class="kt-widget__desc">
												Change Password
											</span>
										</span>
										<span class="kt-badge kt-badge--unified-danger kt-badge--sm kt-badge--rounded kt-badge--bolder">*</span>
									</a>
                                </div>
							</div>
						</div>
					<!--end::Widget -->
					</div>
				</div>
			<!--end:: Widgets/Applications/User/Profile1-->
			</div>
     		<!--Begin:: App Content-->
			<div class="kt-grid__item kt-grid__item--fluid kt-app__content">
				<div class="row">
					<div class="col-xl-12">
						<div class="kt-portlet kt-portlet--height-fluid">
							<div class="kt-portlet__head">
								<div class="kt-portlet__head-label">
									<h3 class="kt-portlet__head-title">Change Password<small>change or reset your account password</small></h3>
								</div>
								<div class="kt-portlet__head-toolbar kt-hidden">
									<div class="kt-portlet__head-toolbar">
										<div class="dropdown dropdown-inline">
											<button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<i class="la la-sellsy"></i>
											</button>
											<div class="dropdown-menu dropdown-menu-right">
												<ul class="kt-nav">
													<li class="kt-nav__section kt-nav__section--first">
														<span class="kt-nav__section-text">Quick Actions</span>
													</li>
													<li class="kt-nav__item">
														<a href="#" class="kt-nav__link">
															<i class="kt-nav__link-icon flaticon2-graph-1"></i>
															<span class="kt-nav__link-text">Statistics</span>
														</a>
													</li>
													<li class="kt-nav__item">
														<a href="#" class="kt-nav__link">
															<i class="kt-nav__link-icon flaticon2-calendar-4"></i>
															<span class="kt-nav__link-text">Events</span>
														</a>
													</li>
													<li class="kt-nav__item">
														<a href="#" class="kt-nav__link">
															<i class="kt-nav__link-icon flaticon2-layers-1"></i>
															<span class="kt-nav__link-text">Reports</span>
														</a>
													</li>
													<li class="kt-nav__item">
														<a href="#" class="kt-nav__link">
															<i class="kt-nav__link-icon flaticon2-bell-1o"></i>
															<span class="kt-nav__link-text">Notifications</span>
														</a>
													</li>
													<li class="kt-nav__item">
														<a href="#" class="kt-nav__link">
															<i class="kt-nav__link-icon flaticon2-file-1"></i>
															<span class="kt-nav__link-text">Files</span>
														</a>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
							<form method="post" class="form-horizontal" id="frmchngpsw" name="frmchngpsw" action="{{ url('admin/myprofile/changepassword/'.$data->id) }}">{{ csrf_field() }}
								<div class="kt-portlet__body">
									<div class="kt-section kt-section--first">
										<div class="kt-section__body">
											@include('admin.includes.errormessage')
											<div class="form-group row">
												<label class="col-xl-3 col-lg-3 col-form-label">Current Password</label>
												<div class="col-lg-9 col-xl-6">
												<input type="password" id="current_password" name="current_password" data-toggle="tooltip" title="Enter Current Password" class="form-control" placeholder="Enter Current Password">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-xl-3 col-lg-3 col-form-label">New Password</label>
												<div class="col-lg-9 col-xl-6">
												<input type="password" id="password" name="password" data-toggle="tooltip" title="Enter New Password" class="form-control" placeholder="Enter New Password">
												</div>
											</div>
											<div class="form-group form-group-last row">
												<label class="col-xl-3 col-lg-3 col-form-label">Confirm New Password</label>
												<div class="col-lg-9 col-xl-6">
												<input type="password" id="password_confirmation" name="password_confirmation" data-toggle="tooltip" title="Confirm New Password" class="form-control" placeholder="Confirm New Password">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="kt-portlet__foot">
									<div class="kt-form__actions">
										<div class="row">
											<div class="col-lg-3 col-xl-3">
											</div>
											<div class="col-lg-9 col-xl-9">
												<button type="submit" class="btn btn-brand btn-bold">Change Password</button>&nbsp;
												<button type="reset" class="btn btn-secondary">Cancel</button>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		<!--End:: App Content-->
		</div>
	<!--End::App-->
	</div>
<!-- end:: Content -->
</div>
@stop

@section('metronic_js')
<script src="{{ asset('admin/assets/js/pages/custom/user.js') }}"></script>
@stop