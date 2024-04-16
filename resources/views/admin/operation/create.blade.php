@extends('admin.layouts.master')
@section('page-title')
{{ __('general.accounts') }}
@endsection
@section('css')
<!-- Internal Select2 css -->
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!--Internal  Datetimepicker-slider css -->
<link href="{{URL::asset('assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/pickerjs/picker.min.css')}}" rel="stylesheet">
<!-- Internal Spectrum-colorpicker css -->
<link href="{{URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css')}}" rel="stylesheet">

<link href="{{URL::asset('assets/css/admin/content.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto"><a href="{{ url('admin/balance/pulls') }}">{{ __('general.accounts') }}</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"></span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row row-sm">
					<div class="col">
						<div class="card  box-shadow-0">
							<div class="card-header">
								<h4 class="card-title mb-1">{{ __('general.pull balance') }}</h4>
								<p class="mb-2"> </p>
							</div>
							<div class="card-body pt-0">
								<form class="form-horizontal" name="save_pull_form" action="{{url('admin/balance/savepull' )}}" method="POST"   id="save_pull_form">
									@csrf
									<div class="mb-4" style="display: none;">
                                        <select name="sel_side"   id="sel_side" class="form-control SlectBox"   >
                                            <!--placeholder-->
                                          
                                            <option value="expert" selected>{{ __('general.expert select') }}</option>
                                        
                                        </select>
										<ul class="parsley-errors-list filled">
											<li class="parsley-required"  id="sel_side_error"></li>
										</ul>
                                    </div>
									<div class="mb-4">
                                        <select name="sel_side_val"   id="sel_side_val" class="form-control SlectBox"   >
                                            <!--placeholder-->
                                            <option title="الاسم" value="0"  class="text-muted">اختر</option>
                                        
                                        </select>
										
										<ul class="parsley-errors-list filled">
											<li class="parsley-required"  id="sel_side_val_error"></li>
										</ul>
                                    </div>
									 
									<div class="form-group">
										<p class="filled" id="p_show_balance" style="display: none">
											<span   id="balance_title">الرصيد الحالي: </span> <span  id="balance_val"></span> 
										</p>
										<input type="text" class="form-control " id="amount" placeholder="{{ __('general.pull value') }}" name="amount" value="">
										<ul class="parsley-errors-list filled" >
											<li class="parsley-required" id="amount_error"></li>
										</ul>										 
									</div>								 
									<div class="form-group mb-0 mt-3 justify-content-end">
										<div>
											<button type="submit" name="btn_save_pull" id="btn_save_pull" class="btn btn-primary">{{ __('general.save') }}</button>
											<a href="{{ url('admin/balance/pulls') }}"><button type="button" name="btn_cancel_edit" id="btn_cancel_edit"  class="btn btn-secondary">{{ __('general.cancel') }}</button></a>
										</div>
									</div>
								</form>
							 
							</div>
						</div>
					</div>
				</div>
				<!-- row -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!--Internal  jquery.maskedinput js -->
<script src="{{URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js')}}"></script>
<!--Internal  spectrum-colorpicker js -->
<script src="{{URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js')}}"></script>
<!-- Internal Select2.min js -->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!--Internal Ion.rangeSlider.min js -->
<script src="{{URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js')}}"></script>
<!--Internal  jquery-simple-datetimepicker js -->
<script src="{{URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js')}}"></script>
<!-- Ionicons js -->
<script src="{{URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js')}}"></script>
<!--Internal  pickerjs js -->
<script src="{{URL::asset('assets/plugins/pickerjs/picker.min.js')}}"></script>
<!-- Internal form-elements js -->
<script src="{{URL::asset('assets/js/form-elements.js')}}"></script>

<script src="{{URL::asset('assets/js/admin/validate.js')}}"></script>
 
<script src="{{URL::asset('assets/js/admin/pull.js')}}"></script>
<script src="{{URL::asset('assets/js/form-elements.js')}}"></script>
<script  >  
var emptyimg ="{{URL::asset('assets/img/photos/1.jpg')}}";
 var blncesidurl="{{ url('admin/balance/getbyside') }}";
 var datalist="";
 </script>
@endsection
