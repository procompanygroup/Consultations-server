<!-- main-header opened -->
			<div class="main-header sticky side-header nav nav-item">
				<div class="container-fluid">
					<div class="main-header-left ">
						<div class="responsive-logo">
							<a href="{{route('admin')}}"><img src="{{URL::asset('assets/img/brand/logo-title.svg')}}" class="logo-1" alt="logo"></a>
							<a href="{{route('admin')}}"><img src="{{URL::asset('assets/img/brand/logo-title.svg')}}" class="dark-logo-1" alt="logo"></a>
							<a href="{{route('admin')}}"><img src="{{URL::asset('assets/img/brand/logo-title.svg')}}" class="logo-2" alt="logo"></a>
							<a href="{{route('admin')}}"><img src="{{URL::asset('assets/img/brand/logo-title.svg')}}" class="dark-logo-2" alt="logo"></a>
						</div>
						<div class="app-sidebar__toggle" data-toggle="sidebar">
							<a class="open-toggle" href="#"><i class="header-icon fe fe-align-left" ></i></a>
							<a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
						</div>

						<div class="main-header-center mr-3 d-sm-none d-md-none d-lg-block">
							{{-- <input class="form-control" placeholder="Search for anything..." type="search"> <button class="btn"><i class="fas fa-search d-none d-md-block"></i></button>
						--}}</div> 
					</div>
					<div class="main-header-right">
						<div class="nav nav-item  navbar-nav-right ml-auto">
						
							<div class="dropdown nav-item main-header-notification">
								<a class="new nav-link" href="#">
								<svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg><span class=" pulse"></span></a>
								<div class="dropdown-menu">
									<div class="menu-header-content bg-primary text-right">
										<div class="d-flex">
											<h6 class="dropdown-title mb-1 tx-15 text-white font-weight-semibold">الطلبات الواردة</h6>
			 
										</div>
	
									</div>
									<div class="main-notification-list chat-scroll  ps" id="notify-orders-container">
									 
									 
									 
									 
									 
									<div class="ps__rail-x" style="left: 0px; top: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: -2px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
									<div class="dropdown-footer">
										 
									</div>
								</div>
							</div>	








							<div class="dropdown main-profile-menu nav nav-item nav-link">
								<a class="profile-user d-flex" href=""><img alt="" src="{{auth()->user()->image_path}}"></a>
								<div class="dropdown-menu">
									<div class="main-header-profile bg-primary p-3">
										<div class="d-flex wd-100p">
											<div class="main-img-user"><img alt="" src="{{auth()->user()->image_path}}" class=""></div>
											<div class="mr-3 my-auto">
												<h6>{{ auth()->user()->name }}</h6><span>{{auth()->user()->role=='admin'? __('general.admin') :(auth()->user()->role=='super'?__('general.super'):auth()->user()->role)}}</span>
											</div>
										</div>
									</div>
								
									<a class="dropdown-item" href="{{route('user.editprofile',auth()->user()->id)}}"><i class="bx bx-cog"></i>{{ __('general.Edit_Profile') }}</a>
							
										<form method="POST" action="{{ route('logout') }}">
										@csrf
										<a class="dropdown-item" href="{{route('logout') }}" onclick="event.preventDefault();
										this.closest('form').submit();" ><i class="bx bx-log-out"></i> {{ __('general.LogOut') }}</a>

									</form>

								</div>
							</div>
							
						</div>
					</div>
				</div>
			</div>
<!-- /main-header -->
