<!-- begin:: Header -->
<div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed ">
	<!-- begin: Header Menu -->
	<button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
	<div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper"></div>
	<!-- end: Header Menu -->
	<!-- begin:: Header Topbar -->
	<div class="kt-header__topbar">
		<!--begin: Search -->
		<!--begin: Search -->
		<!--end: Search -->
		<!--end: Search -->
		<!--begin: Notifications -->
		<!--end: Notifications -->
		<!--begin: Quick Actions -->
		<!--end: Quick Actions -->
		<!--begin: My Cart -->
		<!--end: My Cart -->
		<!--begin: Quick panel toggler -->
		<!--end: Quick panel toggler -->
		<!--begin: Language bar -->
		<!--end: Language bar -->
		<!--begin: User Bar -->
		<div class="kt-header__topbar-item kt-header__topbar-item--user">
			<div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,0px">
				<div class="kt-header__topbar-user">
					<span class="kt-header__topbar-welcome kt-hidden-mobile">Hi,</span>
					<span class="kt-header__topbar-username kt-hidden-mobile">{{ Session::get('name')  }}</span>
					@if (file_exists( Session::get('profile_photo') ))
						<img alt="Pic" class="kt-radius-100" src="{{ Session::get('profile_photo')  }}" />
					@else
						<img alt="Pic" class="kt-radius-100" src="{{ asset('admin/assets/media/users/300_25.jpg') }}" />
					@endif

					<!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->

					<!--<span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold">S</span>-->
				</div>
			</div>
			<div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">

				<!--begin: Head -->
				<div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x" style="background-image: url({{ asset('admin/assets/media/misc/bg-1.jpg') }})">
					<div class="kt-user-card__avatar">
						@if (file_exists( Session::get('profile_photo') ))
							<img class="kt-hidden" alt="Pic" src="{{ Session::get('profile_photo')  }}" />
						@else
							<img class="kt-hidden" alt="Pic" src="{{ asset('admin/assets/media/users/300_25.jpg') }}" />
						@endif

						<!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
						<span class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success">{{ Session::get('name')[0]  }}</span>
					</div>
					<div class="kt-user-card__name">
						{{ Session::get('name')  }}
					</div>
				</div>

				<!--end: Head -->

				<!--begin: Navigation -->
				<div class="kt-notification">
					@if(in_array('/admin/myprofile',Session::get('routes')))
					<a href="{{ url('admin/myprofile/').'/'.Session::get('id') }}" class="kt-notification__item">
						<div class="kt-notification__item-icon">
							<i class="flaticon2-calendar-3 kt-font-success"></i>
						</div>
						<div class="kt-notification__item-details">
							<div class="kt-notification__item-title kt-font-bold">
								My Profile
							</div>
							<div class="kt-notification__item-time">
								Account settings and more
							</div>
						</div>
					</a>
					@endif
					@if(in_array('/admin/message/inbox',Session::get('routes')))
					<a href="custom/apps/user/profile-3.html" class="kt-notification__item">
						<div class="kt-notification__item-icon">
							<i class="flaticon2-mail kt-font-warning"></i>
						</div>
						<div class="kt-notification__item-details">
							<div class="kt-notification__item-title kt-font-bold">
								My Messages
							</div>
							<div class="kt-notification__item-time">
								Inbox and tasks
							</div>
						</div>
					</a>
					@endif
					@if(in_array('/admin/change-password',Session::get('routes')))
					<a href="custom/apps/user/profile-2.html" class="kt-notification__item">
						<div class="kt-notification__item-icon">
							<i class="flaticon2-rocket-1 kt-font-danger"></i>
						</div>
						<div class="kt-notification__item-details">
							<div class="kt-notification__item-title kt-font-bold">
								My Activities
							</div>
							<div class="kt-notification__item-time">
								Logs and notifications
							</div>
						</div>
					</a>
					@endif
					@if(in_array('/admin/myprofile',Session::get('routes')))
					<div class="kt-notification__custom kt-space-between">
						<a href="{{ url('/logout') }}" class="btn btn-label btn-label-brand btn-sm btn-bold">Sign Out</a>
					</div>
					@endif
				</div>

				<!--end: Navigation -->
			</div>
		</div>
		<!--end: User Bar -->
		</div>
	<!-- end:: Header Topbar -->