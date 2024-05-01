<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="Rouh Dashboard">
		<meta name="Author" content="">
		<meta name="Keywords" content="Rouh,dashboard"/>
		@include('admin.layouts.head')
	</head>

	<body class="main-body app sidebar-mini">
		<!-- Loader -->
		<div id="global-loader">
			<img src="{{URL::asset('assets/img/loader.svg')}}" class="loader-img" alt="Loader">
		</div>
		<div id="loading"></div>
		<!-- /Loader -->
		@include('admin.layouts.main-sidebar')		
		<!-- main-content -->
		<div class="main-content app-content">
			@include('admin.layouts.main-header')			
			<!-- container -->
			<div class="container-fluid">
				@yield('page-header')
				@yield('content')
				{{-- @include('admin.layouts.sidebar') --}}
				{{-- @include('admin.layouts.models') --}}
            	@include('admin.layouts.footer')
				@include('admin.layouts.footer-scripts')	
	</body>
</html>