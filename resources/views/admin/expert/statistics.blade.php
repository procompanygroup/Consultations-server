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
							<h4 class="content-title mb-0 my-auto">{{ __('general.experts') }}</h4> 
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
									<h4 class="card-title mg-b-0">احصائيات الخبراء</h4>
									 
								</div>
									</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="example" class="table text-md-nowrap">
										<thead>
											<tr>
												<th class="border-bottom-0">الخبير</th>
												<th class="border-bottom-0">الاسم الكامل</th>
												<th class="border-bottom-0">سرعة الرد</th>                                              
												<th class="border-bottom-0">العملية</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($sts_list as $sts)
											<tr>
												<td>{{$sts->user_name}}</td>
												<td>{{$sts->full_name}}</td>
												<td>{{ $sts['answer_speed']  }}</td>												 
												<td>
												<a href="{{url('admin/experts/statistics', $sts->id)}}"  class="btn btn-success btn-sm" title="تفاصيل"><i class="fa fa-info"></i></a> 
                                                </td>
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
			<!-- Modal effects -->
		
			<!-- End Modal effects-->
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
