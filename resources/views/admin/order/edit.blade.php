@extends('admin.layouts.master')
@section('page-title')
{{ __('general.orders') }}
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
                <h4 class="content-title mb-0 my-auto"><a href="{{ route('order.index') }}">{{ __('general.orders') }}</a>
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
                    <h3 class="card-title mb-1">{{ __('general.order details') }}</h3>
                @if ($selectedservice->form_state == 'wait')
                    <span class="text-warning" id="span_wait">{{ __('general.wait') }}</span>
                @elseif ($selectedservice->form_state == 'reject')
                    <span class="text-danger">{{ __('general.reject') }}</span>
                @else
                    <span class="text-success">{{ __('general.agree') }}</span>
                @endif
                <span class="text-success agree-state"   style="display: none">{{ __('general.agree') }}</span>
                <span class="text-danger reject-state" style="display: none">{{ __('general.reject') }}</span>
            </div>
                <div class="card-body pt-0">
                    <p><span class="badge badge-light badge-lg px-3 py-2"><img alt="Icon SVG Vector Icon"
                        fetchpriority="high" decoding="async" data-nimg="1" style="width:20px;height:20px"
                        src="{{ asset('storage/images/default/icons/sharp.svg') }}">
                    {{ ' ' . __('general.order num') }}</span>{{ ' ' . $selectedservice->order_num }}</p>
                    <p><span class="badge badge-light badge-lg px-3 py-2"><img alt="Icon SVG Vector Icon"
                                fetchpriority="high" decoding="async" data-nimg="1" style="width:20px;height:20px"
                                src="{{$selectedservice->service->svg_path }}">
                            {{ ' ' . __('general.service') }}</span>{{ ' ' . $selectedservice->service->name }}</p>
                    <p><span class="badge badge-light px-3 py-2"><img alt="User Icon SVG Vector Icon" fetchpriority="high"
                                decoding="async" data-nimg="1" style="width:20px;height:20px"
                                src="{{ asset('storage/images/inputs/icons/username.svg') }}">
                            {{ ' ' . __('general.expert') }}</span>{{ ' ' . $selectedservice->expert->full_name }}</p>

                            @foreach ($selectedservice->valueServices->whereNotIn('type', ['image', 'record']) as $valueService)
                        <p><span class="badge badge-light badge-lg px-3 py-2"><img fetchpriority="high" decoding="async"
                                    data-nimg="1" style="color:white;width:20px;height:20px"
                                    src="{{ $valueService->svg_path }}">
                                {{ ' ' . $valueService->tooltipe }}</span>{{ ' ' . $valueService->value_conv }}</p>
                    @endforeach
