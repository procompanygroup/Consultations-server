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
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">Forms</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Form-Elements</span>
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
								<h4 class="card-title mb-1">Default Form</h4>
								<p class="mb-2">It is Very Easy to Customize and it uses in your website apllication.</p>
							</div>
							<div class="card-body pt-0">
								<form class="form-horizontal" >
									<div class="form-group">
										<input type="text" class="form-control" id="inputName" placeholder="الاسم الأول" name="f_name">
									</div>
                                    <div class="form-group">
										<input type="text" class="form-control" id="inputName" placeholder="الاسم الثاني/الكنية" name="l_name">
									</div>
									<div class="form-group">
										<input type="email" class="form-control" id="inputEmail3" placeholder="البريد الإلكتروني" name="email">
									</div>
                                    <div class="form-group">
										<input type="text" class="form-control" id="inputName" placeholder="اسم المستخدم" name="username">
									</div>
									<div class="form-group">
										<input type="password" class="form-control" id="inputPassword3" placeholder="كلمة السر" name="password">
									</div>
                                    <div class="form-group">
										<input type="text" class="form-control" id="inputName" placeholder="رقم الهاتف الجوال" name="mobile">
									</div>
                                    <div class="mb-4">
                                        <select name="gender" class="form-control SlectBox" onclick="console.log($(this).val())" onchange="console.log('change is firing')">
                                            <!--placeholder-->
                                            <option title="Choose Ther Role" class="text-muted">الجنس</option>
                                            <option value="admin">ذكر</option>
                                            <option value="supervisor">أنثى</option>
                                        </select>
                                    </div>
                                    <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text">
												<i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i> تاريخ الميلاد
											</div>
										</div><input class="form-control fc-datepicker" placeholder="MM/DD/YYYY" type="text">
									</div>
                                    <div class="my-4">
										<textarea class="form-control" placeholder="توصيف" rows="3" name="desc"></textarea>
									</div>
                                    <div class="form-group mb-4 justify-content-end">
										<div class="custom-file">
											<input class="custom-file-input" id="customFile" type="file"> <label class="custom-file-label" for="customFile">اختر ملف الصورة</label>
										</div>
									</div>
                                    <div class="form-group justify-content-end">
										<div class="checkbox">
											<div class="custom-checkbox custom-control">
												<input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-2" name="is_active">
												<label for="checkbox-2" class="custom-control-label mt-1">تفعيل</label>
											</div>
										</div>
									</div>
									<div class="form-group mb-0 mt-3 justify-content-end">
										<div>
											<button type="submit" class="btn btn-primary">حفظ</button>
											<button type="submit" class="btn btn-secondary">إلغاء</button>
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
@endsection
