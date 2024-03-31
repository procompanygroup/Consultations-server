@extends('admin.layouts.master')
@section('css') 
@endsection
@section('page-title')
{{ __('general.cpanel') }}
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">{{ __('general.cpanel') }}</h4> 
						</div>
					</div>
				 
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
			 
					<div class="row row-sm">
						<div class="col-lg-6 col-xl-3 col-md-6 col-12">
							<div class="card bg-primary-gradient text-white ">
								<div class="card-body">
									<div class="row">
										<div class="col-6">
											<div class="icon1 mt-2 text-center">
												<i class="fe fe-users tx-40"></i>
											</div>
										</div>
										<div class="col-6">
											<div class="mt-0 text-center">
												<span class="text-white">{{ __('general.experts') }}</span>
												<h2 class="text-white mb-0">{{ $experts_count }}</h2>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-xl-3 col-md-6 col-12">
							<div class="card bg-danger-gradient text-white">
								<div class="card-body">
									<div class="row">
										<div class="col-6">
											<div class="icon1 mt-2 text-center">
										
												<i class="fe fe-users tx-40"></i>
											</div>
										</div>
										<div class="col-6">
											<div class="mt-0 text-center">
												<span class="text-white">{{ __('general.clients') }}</span>
												<h2 class="text-white mb-0">{{ $clients_count }}</h2>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-xl-3 col-md-6 col-12">
							<div class="card bg-success-gradient text-white">
								<div class="card-body">
									<div class="row">
										<div class="col-6">
											<div class="icon1 mt-2 text-center">
												<i class="fe fe-shopping-cart tx-40"></i>
											</div>
										</div>
										<div class="col-6">
											<div class="mt-0 text-center">
												<span class="text-white">{{ __('general.services') }}</span>
												<h2 class="text-white mb-0">{{ $services_count }}</h2>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-xl-3 col-md-6 col-12">
							<div class="card bg-warning-gradient text-white">
								<div class="card-body">
									<div class="row">
										<div class="col-6">
											<div class="icon1 mt-2 text-center">
												<i class="fe fe-bar-chart-2 tx-40"></i>
											</div>
										</div>
										<div class="col-6">
											<div class="mt-0 text-center">
												<span class="text-white">{{ __('general.calls count') }}</span>
												<h2 class="text-white mb-0">{{ $calls_count }}</h2>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
	 
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
@endsection