<div class="row">
                    <div class="gallery mb-3">
                        @foreach ($selectedservice->valueServices->where('type', 'image') as $valueService)
                        <a href="{{ $valueService->full_path_conv }}" style="margin: 5px" class="rounded img-thumbnail wd-100p wd-sm-200 float-sm-right  mg-t-10 mg-sm-t-0 big " rel="rel1">
                            <img src="{{ $valueService->full_path_conv }}" alt="" title="">
                        </a>
                        @endforeach
                    </div>
                </div>
                    @foreach ($selectedservice->valueServices->where('type', 'record') as $valueService)
                    <label class="col-sm-12 "><h3 class="card-title  col-sm-12 mb-1">تسجيل صوتي</h3></label>
                      <label class="col-sm-12 ">
                        <h3 class="card-title  col-sm-12 mb-1" style="color: #0162e8">
                            <a style=" cursor: pointer;" href="{{ $valueService->full_path_conv }}" download>{{ __('general.download') }}</a>
                            </h3></label>
                        <audio controls class="col-sm-12 ">
                            <source src="{{ $valueService->full_path_conv }}" type="audio/mpeg">
                        </audio>
                    @endforeach
                    @if ($selectedservice->form_state == 'wait')
                        <div class="form-horizontal"  id="div_btns">
                         
                            <div class="form-group mb-0 mt-3 justify-content-end">
                                <div>
                                   
                                    <button type="submit" name="btn_agree_state" id="btn_agree_state" form="agree_form"
                                        class="btn btn-primary">موافقة</button>
                                   
                                    <button type="button" name="btn_reject_state"  data-target="#scrollmodal" data-toggle="modal" 
                                        class="btn btn-danger">رفض</button>
                                </div>
                            </div>
                          
                        </div>
                    @else
                       
                        @if ($selectedservice->form_state == 'reject')
                            <label class="col-sm-12 " >سبب الرفض:<span  >{{ ' ' . $selectedservice->form_reject_reason }}</span></label>
                        @endif
                    @endif
                   
                    <label class="col-sm-12 reject-state" style="display: none" >سبب الرفض:<span id="span_reason"></span></label>
                    
                    {{--
								<div class="pd-20 clearfix">
									<img alt="" id="imgshow" class="rounded img-thumbnail wd-100p wd-sm-200 float-sm-right  mg-t-10 mg-sm-t-0"
                                    src="@if ($selectedservice->image == ''){{URL::asset('assets/img/photos/1.jpg')}}@else {{ $selectedservice->fullpathimg }} @endif" >
								</div>
                                 --}}
                                 <form  name="agree_form"  id="agree_form"
                                 action="{{ route('order.agree', $selectedservice->id) }}" method="POST">
                                 @csrf
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

    	<!-- Scroll with content modal -->
		<div class="modal" id="scrollmodal">
			<div class="modal-dialog modal-dialog-scrollable" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">سبب رفض الطلب</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
                        <!-- row -->
                        <div class="row row-sm">
                            <div class="col">
                                <div class="card  box-shadow-0">
                                    <div class="card-body pt-4">
                                        <form  name="reject_form" id="reject_form"
                                        action="{{ route('order.reject', $selectedservice->id) }}" method="POST" >
                                          @csrf                                           
                                            <div class="form-group mb-3">
                                                <select name="form_reject_reason" id="form_reject_reason" class="form-control">
                                                    <!--placeholder-->
                                                    <option title="" class="text-muted">اختر سبب الرفض</option>
                                                    @foreach ($reasons as $reason)
                                                        <option value="{{ $reason->id }}">{{ $reason->content }}</option>
                                                    @endforeach
                                                </select>
                                                <ul class="parsley-errors-list filled">
                                                    <li class="parsley-required" id="form_reject_reason_error"></li>
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
						<button class="btn ripple btn-primary" name="btn_reject_state" id="btn_reject_state" form="reject_form" type="submit">حفظ</button>
						<button class="btn ripple btn-secondary" data-dismiss="modal"  name="btn_cancel_field" id="btn_cancel_field" type="button"> إلغاء</button>
					</div>
				</div>
			</div>
		</div>
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

    <script src="{{ URL::asset('assets/js/admin/validate.js') }}"></script>
    <script src="{{ URL::asset('assets/js/admin/order.js') }}"></script>
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/simple-lightbox.js') }}"></script>
    <!-- For legacy browsers -->
    <script src="{{ URL::asset('assets/js/simple-lightbox.legacy.min.js') }}"></script>
    <!-- As A jQuery Plugin -->
    <script src="{{ URL::asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/simple-lightbox.jquery.min.js') }}"></script>
    <script>
        var emptyimg = "{{ URL::asset('assets/img/photos/1.jpg') }}";

        $('#expertdate').datepicker("option", "altFormat", "yy-mm-dd");
 
        var lightbox = $('.gallery a').simpleLightbox({
            // default source attribute
            sourceAttr: 'href',

            // shows fullscreen overlay
            overlay: true,

            // shows loading spinner
            spinner: true,

            // shows navigation arrows
            nav: true,

            // text for navigation arrows
            navText: ['&larr;','&rarr;'],

            // shows image captions
            captions: true,
            captionDelay: 0,
            captionSelector: 'img',
            captionType: 'attr',
            captionPosition: 'bottom',
            captionClass: '',
            captionHTML: false,

            // captions attribute (title or data-title)
            captionsData: 'title',

            // shows close button
            close: true,

            // text for close button
            closeText: 'X',

            // swipe up or down to close gallery
            swipeClose: true,

            // show counter
            showCounter: true,

            // file extensions
            fileExt: 'png|jpg|jpeg|gif',

            // weather to slide in new photos or not, disable to fade
            animationSlide: true,

            // animation speed in ms
            animationSpeed: 250,

            // image preloading
            preloading: true,

            // keyboard navigation
            enableKeyboard: true,

            // endless looping
            loop:  true,

            // group images by rel attribute of link with same selector
            rel: false,

            // closes the lightbox when clicking outside
            docClose:  true,

            // how much pixel you have to swipe
            swipeTolerance: 50,

            // lightbox wrapper Class
            className: 'simple-lightbox',

            // width / height ratios
            widthRatio: 0.8,
            heightRatio: 0.9,

            // scales the image up to the defined ratio size
            scaleImageToRatio: false,

            // disable right click
            disableRightClick: false,

            // disable page scroll
            disable<a href="https://www.jqueryscript.net/tags.php?/Scroll/">Scroll</a>: true,

            // show an alert if image was not found
            alertError:  true,

            // alert message
            alertErrorMessage: 'Image not found, next image will be loaded',

            // additional HTML showing inside every image
            additionalHtml: false,

            // enable history back closes lightbox instead of reloading the page
            history: true,

            // time to wait between slides
            throttleInterval: 0,

            // Pinch to <a href="https://www.jqueryscript.net/zoom/">Zoom</a> feature for touch devices
            doubleTapZoom: 2,
            maxZoom: 10,

            // adds class to html element if lightbox is open
            htmlClass: 'has-lightbox',

            // RTL mode
            rtl: false,

            // elements with this class are fixed and get the right padding when lightbox opens
            fixedClass: 'sl-fixed',

            // fade speed in ms
            fadeSpeed: 300,

            // whether to uniqualize images
            uniqueImages: true,

            // focus the lightbox on open to enable tab control
            focus: true,
        });
    </script>
@endsection
