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
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">التواصل المباشر</h4> 
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
									<h4 class="card-title mg-b-0">التواصل مع الخبراء</h4>
									{{-- <a href="{{ route('expert.create') }}" class="btn btn-primary btn-small">{{ __('general.new expert') }}</a> --}}
								</div>
									</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="example" class="table text-md-nowrap">
										<thead>
											<tr>

												<th class="border-bottom-0">{{ __('general.user_name') }}</th>
												<th class="border-bottom-0">الاسم الكامل</th>
												<th class="border-bottom-0">{{ __('general.email') }}</th>
												<th class="border-bottom-0">الحالة</th>
                                                <th class="border-bottom-0">{{ __('general.action') }}</th>

											</tr>
										</thead>
										<tbody>
											@foreach ($experts as $expert)
											<tr>
												 
												<td>{{$expert['expert']->user_name }}</td>
												<td>{{$expert['expert']->full_name }}</td>
												<td>{{ $expert['expert']->email }}</td>
												<td class="text-center">@if ( $expert['status']=='new')
													<i class="fa fa-circle" style="color: #22c03c" aria-hidden="true"></i>@endif
                                                <td>
													<a href="{{url('admin/message/expert', $expert['expert']->id)}}"  class="btn btn-success btn-sm"  ><i class="fa fa-edit"></i></a> 
													<form action="{{url('admin/message/destroyexpert', $expert['expert']->id)}}" method="POST" class="d-inline">
														@csrf
														@method('DELETE')
														<button type="button" id="del-{{$expert['expert']->id}}" class="btn btn-danger btn-sm delete" data-effect="effect-scale" data-toggle="modal" data-target="#modaldemo8"   title="حذف المحادثة"><i class="fa fa-trash"></i></button>
													</form>
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
			<!-- Modal effects -->
			<div class="modal" id="modaldemo8">
				<div class="modal-dialog modal-dialog-centered   modal-sm" role="document">
					<div class="modal-content modal-content-demo">
						 
						<div class="modal-body text-center" style="padding-bottom: 5px;	padding-top: 30px;">
							<h6 class="modal-title">{{ __('general.Are you sure') }}</h6>
								 </div>
						<div class="modal-footer d-flex justify-content-between">
							<button class="btn ripple btn-danger" id="btn-modal-del" type="button">{{ __('general.delete') }}</button>
							<button class="btn ripple btn-secondary"  id="btn-cancel-modal"  data-dismiss="modal" type="button">{{ __('general.cancel') }}</button>
						</div>
					</div>
				</div>
			</div>
			<!-- End Modal effects-->
				<!-- Modal effects -->
				<div class="modal" id="modaldemo8">
					<div class="modal-dialog modal-dialog-centered   modal-sm" role="document">
						<div class="modal-content modal-content-demo">
							 
							<div class="modal-body text-center" style="padding-bottom: 5px;	padding-top: 30px;">
								<h6 class="modal-title">{{ __('general.Are you sure') }}</h6>
									 </div>
							<div class="modal-footer d-flex justify-content-between">
								<button class="btn ripple btn-danger" id="btn-modal-del" type="button">{{ __('general.delete') }}</button>
								<button class="btn ripple btn-secondary"  id="btn-cancel-modal"  data-dismiss="modal" type="button">{{ __('general.cancel') }}</button>
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
<script src="{{URL::asset('assets/js/admin/delete.js')}}"></script>
@endsection
