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
							<h4 class="content-title mb-0 my-auto">حالات الخبراء</h4> 
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
									<h4 class="card-title mg-b-0">ادارة الحالات</h4>
									 
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

												<td>{{$expert->user_name }}</td>
												<td>{{ $expert->full_name }}</td>
												<td>{{ $expert->email }}</td>
												<td>{{ $expert->status_conv }}</td>
                                                <td>
													<button class="btn btn-success btn-sm btn-modal" data-target="#scrollmodal" data-toggle="modal" title="{{ __('general.edit') }}" id="expert-{{$expert->id }}" ><i class="fa fa-edit"></i></a> 
                                                     
                                                  

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
		   <!-- Scroll with content modal -->
		   <div class="modal" id="scrollmodal">
			<div class="modal-dialog modal-dialog-scrollable" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">تعديل حالة الخبير</h6><button aria-label="Close" class="close"
							data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<!-- row -->
						<div class="row row-sm">
							<div class="col">
								<div class="card  box-shadow-0">
									<div class="card-body pt-4">
										<form class="form-horizontal" name="expert_form"
											action="#" method="POST"
											id="expert_form">
											@csrf
											<div class="form-group mb-3">
												<select name="status" id="status"
													class="form-control SlectBox">
													<!--placeholder-->
													<option title="" value="0"  class="text-muted">اختر الحالة</option>													 
														<option value="a">{{ __('general.available') }}</option>
														<option value="b">{{ __('general.notavailable') }}</option>
														<option value="n">	{{ __('general.busy') }}</option>
												</select>
												<ul class="parsley-errors-list filled">
													<li class="parsley-required" id="select_expert_error"></li>
												</ul>
											</div>	
										</form>
									</div>	
								</div>
							</div>
						</div>
						<!-- row -->
					</div>
					<div class="modal-footer">
						<button class="btn ripple btn-primary" type="submit" form="expert_form" name="btn_update_state"
							id="btn_update_state" type="button">تعديل</button>
						<button class="btn ripple btn-secondary" data-dismiss="modal" name="btn_cancel_field"
							id="btn_cancel_field" type="button"> إلغاء</button>
					</div>
				</div>
			</div>
		</div>
		<!--End Scroll with content modal -->
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
<script >
 
	var urlgetstate="{{ url('admin/expert/statusbyid','itemid') }}";
	var urlupdatestate="{{ url('admin/expert/updatestatus','itemid') }}";
</script>
<script src="{{URL::asset('assets/js/admin/expertstate.js')}}"></script>


@endsection
