@extends('admin.layouts.master')
@section('page-title')
    {{ __('general.clients') }}
@endsection
@section('css')
    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal  Datetimepicker-slider css -->
    <link href="{{ URL::asset('assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/pickerjs/picker.min.css') }}" rel="stylesheet">
    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">

    <link href="{{ URL::asset('assets/css/admin/content.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{ route('client.index') }}">{{ __('general.clients') }}</a>
                </h4>
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
                <div class="card-header mb-2 d-flex justify-content-between">
                    <h3 class="card-title mb-1">{{ __('general.client info') }}</h3>
                </div>
                <div class="card-body row  pt-0">
					<div class="col-lg-8">					
						<p><span class="badge badge-light badge-lg px-3 py-2">
                            <img alt="Icon SVG Vector Icon" fetchpriority="high" decoding="async" data-nimg="1"
                                style="width:20px;height:20px"
                                src="{{ asset('storage/images/inputs/icons/username.svg') }}">
                            {{ ' ' . __('general.name') }}
                        </span>{{ ' ' . $client->user_name }}
                    </p> 
					<p><span class="badge badge-light badge-lg px-3 py-2">
						<img alt="Icon SVG Vector Icon" fetchpriority="high" decoding="async" data-nimg="1"
							style="width:20px;height:20px"
							src="{{ asset('storage/images/inputs/icons/mobile-phone-icon.svg') }}">
						{{ ' ' . __('general.mobile') }}
					</span>{{ ' ' . $client->mobile }}
				</p>
				<p><span class="badge badge-light badge-lg px-3 py-2">
					<img alt="Icon SVG Vector Icon" fetchpriority="high" decoding="async" data-nimg="1"
						style="width:20px;height:20px"
						src="{{ asset('storage/images/inputs/icons/email.svg') }}">
					{{ ' ' . __('general.email') }}
				</span>{{ ' ' . $client->email }}
			</p>
			<p><span class="badge badge-light badge-lg px-3 py-2">
				<img alt="Icon SVG Vector Icon" fetchpriority="high" decoding="async" data-nimg="1"
					style="width:20px;height:20px"
					src="{{ asset('storage/images/inputs/icons/nationality.svg') }}">
				{{ ' ' . __('general.nationality') }}
			</span>{{ ' ' . $client->nationality }}
		</p>
		<p><span class="badge badge-light badge-lg px-3 py-2">
			<img alt="Icon SVG Vector Icon" fetchpriority="high" decoding="async" data-nimg="1"
				style="width:20px;height:20px"
				src="{{ asset('storage/images/inputs/icons/birthdate.svg') }}">
			{{ ' ' . __('general.birthdate') }}
		</span>{{ ' ' . $client->birthdateStr }}
	</p>
	<p><span class="badge badge-light badge-lg px-3 py-2">
		<img alt="Icon SVG Vector Icon" fetchpriority="high" decoding="async" data-nimg="1"
			style="width:20px;height:20px"
			src="{{ asset('storage/images/inputs/icons/gender.svg') }}">
		{{ ' ' . __('general.gender') }}
	</span>{{ ' ' . $client->gender_conv }}
</p>
<p><span class="badge badge-light badge-lg px-3 py-2">
	<img alt="Icon SVG Vector Icon" fetchpriority="high" decoding="async" data-nimg="1"
		style="width:20px;height:20px"
		src="{{ asset('storage/images/inputs/icons/martial.svg') }}">
	{{ ' ' . __('general.marital_status') }}
</span>{{ ' ' . $client->marital_status_conv }}
</p>

					</div>

					<div class="col-lg-4 mt-sm-3 mt-lg-0">
						<img alt="" id="imgshow"
							class="rounded img-thumbnail wd-100p float-sm-right  mg-t-10 mg-sm-t-0"
							src="@if ($client->image == '') {{ URL::asset('storage/images/default/default.png') }}@else {{ $client->image_path }} @endif">
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
@endsection
@section('js')
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal Select2.min js -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Ion.rangeSlider.min js -->
    <script src="{{ URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <!--Internal  jquery-simple-datetimepicker js -->
    <script src="{{ URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>
    <!-- Ionicons js -->
    <script src="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js') }}"></script>
    <!--Internal  pickerjs js -->
    <script src="{{ URL::asset('assets/plugins/pickerjs/picker.min.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

    <script src="{{ URL::asset('assets/js/admin/validate.js') }}"></script>
    <script src="{{ URL::asset('assets/js/admin/order.js') }}"></script>
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

    <!-- As A jQuery Plugin -->
    <script src="{{ URL::asset('assets/js/jquery-3.7.1.min.js') }}"></script>

    <script>
        var emptyimg = "{{ URL::asset('assets/img/photos/1.jpg') }}";
    </script>
@endsection
