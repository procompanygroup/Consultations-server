<!-- main-sidebar -->
		<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
		<aside class="app-sidebar sidebar-scroll">
			<div class="main-sidebar-header active">
				<a class="desktop-logo logo-light active" href="{{route('admin')}}"><img src="{{URL::asset('assets/img/brand/logo-title.svg')}}" class="main-logo" alt="logo"></a>
				<a class="desktop-logo logo-dark active" href="{{route('admin')}}"><img src="{{URL::asset('assets/img/brand/logo-title.svg')}}" class="main-logo dark-theme" alt="logo"></a>
				<a class="logo-icon mobile-logo icon-light active" href="{{route('admin')}}"><img src="{{URL::asset('assets/img/brand/logo-title.svg')}}" class="logo-icon" alt="logo"></a>
				<a class="logo-icon mobile-logo icon-dark active" href="{{route('admin')}}"><img src="{{URL::asset('assets/img/brand/logo-title.svg')}}" class="logo-icon dark-theme" alt="logo"></a>
			</div>
			<div class="main-sidemenu">
				<div class="app-sidebar__user clearfix">
					<div class="dropdown user-pro-body">
						<div class="">
							<img alt="user-img" class="avatar avatar-xl brround" src="{{auth()->user()->image_path}}"><span class="avatar-status profile-status bg-green"></span>
						</div>
						<div class="user-info">
							<h4 class="font-weight-semibold mt-3 mb-0">{{ auth()->user()->name }}</h4>
							<span class="mb-0 text-muted">{{auth()->user()->role=='admin'? __('general.admin') :(auth()->user()->role=='super'?__('general.super'):auth()->user()->role)}}</span>
						</div>
					</div>
				</div>
				<ul class="side-menu">
