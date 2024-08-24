@extends('admin.layouts.master')
@section('page-title')
الاتصال المباشر
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
							<h4 class="content-title mb-0 my-auto">الاتصال المباشر</h4> 
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
									<h4 class="card-title mg-b-0">الاتصالات المباشرة</h4>
								 	</div>
									</div>
								 
							<div class="card-body">
								<div class="table-responsive">
									<table id="example" class="table text-md-nowrap">
										<thead>
											<tr>
												<th class="border-bottom-0">{{ __('general.order num') }}</th>
											
												<th class="border-bottom-0">{{ __('general.service') }}</th>
												<th class="border-bottom-0">{{ __('general.expert') }}</th>
											
                                                <th class="border-bottom-0">{{ __('general.client') }}</th>
												<th class="border-bottom-0">مدة الاتصال /ثانية:دقيقة/</th>
                                                <th class="border-bottom-0">{{ __('general.action') }}</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($selectedservices as $selectedservice)
											<tr>
												<td>{{$selectedservice->order_num }}</td>
												<td>{{$selectedservice->service->name }}</td>
												<td>{{ $selectedservice->expert->full_name }}</td>
                                                <td>{{ $selectedservice->client->user_name }}</td>
												<td>{{ $selectedservice->call_duration==null?'-': $selectedservice->call_duration }}</td>
                                                <td>
													<a href="{{url('admin/call',$selectedservice->id)}}"  class="btn btn-success btn-sm" title="{{ __('general.detail') }}"><i class="fa fa-edit"></i></a> 
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
@endsection
