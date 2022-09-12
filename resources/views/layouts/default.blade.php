<!DOCTYPE html>
<html lang="en">

	<!-- begin::Head -->
	<head>		
		@include('layouts.head')
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	@if(in_array(Request::path(),array('santa-claus','goodies','elf')))
	<body class="body_magical_santa">
	@elseif(in_array(Request::path(),array('booking-process')))
	<body class="booking_body">
	@else
	<body>
	@endif	
		@include('layouts.header')
		@yield('content')
		@if(Request::path() == '/')
			@include('layouts.footer')
		@else
			@if(!in_array(Request::path(),array('santa-claus','goodies','elf')))
				@include('layouts.restfooter')
			@endif
		@endif	
		@include('layouts.scripts')
	</body>
	<!-- end::Body -->
</html>