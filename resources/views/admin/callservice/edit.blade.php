@extends('admin.layouts.master')
@section('page-title')
الاتصال المباشر
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
    <link href="{{ URL::asset('assets/css/simple-lightbox.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a
                        href="{{ url('admin/call') }}">الاتصال المباشر</a>
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
                    <h3 class="card-title mb-1">{{ __('general.detail') }}</h3>
                    
                        <span ></span>
                </div>
                <div class="card-body pt-0">
                    <p><span class="badge badge-light badge-lg px-3 py-2"><img alt="Icon SVG Vector Icon"
                        fetchpriority="high" decoding="async" data-nimg="1" style="width:20px;height:20px"
                        src="{{$sharpicon}}">
                    {{ ' ' . __('general.order num') }}</span>{{ ' ' . $selectedservice->order_num }}</p>
                    <p><span class="badge badge-light badge-lg px-3 py-2"><img alt="User Icon SVG Vector Icon"
                                fetchpriority="high" decoding="async" data-nimg="1" style="width:20px;height:20px"
                                src="{{ $selectedservice->service->svg_path }}">
                            {{ ' ' . __('general.service') }}</span>{{ ' ' . $selectedservice->service->name }}</p>
                    <p><span class="badge badge-light px-3 py-2"><img alt="User Icon SVG Vector Icon" fetchpriority="high"
                                decoding="async" data-nimg="1" style="width:20px;height:20px"
                                src="{{$usericon}}">
                            {{ ' ' . __('general.expert') }}</span>{{ ' ' . $selectedservice->expert->full_name }}</p>
                    <p><span class="badge badge-light px-3 py-2"><img alt="User Icon SVG Vector Icon" fetchpriority="high"
                                decoding="async" data-nimg="1" style="width:20px;height:20px"
                                src="{{$usericon}}">
                            {{ ' ' . __('general.client') }}</span>{{ ' ' . $selectedservice->client->user_name }}
                    </p>
@if ($selectedservice->call_file)
<div id="div_last_answer">
    <h3 class="card-title mb-1 border-top pt-3">المكالمة</h3>
    <label class="col-sm-12 ">
        <h3 class="card-title  col-sm-12 mb-1" style="color: #0162e8">
            <a style=" cursor: pointer;"
                href="{{ $selectedservice->file_path  }}"
                download>{{ __('general.download') }}</a>
        </h3>
    </label>
    <audio controls class="col-sm-12 ">
        <source
            src="{{  $selectedservice->file_path }}"
            type="audio/mpeg">
    </audio>
</div> 

@endif
       
                  
                
             



                    {{--
								<div class="pd-20 clearfix">
									<img alt="" id="imgshow" class="rounded img-thumbnail wd-100p wd-sm-200 float-sm-right  mg-t-10 mg-sm-t-0"
                                    src="@if ($selectedservice->image == ''){{URL::asset('assets/img/photos/1.jpg')}}@else {{ $selectedservice->fullpathimg }} @endif" >
								</div>
                                 --}}
                  

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
    
    <!--End Scroll with content modal -->
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
 
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/simple-lightbox.js') }}"></script>
    <!-- For legacy browsers -->
    <script src="{{ URL::asset('assets/js/simple-lightbox.legacy.min.js') }}"></script>
    <!-- As A jQuery Plugin -->
    <script src="{{ URL::asset('assets/js/jquery-3.7.1.min.js') }}"></script>
     
    <script>
        var emptyimg = "{{ URL::asset('assets/img/photos/1.jpg') }}";

        $('#expertdate').datepicker("option", "altFormat", "yy-mm-dd");

       
    </script>
@endsection
