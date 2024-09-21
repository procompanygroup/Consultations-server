@extends('admin.layouts.master')
@section('page-title')
{{ __('general.experts') }}
@endsection
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/star-rating/src/css/star-rating-svg.css')}}">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">

<link rel="stylesheet" href="{{URL::asset('assets/plugins/rating/ratings.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/rating/themes/css-stars.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/rating/themes/bootstrap-stars.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/rating/themes/fontawesome-stars-o.css')}}">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<a href="{{ url('admin/experts/statistics') }}"><h4 class="content-title mb-0 my-auto">احصائيات الخبراء</h4></a>
						</div>
					</div>
					 
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row opened -->
				<div class="row row-sm">


					<!--div-->
					<div class="col-xl-12">
						<div class="card mg-b-20">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									<h4 class="card-title mg-b-0">احصائيات الخبير: {{ $expert->full_name }}</h4>
									 
								</div>
									</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="example" class="table text-md-nowrap">
										<thead>
											<tr> 
                                                <th class="border-bottom-0">الخدمة</th>
												<th class="border-bottom-0">التقييم</th>
												<th class="border-bottom-0">عدد الطلبات</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($sts_list['service_statistics'] as $sts)
											<tr>
 
												<td>{{ $sts['name']  }}</td>
											 <td style="width: 100px;">
												<div class="static-rate text-center fs-30">
													@php $n=5-$sts['rate']; @endphp
													@for ($i = 1; $i <= $sts['rate']; $i++)
													<i class="fa fa-star text-warning" aria-hidden="true"></i>
													@endfor
													@for ($i = 1; $i <= $n; $i++)
													<i class="fa fa-star "  style="color: lightgray" aria-hidden="true"></i>
													@endfor
												</div>
											</td>
										 
												<td>{{ $sts['orders_count'] }}</td>

											</tr>
											@endforeach
									</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!--/div-->


				</div>
				<!-- /row -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->

@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
 

	<script src="{{URL::asset('assets/plugins/rating/jquery.rating-stars.js')}}"></script>
	<script src="{{URL::asset('assets/plugins/rating/jquery.barrating.js')}}"></script>
	<script src="{{URL::asset('assets/plugins/rating/ratings.js')}}"></script>
	 
@endsection
