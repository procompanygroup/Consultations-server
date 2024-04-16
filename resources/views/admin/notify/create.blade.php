@extends('admin.layouts.master')
@section('page-title')
{{ __('general.notifications') }}
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
							<h4 class="content-title mb-0 my-auto"><a href="{{ route('notify.index') }}">{{ __('general.notifications') }}</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"></span>
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
								<h4 class="card-title mb-1">{{ __('general.send_notify') }}</h4>
								<p class="mb-2"></p>
							</div>
							<div class="card-body pt-0">
								<form class="form-horizontal" name="create_form" action="{{url('admin/notify')}}" method="POST"  id="create_form">
									@csrf
									<div class="form-group mb-3">
										<select name="type" id="type"
											class="form-control SlectBox">
											<!--placeholder-->
											<option title="" selected class="text-muted">اختر نوع التنبيه</option>										 
												<option value="text">نص</option>
												<option value="image">صورة</option>
												<option value="video">فيديو</option>
										</select>
										<ul class="parsley-errors-list filled">
											<li class="parsley-required" id="type_error"></li>
										</ul>
									</div>
									<div class="form-group">
										<input type="text" class="form-control " id="title"  placeholder="{{ __('general.title') }}" name="title">
										<ul class="parsley-errors-list filled" >
											<li class="parsley-required" id="title_error"></li>
										</ul>
										 
									</div>

									<div class="my-4">
										<textarea class="form-control" placeholder="{{ __('general.text') }}" rows="3" id="body" name="body"></textarea>
									</div>

                                    <div class="form-group mb-4 justify-content-end" id="div_file">
										<div class="custom-file">
											<input class="custom-file-input" id="image" name="image" type="file"> <label class="custom-file-label" for="customFile"  id="image_label">{{ __('general.choose file') }}</label>
											<ul class="parsley-errors-list filled" >
												<li class="parsley-required" id="image_error">@php echo ini_get('upload_max_filesize');@endphp</li>
											</ul>
										</div>
									</div>
									<div class="form-group justify-content-end row"  id="side">
										<div  class=" col-sm-4">
											<div class="row">
											
										<div class="checkbox col-sm-3 ">
											<div class="custom-checkbox custom-control">
												<input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-2" value="expert" name="side[]">
												<label for="checkbox-2" class="custom-control-label mt-1"  >{{ __('general.experts') }}</label>
											</div>
											
										</div>
										<div class="checkbox  col-sm-9 ">
											<div class="custom-checkbox custom-control">
												<input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-3" value="client" name="side[]">
												<label for="checkbox-3" class="custom-control-label mt-1"  >{{ __('general.clients') }}</label>
											</div>
										</div>
										</div>
									</div>
										<div class="checkbox  col-sm-8">
										</div>
									</div>
									<ul class="parsley-errors-list filled" >
										<li class="parsley-required" id="side_error"></li>
									</ul>
									<div class="form-group mb-0 mt-3 justify-content-end">
										<div>
											<button type="submit" name="btn_save" id="btn_save" class="btn btn-primary">{{ __('general.send') }}</button>
											<button type="button" name="btn_cancel" id="btn_cancel"  class="btn btn-secondary">{{ __('general.cancel') }}</button>				
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
<script src="{{URL::asset('assets/js/admin/content.js')}}"></script>
<script src="{{URL::asset('assets/js/form-elements.js')}}"></script>
<script  >  
var emptyimg ="{{URL::asset('assets/img/photos/1.jpg')}}"</script>
 
@endsection
