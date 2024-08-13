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
							<h4 class="content-title mb-0 my-auto"><a href="{{ route('notifyme.index') }}">{{ __('general.notifications') }}</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"></span>
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
								<h4 class="card-title mb-1">ارسال اشعار ابلغني</h4>
								<p class="mb-2"></p>
							</div>
							<div class="card-body pt-0">
								<form class="form-horizontal" name="create_form" action="{{url('admin/notifyme')}}" method="POST"  id="create_form">
									@csrf
									<div class="mb-4">
                                        <select name="expert_id"   id="expert_id" class="form-control SlectBox"   >
                                            <!--placeholder-->
                                            <option title="اختر الخبير" value="0"  class="text-muted">اختر الخبير</option>
                                        @foreach ($experts as $expert )
										<option   value="{{ $expert->id }}"  class="text-muted">{{ $expert->user_name }} - {{ $expert->full_name  }}</option>
										@endforeach
                                        </select>
										
										<ul class="parsley-errors-list filled">
											<li class="parsley-required"  id="expert_id_error"></li>
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
