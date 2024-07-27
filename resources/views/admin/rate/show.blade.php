@extends('admin.layouts.master')
@section('page-title')
{{ __('general.comments') }}
@endsection
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/star-rating/src/css/star-rating-svg.css')}}">

@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">{{ __('general.manage orders') }}</h4>
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
								<div  >
									<h4 class="card-title mg-b-0">ادارة التقييمات</h4>
								 	</div>
									</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="example" class="table text-md-nowrap">
										<thead>
											<tr>
												<th class="border-bottom-0">{{ __('general.order num') }}</th>
											
											 
												<th class="border-bottom-0">العميل</th>
												<th class="border-bottom-0">{{ __('general.service') }}</th>
												<th class="border-bottom-0">{{ __('general.expert') }}</th>

												<th class="border-bottom-0">التقييم</th>
                                                <th class="border-bottom-0">{{ __('general.status') }}</th>
												
                                                <th class="border-bottom-0">{{ __('general.action') }}</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($selectedservices as $selectedservice)
											<tr>
												<td>{{$selectedservice->order_num }}</td>
											
												 
												<td>{{$selectedservice->client->user_name  }}</td>
												<td>{{$selectedservice->service->name }}</td>
												<td>{{ $selectedservice->expert->full_name }}</td>
												 
												<td style="width: 100px;"><div class="my-rating-8" data-rating="{{ $selectedservice->rate}}"></div></td>
                                                <td>{{ $selectedservice->rate_state_conv}}</td>
												
                                                <td>
													@if ($selectedservice->rate_state=='wait')
													<button type="button"	id="{{ $selectedservice->id }}" class="btn btn-success btn-sm rate_btn" data-effect="effect-scale" data-toggle="modal" data-target="#modaldemo8" title="موافقة او رفض"><i class="fa fa-edit"></i></button>
												
													@endif
													 
                                                </td>

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
		<form  name="agree_form"  id="agree_form"
		action="{{ route('rate.agree', 'itemid') }}" method="POST">
		@csrf
		</form>
		<form  name="reject_form"  id="reject_form"
		action="{{ route('rate.reject', 'itemid') }}" method="POST">
		@csrf
		</form>
			<!-- Modal effects -->
			<div class="modal" id="modaldemo8">
				<div class="modal-dialog modal-dialog-centered   modal-sm" role="document">
					
					<div class="modal-content modal-content-demo">
						<div class="modal-header">
							<h6 class="modal-title"></h6><button aria-label="Close" class="close"
								data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
						</div>
						 
						<div class="modal-body text-center" style="padding-bottom: 5px;	padding-top: 30px;">
							<h6 class="modal-title">{{ __('general.the rate') }}</h6>
						
								 </div>
						<div class="modal-footer d-flex justify-content-between">                                  
                                    <button type="submit" name="btn_agree_state" id="btn_agree_state" form="agree_form"
                                        class="btn btn-primary">موافقة</button>
                                   
                                    <button type="button" name="btn_reject_state"  id="btn_reject_state" form="reject_form"
                                        class="btn btn-danger">رفض</button>                            
						</div>
					</div>
				</div>
			</div>
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
<script src="{{URL::asset('assets/js/admin/rate.js')}}"></script>
 
	 
	<script  > 
	var urlagree ="{{route('rate.agree','itemid')}}"; 
		var urlreject ="{{route('rate.reject','itemid')}}"; 
	
		</script>

<script>
	$(function() {
	
	  // basic use comes with defaults values
	  
	
	  $(".my-rating-2").starRating({
		totalStars: 5,
		starSize: 30,
		starShape: 'rounded',
		emptyColor: 'lightgray',
		hoverColor: 'salmon',
		activeColor: 'crimson',
		useGradient: false
	  });
	
	  // example grabing rating from markup, and custom colors
	  $(".my-rating-4").starRating({
		totalStars: 5,
		starShape: 'rounded',
		starSize: 40,
		emptyColor: 'lightgray',
		hoverColor: 'salmon',
		activeColor: 'crimson',
		useGradient: false
	  });
	
 
 
	
	 
	
	  $(".my-rating-8").starRating({
		totalStars: 5,
		useFullStars: true,
		readOnly: true,
		starSize: 20,
	  });
	
	  
	
	});
	</script>
	<script src="{{URL::asset('assets/star-rating/src/jquery.star-rating-svg.js')}}"></script>
@endsection
