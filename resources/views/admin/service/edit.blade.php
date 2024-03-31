@extends('admin.layouts.master')
@section('page-title')
{{ __('general.services') }}
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

<!---Internal Owl Carousel css-->
<link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet">
<!---Internal  Multislider css-->
<link href="{{URL::asset('assets/plugins/multislider/multislider.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto"><a href="{{ route('service.index') }}">{{ __('general.services') }}</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"></span>
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
								<h4 class="card-title mb-1">{{ __('general.service info') }}</h4>
								<p class="mb-2"> </p>
							</div>
							<div class="card-body row  pt-0">
                                <div class="col-lg-8">
								<form class="form-horizontal" name="create_form" action="{{route('service.update', $service->id)}}" method="POST" enctype="multipart/form-data" id="create_form">
									@csrf
									<div class="form-group">
										<input type="text" class="form-control " id="name" placeholder="{{ __('general.service_name') }}" name="name" value="{{ $service->name }}">
										<ul class="parsley-errors-list filled" >
											<li class="parsley-required" id="name_error"></li>
										</ul>

									</div>

                                    <div class="form-group">
                                        <div class="my-4">
                                            <textarea class="form-control" placeholder="{{ __('general.descreption') }}" rows="3" id="desc" name="desc">{{$service->desc}}</textarea>
                                        </div>									    <ul class="parsley-errors-list filled" >
											<li class="parsley-required" id="desc_error"></li>
										</ul>
									</div>
                                    <div class="form-group mb-4 justify-content-end">
										<div class="custom-file">
											<input class="custom-file-input" id="image" name="image" type="file"> <label class="custom-file-label" for="customFile"  id="image_label">{{ __('general.choose image') }}</label>
											<ul class="parsley-errors-list filled" >
												<li class="parsley-required" id="image_error"></li>
											</ul>
										</div>
									</div>
                                    <div class="form-group mb-4 justify-content-end">
										<div class="custom-file">
											<input class="custom-file-input" id="icon" name="icon" type="file"> <label class="custom-file-label" for="customFile"  id="icon_label">{{ __('general.choose svg') }}</label>
											<ul class="parsley-errors-list filled" >
												<li class="parsley-required" id="icon_error"></li>
											</ul>
										</div>
									</div>
									<div class="form-group justify-content-end">
										<div class="checkbox">
											<div class="custom-checkbox custom-control">
												<input type="checkbox" data-checkboxes="mygroup" @if ( $service->is_active=='1') @checked(true) @endif  class="custom-control-input" id="checkbox-2" value="{{ $service->is_active }}" name="is_active">
												<label for="checkbox-2" class="custom-control-label mt-1"  >{{ __('general.is_active') }}</label>
											</div>

										</div>
										<ul class="parsley-errors-list filled" >
											<li class="parsley-required" id="is_active_error"></li>
										</ul>
									</div>
									<div class="form-group mb-0 mt-3 justify-content-end">
										<div>
											<button type="submit" name="btn_update_user" id="btn_update_user" class="btn btn-primary">{{ __('general.save') }}</button> 
											<a href="{{ route('service.index') }}">	<button type="button" name="btn_cancel_edit" id="btn_cancel_edit"  class="btn btn-secondary">{{ __('general.cancel') }}</button></a>
										</div>
									</div>
								</form>
       
                            </div>
                            <div class="col-lg-4 mt-sm-3 mt-lg-0">
							 
									<img alt="" id="imgshow" class="rounded img-thumbnail wd-100p float-sm-right  mg-t-10 mg-sm-t-0"
									src="@if($service->image==""){{URL::asset('assets/img/photos/1.jpg')}}@else {{ $service->fullpathimg }} @endif" >
								 
                              
									<img alt="" id="iconshow" class="rounded img-thumbnail wd-100p float-sm-right  mg-t-10 mg-sm-t-0"
									src="@if($service->icon==""){{URL::asset('assets/img/photos/1.jpg')}} @else {{ $service->fullpathsvg }} @endif" >
							 
                            </div>
							</div>


                            <div class="col">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div>
                                            <h6 class="card-title">البيانات الشخصية</h6>
                                        </div>
                                        <form class="form-horizontal" name="personal_form" action="{{url('admin/service/savepersonal', $service->id)}}" method="POST" enctype="multipart/form-data" id="personal_form" >
                                            @csrf
                                            <div class="row">
                                                <div class="form-group mb-0 justify-content-end col-6 col-lg-3">
                                                    <div class="checkbox">
                                                        <div class="custom-checkbox custom-control">
                                                            <input type="checkbox"  @if ( $personal_array['user_name']==1) @checked(true) @endif  value="{{ $personal_array['user_name'] }}"   name="user_name" data-checkboxes="mygroup" class="custom-control-input" id="puser_name">
                                                            <label for="puser_name" class="custom-control-label mt-1">الاسم</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-0 justify-content-end col-6 col-lg-3">
                                                    <div class="checkbox">
                                                        <div class="custom-checkbox custom-control">
                                                            <input type="checkbox" name="nationality" @if ( $personal_array['nationality']==1) @checked(true) @endif  value="{{ $personal_array['nationality'] }}" data-checkboxes="mygroup" class="custom-control-input" id="pnationality">
                                                            <label for="pnationality" class="custom-control-label mt-1">الجنسية</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-0 justify-content-end col-6 col-lg-3">
                                                    <div class="checkbox">
                                                        <div class="custom-checkbox custom-control">
                                                            <input type="checkbox" name="gender" @if ( $personal_array['gender']==1) @checked(true) @endif  value="{{ $personal_array['gender'] }}" data-checkboxes="mygroup" class="custom-control-input" id="pgender">
                                                            <label for="pgender" class="custom-control-label mt-1">الجنس</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-0 justify-content-end col-6 col-lg-3">
                                                    <div class="checkbox">
                                                        <div class="custom-checkbox custom-control">
                                                            <input type="checkbox" name="birthdate" @if ( $personal_array['birthdate']==1) @checked(true) @endif  value="{{ $personal_array['birthdate'] }}"  data-checkboxes="mygroup" class="custom-control-input" id="pbirthdate">
                                                            <label for="pbirthdate" class="custom-control-label mt-1">تاريخ الميلاد</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-0 justify-content-end col-6 col-lg-3">
                                                    <div class="checkbox">
                                                        <div class="custom-checkbox custom-control">
                                                            <input type="checkbox" name="marital_status" @if ( $personal_array['marital_status']==1) @checked(true) @endif  value="{{ $personal_array['marital_status'] }}" data-checkboxes="mygroup" class="custom-control-input" id="pmarital_status">
                                                            <label for="pmarital_status" class="custom-control-label mt-1">الحالة الاجتماعية</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-0 mt-3 justify-content-end">
                                                <div>
                                                    <button type="submit"  name="btn_save_personal" id="btn_save_personal" class="btn btn-primary">{{ __('general.save') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div>
                                            <h6 class="card-title">بيانات إضافية</h6>
                                        </div>
                                        <form class="form-horizontal" name="imgrecord_form" action="{{url('admin/service/saveimgrecord', $service->id)}}" method="POST" enctype="multipart/form-data" id="imgrecord_form" >
                                            @csrf
                                            <div class="row mb-2">
                                                <div class="form-group mb-3 d-flex justify-content-center col-6 col-lg-3">
                                                    <div class="checkbox">
                                                        <div class="custom-checkbox custom-control">
                                                            <input type="checkbox" name="record"  @if ( $recimg_array['record']==1) @checked(true) @endif  value="{{ $recimg_array['record'] }}"  data-checkboxes="mygroup" class="custom-control-input" id="record">
                                                            <label for="record" class="custom-control-label mt-1">تسجيل صوتي</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-3 d-flex justify-content-center col-6 col-lg-3">
                                                    <div class="checkbox">
                                                        <div class="custom-checkbox custom-control">
                                                            <input type="checkbox" name="image" @if ( $recimg_array['image']==1) @checked(true) @endif  value="{{ $recimg_array['image'] }}"  data-checkboxes="mygroup" class="custom-control-input" id="image_check">
                                                            <label for="image_check" class="custom-control-label mt-1">صور</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-0 col-6 col-lg-3">
                                                    <div class="number-input" id="image_count_div">
                                                        <div class="form-group">
                                                            <input type="number" name="image_count" class="form-control" min="1" max="4" value="@if($recimg_array['image']==1){{$recimg_array['image_count']}}@else{{'1'}}@endif" id="image_count" placeholder="عدد الصور">
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="mb-0 col-6 col-lg-3">
                                                    <a class="btn ripple btn-light" data-target="#scrollmodal" data-toggle="modal" id="btn_showinput" ><i class="fa fa-plus"></i> إضافة حقل</a>
                                                </div>

                                            </div>
                                        </form>
                                        <div class="">
                                            <div>
                                                <h6 class="card-title">حقول الخدمة المختارة</h6>
                                            </div>
                                            <div id="div_extrainputs" ></div>
                                        </div>
                                        <div class="form-group mb-0">
                                            <div>
                                                <button type="submit" form ="imgrecord_form" name="btn_save_imgrecord" id="btn_save_imgrecord" class="btn btn-primary">حفظ</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

						</div>
					</div>
				</div>
				<!-- row -->
                
                 
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->

  
   
	

		<!-- Scroll with content modal -->
		<div class="modal" id="scrollmodal">
			<div class="modal-dialog modal-dialog-scrollable" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">إضافة حقل جديد للخدمة</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
                        <!-- row -->
                        <div class="row row-sm">
                            <div class="col">
                                <div class="card  box-shadow-0">
                                    <div class="card-body pt-4">
                                        <form class="form-horizontal" name="field_form" action="{{url('admin/service/savefield', $service->id)}}" method="POST" enctype="multipart/form-data" id="field_form" >
                                          @csrf

                                            <div class="form-group">
                                                <input type="text" class="form-control " id="field_name" placeholder="{{ __('general.field_name') }}" name="field_name">
                                                <ul class="parsley-errors-list filled" >
                                                    <li class="parsley-required" id="field_name_error"></li>
                                                </ul>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control " id="field_tooltipe" placeholder="التلميح" name="field_tooltipe">
                                                <ul class="parsley-errors-list filled" >
                                                    <li class="parsley-required" id="field_tooltipe_error"></li>
                                                </ul>
                                            </div>
                                            {{-- image --}}
                                            <div class="form-group mb-4 justify-content-end">
                                                <div class="custom-file">
                                                    <input class="custom-file-input" id="field_icon" name="field_icon" type="file"> <label class="custom-file-label" id="field_icon_label" for="customFile">{{ __('general.choose svg') }}</label>
                                                    <ul class="parsley-errors-list filled" >
                                                        <li class="parsley-required" id="field_icon_error"></li>
                                                    </ul>
                                                </div>

                                            </div>
                                            <div class="form-group mb-3">
                                                <select name="field_type"   id="field_type" class="form-control SlectBox"  >
                                                    <!--placeholder-->
                                                    <option title="" selected  class="text-muted">نوع الحقل</option>
                                                    <option value="text">حقل نصي</option>
                                                    <option value="bool">قائمة نعم/لا</option>
                                                    <option value="list">قائمة متعدد</option>
                                                    <option value="date">حقل تاريخ</option>
                                                    <option value="longtext">حقل نصي طويل</option>
                                                </select>
                                                <ul class="parsley-errors-list filled">
                                                    <li class="parsley-required"  id="field_type_error"></li>
                                                </ul>
                                            </div>

                                            <div id="option_append">
                                        
                                            <div class="form-group add-input" id="divoptionhide" style="display: none;">
                                                <input type="text" class="form-control" id="list_optionhide" value="" placeholder="ادخل الاختيار" name="list_optionhide">
                                                <button class="close" type="button" onclick="this.parentElement.remove();" ><span>×</span></button>
                                                <ul class="parsley-errors-list filled" >
                                                    <li class="parsley-required" id="list_option_error"></li>
                                                </ul>
                                            </div>
                                            </div>
                                            <div class="form-group mb-4 justify-content-end">
                                                <div>
                                                    <button type="button" name="btn_add_option" id="btn_add_option" class="btn btn-light btn-block"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>


                            </div>
                        </div>
                        <!-- row -->
					</div>
					<div class="modal-footer">
						<button class="btn ripple btn-primary" name="btn_save_field" id="btn_save_field" type="submit">حفظ</button>
						<button class="btn ripple btn-secondary" data-dismiss="modal"  name="btn_cancel_field" id="btn_cancel_field" type="button"> إلغاء</button>
					</div>
				</div>
			</div>
		</div>
		<!--End Scroll with content modal -->
 
		<!-- Scroll Edit with content modal -->
		<div class="modal" id="scrollmodal-edit">
			
		</div>
		<!--End Scroll with content modal -->
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
<!-- Internal Modal js-->
<script src="{{URL::asset('assets/js/modal.js')}}"></script>
<!--Internal  pickerjs js -->
<script src="{{URL::asset('assets/plugins/pickerjs/picker.min.js')}}"></script>
<!-- Internal form-elements js -->
<script src="{{URL::asset('assets/js/form-elements.js')}}"></script>

<script src="{{URL::asset('assets/js/admin/validate.js')}}"></script>
<script src="{{URL::asset('assets/js/admin/content.js')}}"></script>
<script src="{{URL::asset('assets/js/admin/service-input.js')}}"></script>
<script src="{{URL::asset('assets/js/form-elements.js')}}"></script>
<script  >
var emptyimg ="{{URL::asset('assets/img/photos/1.jpg')}}"</script>
<script  > urlshowinput ="{{url('admin/service/showinputs',$service->id)}}"; 
    delinputurl ='{{url("admin/input/delete/[itemid]")}}'; 

	</script>
     
@endsection