@if(auth()->user()->role=='admin')

					<li class="slide">
						<a class="side-menu__item"   href="{{ route('user.index') }}" ><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path class="st0" d="M0,0h24v24H0V0z" fill="none"/>
                            <path d="M9.6,14.4l1.3,3.9l0.7-2.3l-0.3-0.4c-0.1-0.2-0.2-0.4-0.1-0.6c0.2-0.4,0.5-0.3,0.9-0.3c0.4,0,0.8-0.1,0.9,0.4
                            c0,0.2,0,0.3-0.1,0.5L12.5,16l0.7,2.3l1.2-3.9c0.9,0.8,3.5,0.9,4.4,1.5c0.3,0.2,0.6,0.4,0.8,0.7c0.3,0.4,0.5,1,0.6,1.8l0.2,1.3
                            c0,0.5-0.3,0.8-0.9,0.9h-7.5H4.5c-0.6,0-0.9-0.3-0.9-0.9l0.2-1.3C3.8,17.6,4,17,4.3,16.5c0.2-0.3,0.5-0.5,0.8-0.7
                            C6.1,15.3,8.7,15.2,9.6,14.4L9.6,14.4z M9,8.7c-0.2,0-0.3,0-0.4,0.1c0,0-0.1,0.1-0.1,0.1c0,0.1,0,0.1,0,0.2c0,0.2,0.1,0.5,0.4,0.9
                            l0,0l0,0l0.7,1.2c0.3,0.5,0.6,1,1,1.3c0.4,0.3,0.8,0.6,1.4,0.6c0.7,0,1.1-0.2,1.5-0.6c0.4-0.4,0.7-0.9,1-1.4l0.8-1.4
                            c0.2-0.4,0.2-0.6,0.2-0.7c0-0.1-0.1-0.1-0.3-0.1c0,0-0.1,0-0.1,0c0,0-0.1,0-0.1,0c0,0,0,0-0.1,0c-0.1,0-0.2,0-0.2,0l0.3-1.3
                            c-1.5,0-2.6-0.3-3.8-1.1c-0.4-0.3-0.5-0.6-0.9-0.5C10,6,9.7,6.1,9.5,6.3C9.3,6.6,9.2,6.9,9.1,7.2l0.2,1.5C9.1,8.7,9,8.7,9,8.7L9,8.7
                            z M15.6,8.5c0.2,0.1,0.3,0.2,0.4,0.4c0.1,0.2,0,0.6-0.2,1l0,0c0,0,0,0,0,0l-0.9,1.4c-0.3,0.5-0.7,1.1-1.1,1.5
                            c-0.5,0.4-1,0.7-1.8,0.7c-0.7,0-1.3-0.3-1.7-0.7c-0.4-0.4-0.8-0.9-1.1-1.4l-0.7-1.2C8.2,9.8,8,9.5,8,9.2C8,9,8,8.9,8.1,8.8
                            c0.1-0.1,0.1-0.2,0.3-0.3c0.1,0,0.1-0.1,0.2-0.1c0-0.6-0.1-1.5,0-2.1c0-0.2,0-0.3,0.1-0.5c0.2-0.7,0.7-1.2,1.3-1.6
                            c0.2-0.1,0.4-0.2,0.7-0.3c1.4-0.5,3.3-0.2,4.4,0.9c0.4,0.5,0.7,1,0.7,1.8L15.6,8.5L15.6,8.5z"/>
                        </svg>
							<span class="side-menu__label"> {{ __('general.supervisors') }}</span> </a>

					</li>

                    <li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none"/>
                            <path d="M15.5,15.7c-0.1-0.1-0.3-0.3-0.5-0.4c-0.4-0.4-0.9-0.7-1.1-1l0,0c-0.4,0.3-1,0.5-1.7,0.5c-0.7,0-1.2-0.2-1.6-0.5
                            c-0.1-0.1-0.2-0.1-0.3-0.2c-0.2,0.3-0.7,0.7-1.2,1.1c-0.3,0.2-0.5,0.5-0.7,0.6c-0.5,0.6-0.9,1.2-1.2,1.9l1.5,0l3.3,2.9l3.3-2.9
                            l1.5,0C16.4,16.9,16,16.3,15.5,15.7L15.5,15.7z M9.5,12.6c0.4,0.3,0.8,0.5,1.3,0.6c0-0.1,0.1-0.2,0.2-0.3c0.3-0.2,1.1-0.2,1.4,0
                            c0.2,0.2,0.2,0.6,0.1,0.8c-0.3,0.4-1.3,0.2-1.9,0c0.1,0.1,0.2,0.2,0.3,0.2c0.4,0.2,0.8,0.4,1.4,0.4c0.6,0,1.1-0.2,1.4-0.4
                            c0.1,0,0.1-0.1,0.2-0.1c0,0,0.1-0.1,0.1-0.1c0.3-0.2,0.5-0.5,0.7-0.7l0.4-0.5c0-0.1,0.1-0.1,0.1-0.1c0-0.1,0.1-0.1,0.2-0.2
                            c0,0,0,0,0.1,0c0.1-0.2,0.1-0.4,0.1-0.6c0.1-0.7,0.1-1.3-0.2-2c-0.3-0.6-0.7-0.9-1.1-1.1c0.5,0.5,0.9,1,0.8,1.5
                            c-0.6-0.6-1.2-1.2-1.8-1.6c-1.3-0.7-2-1.6-2.4-2.7c-1.9,1.9-2.2,4.1-1.5,6.6c0,0,0,0,0.1,0L9.5,12.6L9.5,12.6z M9.8,13.5
                            c-0.5-0.2-0.9-0.6-1.4-0.9l-0.8,0c-0.1-0.1-0.2-0.3-0.3-0.4c-0.1,0-0.1,0-0.2,0C6.4,11.9,5.8,10.3,6,9.5C6,9,6.2,8.9,6.4,8.8
                            c0,0,0-0.1,0-0.1V7c0-0.6,0.2-1.2,0.5-1.8C7.2,4.6,7.7,4,8.2,3.6c1.1-0.9,2.4-1.3,3.8-1.3c1.4,0,2.7,0.5,3.8,1.3
                            c0.5,0.4,0.9,1,1.2,1.6c0.3,0.6,0.5,1.3,0.5,1.9v1.4c0,0.2-0.2,0.4-0.4,0.4c-0.1,0-0.2-0.1-0.3-0.1c0.2,1.3,0,2.7-0.5,3.8h-0.9
                            c0,0,0,0-0.1,0.1l-0.1,0.1l-0.4,0.5c-0.2,0.3-0.5,0.5-0.7,0.8c0.1,0.2,0.6,0.6,1,0.9c0.1,0.1,0.3,0.2,0.4,0.3
                            c1.1,0.4,2.3,0.9,3.1,1.4c0.7,0.4,1,0.7,1.3,1.2c0.4,0.8,0.8,1.7,0.9,2.8c0.1,0.9,0.1,0.9-0.8,0.9c-4.8,0.1-11.5-0.1-16.2,0
                            c-0.9,0-0.9,0.1-0.9-1.1c0.3-1.4,0.1-1.2,0.8-2.5c0.3-0.5,0.6-0.8,1.3-1.2c0.9-0.5,2-1,3.2-1.5c0.1-0.1,0.3-0.3,0.5-0.4
                            c0.5-0.4,1.1-0.9,1.1-1.1C9.9,13.7,9.8,13.6,9.8,13.5L9.8,13.5z M16.8,8.3V7.2c0-0.5-0.1-1.1-0.4-1.6c-0.3-0.5-0.6-1-1-1.4
                            c-0.9-0.8-2.1-1.2-3.3-1.2c-1.2,0-2.4,0.4-3.4,1.1C8.2,4.5,7.8,5,7.5,5.5C7.3,6,7.1,6.5,7.1,7v1.4c0.4-1.9,1.2-3.2,2.4-4
                            c0.9-0.6,1.4-0.6,2.5-0.6c0.9,0,1.5,0,2.3,0.5C15.6,5.2,16.5,6.7,16.8,8.3L16.8,8.3z M10.9,18.8l0.7-2.3l-0.3-0.4
                            c-0.1-0.2-0.2-0.4-0.1-0.6c0.2-0.3,0.5-0.3,0.9-0.3c0.4,0,0.8-0.1,0.9,0.4c0,0.1,0,0.3-0.1,0.5l-0.3,0.4l0.7,2.3L12,19.7L10.9,18.8
                            L10.9,18.8z"/></svg>
							<span class="side-menu__label">{{ __('general.experts') }}</span><i class="angle fe fe-chevron-down"></i></a>
						<ul class="slide-menu">
							<li><a class="slide-item"  href="{{ route('expert.index') }}">اضافة خبير</a></li>
							<li><a class="slide-item"  href="{{ url('admin/expertstatus') }}">حالة الخبير</a></li>
                            <li><a class="slide-item"  href="{{ url('admin/experts/statistics') }}">احصائيات الخبراء</a></li>
						</ul>
					</li>







					<li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none"/>
                            <path class="st1" d="M9.6,13.9c-0.3-0.3-0.6-0.8-0.7-1.3l-0.1,0c-0.1,0-0.2,0-0.4-0.1c-0.2-0.1-0.3-0.3-0.4-0.5
                            c-0.2-0.4-0.3-1.5,0.1-1.8l-0.1-0.1l0-0.1c0-0.2,0-0.5,0-0.8c0-1,0-2.3-0.9-2.5L6.9,6.7l0.2-0.3c0.7-0.8,1.4-1.5,2.1-2.1
                            c0.8-0.6,1.6-1,2.4-1.2c0.8-0.1,1.6,0.1,2.3,0.6c0.2,0.2,0.4,0.4,0.6,0.6c0.8,0.1,1.4,0.5,1.9,1.1c0.3,0.4,0.5,0.8,0.6,1.2
                            c0.1,0.4,0.2,0.9,0.2,1.4c0,0.8-0.3,1.6-1,2.2c0.1,0,0.2,0,0.3,0.1c0.3,0.2,0.4,0.6,0.3,0.9c-0.1,0.3-0.2,0.6-0.3,0.9
                            c-0.1,0.4-0.3,0.4-0.7,0.4c0,0.6-0.4,1.1-0.8,1.4c-0.1,0.1-0.3,0.2-0.4,0.3c1.3,2.9,6.6,0.3,6.6,6.3c0,0.1-0.1,0.2-0.2,0.2H3.2
                            c-0.1,0-0.2-0.1-0.2-0.2c0-6.4,6.1-2.7,7.2-6.3C9.9,14.2,9.7,14.1,9.6,13.9L9.6,13.9z"/></svg>
 
                            <span class="side-menu__label">{{ __('general.clients') }}</span><i class="angle fe fe-chevron-down"></i></a>
                            <ul class="slide-menu">
                                <li><a class="slide-item"  href="{{ route('client.index') }}">الكل </a></li>
                                <li><a class="slide-item"  href="{{ url('admin/client/del-orders/all') }}">طلبات الحذف </a></li>
 
                            </ul>

					</li>








                    <li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none"/>
                            <path d="M12.8,12.7h-1.5c0,0,0,0-0.1,0c0,0,0,0,0,0.1V16c0,0,0,0,0,0.1c0,0,0,0,0.1,0h1.5c0,0,0,0,0.1,0c0,0,0,0,0-0.1L12.8,12.7
                            C12.8,12.8,12.8,12.8,12.8,12.7C12.8,12.7,12.8,12.7,12.8,12.7L12.8,12.7L12.8,12.7z M3,6h5.2V4.5c0-0.2,0.1-0.4,0.2-0.6
                            C8.6,3.7,8.8,3.7,9,3.7h6c0.2,0,0.4,0.1,0.6,0.2c0.1,0.1,0.2,0.4,0.2,0.6V6H21c0.3,0,0.6,0.1,0.8,0.3c0.2,0.2,0.3,0.5,0.3,0.8v2.8
                            c-1.3,0.9-2.7,1.7-4.1,2.3c-1.4,0.6-2.8,1.1-4.3,1.4v-1.1c0-0.3-0.1-0.5-0.3-0.7c-0.2-0.2-0.4-0.3-0.7-0.3h-1.7l0,0
                            c-0.3,0-0.5,0.1-0.7,0.3c-0.2,0.2-0.3,0.4-0.3,0.7v1.1c-1.5-0.3-2.9-0.8-4.2-1.4c-1.4-0.6-2.8-1.4-4.2-2.4V7.1
                            c0-0.3,0.1-0.6,0.3-0.8C2.4,6.1,2.6,6,3,6L3,6L3,6z M22.2,11.6v7.6c0,0.3-0.1,0.6-0.3,0.8c-0.2,0.2-0.5,0.3-0.8,0.3H3
                            c-0.3,0-0.6-0.1-0.8-0.3c-0.2-0.2-0.3-0.5-0.3-0.8v-7.7c1.1,0.7,2.3,1.4,3.5,1.9c1.6,0.7,3.2,1.2,4.9,1.6v1.2c0,0.3,0.1,0.5,0.3,0.7
                            c0.2,0.2,0.4,0.3,0.7,0.3h1.7c0.3,0,0.5-0.1,0.7-0.3c0.2-0.2,0.3-0.4,0.3-0.7V15l0,0.1c1.7-0.4,3.4-0.9,5-1.6
                            C20,12.9,21.1,12.3,22.2,11.6L22.2,11.6z M14.4,4.8H9.6c0,0-0.1,0-0.1,0c0,0,0,0,0,0.1v1.1h4.9V4.9C14.5,4.8,14.5,4.8,14.4,4.8
                            C14.4,4.8,14.4,4.8,14.4,4.8L14.4,4.8L14.4,4.8z"/></svg>
							<span class="side-menu__label"> {{ __('general.services') }}</span><i class="angle fe fe-chevron-down"></i></a>
						<ul class="slide-menu">
							<li><a class="slide-item"  href="{{ route('service.index') }}"> {{ __('general.add service') }}</a></li>

							<li><a class="slide-item"  href="{{ url('admin/service/expert/show') }}"> {{ __('general.show Service Expert') }}</a></li>

						</ul>
					</li>



                    <li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none"/>
                            <path d="M19,2.4H5c-0.3,0-0.5,0.2-0.5,0.5v18.1c0,0.3,0.2,0.5,0.5,0.5H19c0.3,0,0.5-0.2,0.5-0.5V2.9C19.6,2.6,19.3,2.4,19,2.4z
                            M8.1,20C8.1,20.1,8.1,20.1,8.1,20l-1.7,0.1c0,0-0.1,0-0.1-0.1v-1.6c0,0,0-0.1,0.1-0.1H8c0,0,0.1,0,0.1,0.1L8.1,20L8.1,20z
                            M8.1,16.5C8.1,16.6,8.1,16.6,8.1,16.5l-1.7,0.1c0,0-0.1,0-0.1-0.1v-1.6c0,0,0-0.1,0.1-0.1H8c0,0,0.1,0,0.1,0.1L8.1,16.5L8.1,16.5z
                            M8.1,13C8.1,13.1,8.1,13.1,8.1,13l-1.7,0.1c0,0-0.1,0-0.1-0.1v-1.6c0,0,0-0.1,0.1-0.1H8c0,0,0.1,0,0.1,0.1L8.1,13L8.1,13z M11.3,20
                           C11.3,20.1,11.2,20.1,11.3,20l-1.7,0.1c0,0-0.1,0-0.1-0.1v-1.6c0,0,0-0.1,0.1-0.1h1.6c0,0,0.1,0,0.1,0.1V20z M11.3,16.5
                           C11.3,16.6,11.2,16.6,11.3,16.5l-1.7,0.1c0,0-0.1,0-0.1-0.1v-1.6c0,0,0-0.1,0.1-0.1h1.6c0,0,0.1,0,0.1,0.1V16.5z M11.3,13
                           C11.3,13.1,11.2,13.1,11.3,13l-1.7,0.1c0,0-0.1,0-0.1-0.1v-1.6c0,0,0-0.1,0.1-0.1h1.6c0,0,0.1,0,0.1,0.1V13z M14.4,20
                           C14.4,20.1,14.4,20.1,14.4,20l-1.7,0.1c0,0-0.1,0-0.1-0.1v-1.6c0,0,0-0.1,0.1-0.1h1.6c0,0,0.1,0,0.1,0.1V20z M14.4,16.5
                           C14.4,16.6,14.4,16.6,14.4,16.5l-1.7,0.1c0,0-0.1,0-0.1-0.1v-1.6c0,0,0-0.1,0.1-0.1h1.6c0,0,0.1,0,0.1,0.1V16.5z M14.4,13
                           C14.4,13.1,14.4,13.1,14.4,13l-1.7,0.1c0,0-0.1,0-0.1-0.1v-1.6c0,0,0-0.1,0.1-0.1h1.6c0,0,0.1,0,0.1,0.1V13z M17.6,20
                           C17.6,20.1,17.6,20.1,17.6,20l-1.7,0.1c0,0-0.1,0-0.1-0.1v-1.6c0,0,0-0.1,0.1-0.1h1.6c0,0,0.1,0,0.1,0.1V20z M17.6,16.5
                           C17.6,16.6,17.6,16.6,17.6,16.5L16,16.6c0,0-0.1,0-0.1-0.1v-5.1c0,0,0-0.1,0.1-0.1h1.6c0,0,0.1,0,0.1,0.1V16.5z M17.9,9.6
                           c0,0.1-0.1,0.3-0.3,0.3H6.4c-0.1,0-0.3-0.1-0.3-0.3V4.6c0-0.1,0.1-0.3,0.3-0.3h11.3c0.1,0,0.3,0.1,0.3,0.3L17.9,9.6L17.9,9.6z"/></svg>
							<span class="side-menu__label"> {{ __('general.accounts') }}</span><i class="angle fe fe-chevron-down"></i></a>
						<ul class="slide-menu">
							<li><a class="slide-item"  href="{{ url('admin/service/percent/show') }}"> {{ __('general.show percent') }}</a></li>
							
                            <li><a class="slide-item"  href="{{ route('point.index') }}">{{ __('general.points') }}</a></li>
                            <li><a class="slide-item"  href="{{ route('minute.index') }}">شرائح الدقائق</a></li>
                            <li><a class="slide-item"  href="{{ url('admin/minute-gift/') }}">هدية الدقائق</a></li>
                            <li><a class="slide-item"  href="{{ url('admin/gift/') }}">هدية العميل</a></li>
                            <li><a class="slide-item"  href="{{ url('admin/expertgift/') }}">هدية الخبير</a></li>
							<li><a class="slide-item" href="{{ url('admin/balance/client') }}"> {{ __('general.clients balance') }}</a></li>
							<li><a class="slide-item" href="{{ url('admin/balance/expert') }}"> {{ __('general.experts balance') }}</a></li>
							<li><a class="slide-item" href="{{ url('admin/balance/pulls') }}"> {{ __('general.pulls') }}</a></li>

						</ul>
					</li>

                    <li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none"/>
                            <path d="M13.3,3.3c2.9,0.6,5.1,3.2,5.1,6.2c0,3.6-0.3,6.3,3.3,8.7c-6.4,0-12.8,0-19.2,0c3.6-2.4,3.3-5.2,3.3-8.7
                            c0-3.1,2.2-5.7,5.1-6.2C11,1.8,13.1,1.8,13.3,3.3L13.3,3.3z M14.6,19.6c-0.2,1.2-1.3,2.2-2.6,2.2s-2.4-0.9-2.6-2.2H14.6L14.6,19.6z"
                            />                        </svg>
							<span class="side-menu__label"> {{ __('general.notifications') }}</span><i class="angle fe fe-chevron-down"></i></a>
						<ul class="slide-menu">
							<li><a class="slide-item" href="{{ route('notify.index') }}"> {{ __('general.show') }}</a></li>
							 
                            <li><a class="slide-item" href="{{ route('notifyme.index') }}">اشعارات ابلغني</a></li>
							 


						</ul>
					</li>
					@endif


					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none"/>
                            <path d="M4.4,16.8c1.1,0,1.9,0.9,1.9,1.9c0,1.1-0.9,1.9-1.9,1.9c-1.1,0-1.9-0.9-1.9-1.9C2.5,17.7,3.4,16.8,4.4,16.8L4.4,16.8z
                            M7.9,17h13.4c0.1,0,0.2,0.1,0.2,0.2v3.1c0,0.1-0.1,0.2-0.2,0.2H7.9c-0.1,0-0.2-0.1-0.2-0.2v-3.1C7.7,17,7.8,17,7.9,17L7.9,17z
                            M7.9,10.2h13.4c0.1,0,0.2,0.1,0.2,0.2v3.1c0,0.1-0.1,0.2-0.2,0.2H7.9c-0.1,0-0.2-0.1-0.2-0.2v-3.1C7.7,10.3,7.8,10.2,7.9,10.2
                           L7.9,10.2z M7.9,3.5h13.4c0.1,0,0.2,0.1,0.2,0.2v3.1c0,0.1-0.1,0.2-0.2,0.2H7.9C7.8,7,7.7,6.9,7.7,6.8V3.7C7.7,3.6,7.8,3.5,7.9,3.5
                           L7.9,3.5z M4.4,10.1c1.1,0,1.9,0.9,1.9,1.9c0,1.1-0.9,1.9-1.9,1.9S2.5,13.1,2.5,12C2.5,10.9,3.4,10.1,4.4,10.1L4.4,10.1z M4.4,3.3
                           c1.1,0,1.9,0.9,1.9,1.9c0,1.1-0.9,1.9-1.9,1.9c-1.1,0-1.9-0.9-1.9-1.9C2.5,4.2,3.4,3.3,4.4,3.3L4.4,3.3z"/></svg>
							<span class="side-menu__label"> {{ __('general.manage orders') }}</span><i class="angle fe fe-chevron-down"></i></a>
						<ul class="slide-menu">
                            <li><a class="slide-item"  href="{{ url('admin/call') }}">الاتصال المباشر</a></li>
							<li><a class="slide-item"  href="{{ route('order.index') }}">{{ __('general.orders') }}<span id="orders-num" class="badge badge-success side-badge"></span></a></li>

							<li><a class="slide-item"  href="{{ route('answer.index') }}">{{ __('general.answers') }}<span id="answers-num" class="badge badge-success side-badge"></span></a></li>
							<li><a class="slide-item"  href="{{ route('comment.index') }}">{{ __('general.comments') }}<span id="comments-num" class="badge badge-success side-badge"></span></a></li>
							<li><a class="slide-item"  href="{{ route('rate.index') }}">التقييمات<span id="rates-num" class="badge badge-success side-badge"></span></a></li>
                        </ul>
					</li>
                    <li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}"><i class="fa fa-paper-plane  side-menu__icon" style="color:#5b6e88;font-size:18px " aria-hidden="true"></i>
							<span class="side-menu__label">المساعدة والدعم</span><i class="angle fe fe-chevron-down"></i></a>
						<ul class="slide-menu">
							<li><a class="slide-item"  href="/admin/message/clients">العملاء</a></li>
							<li><a class="slide-item"  href="/admin/message/experts">الخبراء</a></li> 
                        </ul>
					</li>
					@if(auth()->user()->role=='admin')
					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none"/>
                            <path class="st1" d="M20.8,10.3h-1.5C19.2,9.6,19,9,18.7,8.4l1.1-1.1c0.4-0.4,0.4-1,0-1.3l-1.4-1.4c-0.4-0.4-1-0.4-1.3,0l-1,1
                            c-0.6-0.4-1.2-0.6-1.8-0.8V3.2c0-0.5-0.4-0.9-0.9-0.9h-2c-0.5,0-0.9,0.4-0.9,0.9v1.5C9.6,4.8,9,5,8.4,5.3L7.3,4.2
                            c-0.4-0.4-1-0.4-1.3,0L4.6,5.6C4.2,6,4.2,6.6,4.6,7l1,1C5.2,8.6,5,9.2,4.8,9.8H3.2c-0.5,0-0.9,0.4-0.9,0.9v2c0,0.5,0.4,0.9,0.9,0.9
                            h1.5C4.8,14.4,5,15,5.3,15.6l-1.1,1.1c-0.4,0.4-0.4,1,0,1.3l1.4,1.4c0.4,0.4,1,0.4,1.3,0l1-1c0.6,0.4,1.2,0.6,1.8,0.8v1.6
                            c0,0.5,0.4,0.9,0.9,0.9h2c0.5,0,0.9-0.4,0.9-0.9v-1.5c0.7-0.2,1.3-0.4,1.9-0.7l1.1,1.1c0.4,0.4,1,0.4,1.3,0l1.4-1.4
                            c0.4-0.4,0.4-1,0-1.3l-1-1c0.4-0.6,0.6-1.2,0.8-1.8h1.6c0.5,0,0.9-0.4,0.9-0.9v-2C21.8,10.7,21.3,10.3,20.8,10.3z M12,15.9
                            c-2.2,0-3.9-1.7-3.9-3.9S9.8,8.1,12,8.1c2.2,0,3.9,1.7,3.9,3.9C15.9,14.2,14.2,15.9,12,15.9z"/>                        </svg>
							<span class="side-menu__label">{{ __('general.settings') }}</span><i class="angle fe fe-chevron-down"></i></a>
						<ul class="slide-menu">
							<li><a class="slide-item" href="{{ url('admin/setting') }}">{{ __('general.general setting') }}</a></li>
                            <li><a class="slide-item" href="{{ url('admin/setting/pages/show') }}">الصفحات الثابتة</a></li>
							<li><a class="slide-item" href="{{ route('reason.index') }}">اسباب الرفض</a></li>
						</ul>
					</li>
					@endif
				</ul>
			</div>
		</aside>
<!-- main-sidebar -->
