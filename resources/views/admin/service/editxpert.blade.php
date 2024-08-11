@extends('admin.layouts.master')
@section('page-title')
{{ __('general.services') }}
@endsection
@section('css')
    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/admin/content.css') }}" rel="stylesheet">

    <!---Internal Owl Carousel css-->
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
    <!---Internal  Multislider css-->
    <link href="{{ URL::asset('assets/plugins/multislider/multislider.css') }}" rel="stylesheet">

    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a
                        href="{{ route('service.index') }}">{{ __('general.services') }}</a></h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('general.show Service Expert') }}</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">

        <!--div-->
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between mb-3">
                        <h6 class="card-title">قائمة خبراء خدمة {{ $service->name }}</h6>
                        <a class="btn ripple btn-light" data-target="#scrollmodal" data-toggle="modal"
                            id="btn_show_expertmodal"><i class="fa fa-plus"></i> إضافة خبير</a>
                    </div>
                </div>
                <div class="card-body" id="div_selectedexpert">

                    <div class="table-responsive">
                        <table id="example" class="table text-md-nowrap">
                            <thead>
                                <tr>

                                    <th class="border-bottom-0">اسم الخبير</th>
@if ($service->is_callservice==1)
<th class="border-bottom-0">الكلفة</th>
@else
<th class="border-bottom-0">النقاط</th>
@endif
                                    

                                    <th class="border-bottom-0">{{ __('general.action') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @if ($service->is_callservice==1)
                                @foreach ($selectedexperts as $selectedexpert)
                                <tr>

                                    <td>{{ $selectedexpert->expert->first_name . ' ' . $selectedexpert->expert->last_name }}
                                    </td>
                                    <td>{{ $call_cost }}</td>

                                    <td><form action="{{ url('admin/service/expert/deleteselected', $selectedexpert->id) }}" method="POST" class="d-inline" id="delete_expert_form">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm btn-delete-expert"
                                            id="expert-{{ $selectedexpert->expert->id }}"><i
                                                class="fa fa-trash"></i></button>
                                        </form>

                                    </td>

                                </tr>
                            @endforeach
                                @else
                                @foreach ($selectedexperts as $selectedexpert)
                                    <tr>

                                        <td>{{ $selectedexpert->expert->first_name . ' ' . $selectedexpert->expert->last_name }}
                                        </td>
                                        <td>{{ $selectedexpert->points }}</td>

                                        <td>
                                            <button   class="btn btn-success btn-sm btn-edit-point" id="expert-service-{{ $selectedexpert->id }}"
                                                data-target="#scrollmodal-edit-point" data-toggle="modal"
                                                title="{{ __('general.edit') }}"><i class="fa fa-edit"></i></button>

                                            <form action="{{ url('admin/service/expert/deleteselected', $selectedexpert->id) }}" method="POST" class="d-inline" id="delete_expert_form">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm btn-delete-expert"
                                                id="expert-{{ $selectedexpert->expert->id }}"><i
                                                    class="fa fa-trash"></i></button>
                                            </form>

                                        </td>

                                    </tr>
                                @endforeach
                                @endif
                             
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <!--/div-->

    </div>
    <!-- row -->

    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->


    <div class="modal" id="scrollmodal-edit-point">
			
    </div>


    <!-- Scroll with content modal -->
    <div class="modal" id="scrollmodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">إضافة خبير</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <!-- row -->
                    <div class="row row-sm">
                        <div class="col">
                            <div class="card  box-shadow-0">
                                <div class="card-body pt-4">
                                    <form class="form-horizontal" name="expert_form"
                                        action="{{ url('admin/service/expert/save', $service->id) }}" method="POST"
                                        id="expert_form">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <select name="select_expert" id="select_expert"
                                                class="form-control SlectBox">
                                                <!--placeholder-->
                                                <option title="" selected class="text-muted">الخبير</option>
                                                @foreach ($allexperts as $expert)
                                                    <option value="{{ $expert->id }}">
                                                        {{ $expert->first_name . ' ' . $expert->last_name }}</option>
                                                @endforeach
                                            </select>
                                            <ul class="parsley-errors-list filled">
                                                <li class="parsley-required" id="select_expert_error"></li>
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
                    <button class="btn ripple btn-primary" type="submit" form="expert_form" name="btn_save_expert"
                        id="btn_save_expert" type="button">حفظ</button>
                    <button class="btn ripple btn-secondary" data-dismiss="modal" name="btn_cancel_field"
                        id="btn_cancel_field" type="button"> إلغاء</button>
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
    <!-- Internal Modal js-->
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>
    <!--Internal  pickerjs js -->
    <script src="{{ URL::asset('assets/plugins/pickerjs/picker.min.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

    <script src="{{ URL::asset('assets/js/admin/validate.js') }}"></script>
    <script src="{{ URL::asset('assets/js/admin/content.js') }}"></script>
    <script src="{{ URL::asset('assets/js/admin/expert.js') }}"></script>
   
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
    <!--Internal  Datatable js -->

    <script>
        var emptyimg = "{{ URL::asset('assets/img/photos/1.jpg') }}"
     
        urlshowexpert = "{{ url('admin/service/expert/showselected', $service->id) }}";
        urlpointmodal="{{ url('admin/service/point/edit', 'itemid') }}";
    </script>

    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <script src="{{ URL::asset('assets/js/admin/validate.js') }}"></script>

@endsection
