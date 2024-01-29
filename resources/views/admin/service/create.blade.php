@extends('admin.layouts.master')
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
							<h4 class="content-title mb-0 my-auto"><a href="{{ route('expert.index') }}">{{ __('general.services') }}</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('general.new service') }}</span>
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
							<div class="card-body pt-0">
								<form class="form-horizontal" name="create_form" action="{{url('admin/expert')}}" method="POST" enctype="multipart/form-data" id="create_form">
									@csrf
									<div class="form-group">
										<input type="text" class="form-control " id="name" placeholder="{{ __('general.service_name') }}" name="name">
										<ul class="parsley-errors-list filled" >
											<li class="parsley-required" id="name_error"></li>
										</ul>

									</div>

                                    <div class="form-group">
                                        <div class="my-4">
                                            <textarea class="form-control" placeholder="{{ __('general.descreption') }}" rows="3" id="desc" name="desc"></textarea>
                                        </div>									    <ul class="parsley-errors-list filled" >
											<li class="parsley-required" id="user_name_error"></li>
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
									<div class="form-group justify-content-end">
										<div class="checkbox">
											<div class="custom-checkbox custom-control">
												<input type="checkbox" data-checkboxes="mygroup" checked="" class="custom-control-input" id="checkbox-2" value="0" name="is_active">
												<label for="checkbox-2" class="custom-control-label mt-1"  >{{ __('general.is_active') }}</label>
											</div>

										</div>
										<ul class="parsley-errors-list filled" >
											<li class="parsley-required" id="is_active_error"></li>
										</ul>
									</div>
									<div class="form-group mb-0 mt-3 justify-content-end">
										<div>
											<button type="submit" name="btn_save" id="btn_save" class="btn btn-primary">{{ __('general.save') }}</button>
											<button type="button" name="btn_cancel" id="btn_cancel"  class="btn btn-secondary">{{ __('general.cancel') }}</button>
										</div>
									</div>
								</form>
								<div class="pd-20 clearfix">
									<img alt="" id="imgshow" class="rounded img-thumbnail wd-100p wd-sm-200 float-sm-right  mg-t-10 mg-sm-t-0"
									src="{{URL::asset('assets/img/photos/1.jpg')}}" >
								</div>
							</div>

                            <div class="col">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div>
                                            <h6 class="card-title">البيانات الشخصية</h6>
                                        </div>
                                        <form class="form-horizontal" >
                                            <div class="row">
                                                <div class="form-group mb-0 justify-content-end col-6 col-lg-3">
                                                    <div class="checkbox">
                                                        <div class="custom-checkbox custom-control">
                                                            <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-3">
                                                            <label for="checkbox-3" class="custom-control-label mt-1">الاسم</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-0 justify-content-end col-6 col-lg-3">
                                                    <div class="checkbox">
                                                        <div class="custom-checkbox custom-control">
                                                            <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-4">
                                                            <label for="checkbox-4" class="custom-control-label mt-1">الجنس</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-0 justify-content-end col-6 col-lg-3">
                                                    <div class="checkbox">
                                                        <div class="custom-checkbox custom-control">
                                                            <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-5">
                                                            <label for="checkbox-5" class="custom-control-label mt-1">تاريخ الميلاد</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-0 justify-content-end col-6 col-lg-3">
                                                    <div class="checkbox">
                                                        <div class="custom-checkbox custom-control">
                                                            <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-6">
                                                            <label for="checkbox-6" class="custom-control-label mt-1">الحالة الاجتماعية</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-0 mt-3 justify-content-end">
                                                <div>
                                                    <button type="submit" class="btn btn-primary">حفظ</button>
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
                                        <form class="form-horizontal" >
                                            <div class="row mb-4">
                                                <div class="form-group mb-0 justify-content-end col-6 col-lg-3">
                                                    <div class="checkbox">
                                                        <div class="custom-checkbox custom-control">
                                                            <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-7">
                                                            <label for="checkbox-7" class="custom-control-label mt-1">تسجيل صوتي</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-0 justify-content-end col-6 col-lg-3">
                                                    <div class="checkbox">
                                                        <div class="custom-checkbox custom-control">
                                                            <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-8">
                                                            <label for="checkbox-8" class="custom-control-label mt-1">صور</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <a class="btn ripple btn-light" data-target="#scrollmodal" data-toggle="modal" href=""><i class="fa fa-plus"></i> إضافة حقل</a>
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

        <!-- Basic modal -->
		<div class="modal" id="select2modal">
			<div class="modal-dialog" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">Select2 Modal</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<h6>Modal Body</h6>
						<!-- Select2 -->
						<select class="form-control select2-show-search select2-dropdown">
							<option label="Choose one">
							</option>
							<option value="Firefox">
							Firefox
							</option>
							<option value="Chrome">
							Chrome
							</option>
							<option value="Safari">
							Safari
							</option>
							<option value="Opera">
							Opera
							</option>
							<option value="Internet Explorer">
							Internet Explorer
							</option>
						</select>
						<!-- Select2 -->
						<p class="mt-3">Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
					</div>
					<div class="modal-footer">
						<button class="btn ripple btn-primary" type="button">Save changes</button>
						<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
					</div>
				</div>
			</div>
		</div>
		<!-- End Basic modal -->

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
                                        <form class="form-horizontal" name="create_form" method="POST" action="{{url('admin/user')}}" enctype="multipart/form-data" id="create_form">
                                            @csrf
                                            <div class="form-group">
                                                <input type="text" class="form-control " id="field_name" placeholder="{{ __('general.field_name') }}" name="field_name">
                                                <ul class="parsley-errors-list filled" >
                                                    <li class="parsley-required" id="field_name_error"></li>
                                                </ul>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="form-check col-6 mb-2">
                                                    <label class="form-check-label pl-2" for="exampleRadios1">
                                                        حقل نصي
                                                    </label>
                                                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                                                </div>
                                                <div class="form-check col-6 mb-2">
                                                    <label class="form-check-label pl-2" for="exampleRadios2">
                                                        قائمة نعم/لا
                                                    </label>
                                                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                                                </div>
                                                <div class="form-check col-6 mb-2">
                                                    <label class="form-check-label pl-2" for="exampleRadios2">
                                                        قائمة خيارات متعددة
                                                    </label>
                                                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                                                </div>
                                                <div class="form-check col-6 mb-2">
                                                    <label class="form-check-label pl-2" for="exampleRadios2">
                                                        حقل تاريخ
                                                    </label>
                                                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <select name="role"   id="role" class="form-control SlectBox" onclick="console.log($(this).val())" onchange="console.log('change is firing')">
                                                    <!--placeholder-->
                                                    <option title=""   class="text-muted">{{ __('general.choose yes/no') }}</option>
                                                    <option value="yes">{{ __('general.yes') }}</option>
                                                    <option value="no">{{ __('general.no') }}</option>
                                                </select>
                                                <ul class="parsley-errors-list filled">
                                                    <li class="parsley-required"  id="role_error"></li>
                                                </ul>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="name" placeholder="name" name="name">
                                                <ul class="parsley-errors-list filled" >
                                                    <li class="parsley-required" id="name_error"></li>
                                                </ul>
                                            </div>
                                            <div class="form-group mb-4 justify-content-end">
                                                <div>
                                                    <button type="submit" name="btn_add_field" id="btn_add_field" class="btn btn-light btn-block"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                            {{-- image --}}
                                            <div class="form-group mb-4 justify-content-end">
                                                <div class="custom-file">
                                                    <input class="custom-file-input" id="image" name="image" type="file"> <label class="custom-file-label" id="image_label" for="customFile">{{ __('general.choose image') }}</label>
                                                    <ul class="parsley-errors-list filled" >
                                                        <li class="parsley-required" id="image_error"></li>
                                                    </ul>
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
						<button class="btn ripple btn-primary" type="button">حفظ</button>
						<button class="btn ripple btn-secondary" data-dismiss="modal" type="button"> إلغاء</button>
					</div>
				</div>
			</div>
		</div>
		<!--End Scroll with content modal -->

        		<!-- Basic modal -->
		<div class="modal" id="modaldemo1">
			<div class="modal-dialog" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">Basic Modal</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<h6>Modal Body</h6>
						<p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
					</div>
					<div class="modal-footer">
						<button class="btn ripple btn-primary" type="button">Save changes</button>
						<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
					</div>
				</div>
			</div>
		</div>
		<!-- End Basic modal -->
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
<script src="{{URL::asset('assets/js/form-elements.js')}}"></script>
<script  >
var emptyimg ="{{URL::asset('assets/img/photos/1.jpg')}}"</script>

@endsection
