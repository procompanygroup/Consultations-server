@extends('admin.layouts.master')
@section('page-title')
{{ __('general.settings') }}
@endsection
@section('css')
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
                <h4 class="content-title mb-0 my-auto">الاعدادات</h4>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row opened -->
    <div class="row row-sm">


        <!--div-->
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">نسبة الخبير الافتراضية</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="">
                        <form class="form-horizontal" action="{{ url('admin/setting/updatepercent', $expert_percent->id) }}"
                            name="expert_percent_form"   method="POST" id="expert_percent_form">
                            @csrf
                            <div class="row">
                                <div class="form-group d-flex justify-content-between col-sm-12">
                                    <input type="text" class="form-control " id="expert_percent"
                                        placeholder="نسبة الخبير" name="expert_percent"
                                        value="{{ $expert_percent->value }}">
                                    <button type="submit" name="btn_expert_percent" id="btn_expert_percent"
                                        class="btn btn-primary mr-3">{{ __('general.save') }}</button>
                                </div>
                                <div class="col-sm-12">
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required" id="expert_percent_error"></li>
                                    </ul>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <!--/div-->


        </div>
        <!-- /div-->

        <!--div-->
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">النقاط الافتراضية</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="">
                        <form class="form-horizontal"
                            action="{{ url('admin/setting/updatepoints', $expert_service_points->id) }}"
                            name="expert_service_points_form"  method="POST" id="expert_service_points_form">
                            @csrf
                            <div class="row">
                            <div class="form-group d-flex justify-content-between col-sm-12">
                                <input type="text" class="form-control " id="expert_service_points"
                                    placeholder="نقاط الخدمة" name="expert_service_points"
                                    value="{{ $expert_service_points->value }}">
                              
                                <button type="submit" name="btn_expert_service_points" id="btn_expert_service_points"
                                    class="btn btn-primary mr-3">{{ __('general.save') }}</button>
                            </div>
                            <div class="col-sm-12">
                                <ul class="parsley-errors-list filled">
                                    <li class="parsley-required" id="expert_service_points_error"></li>
                                </ul>
                            </div>
                        </div>
                        </form>

                    </div>
                </div>
            </div>
            <!--/div-->


        </div>
        <!-- /div-->
    <!--div-->
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">عدد ايام صلاحية الهدية</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="">
                    <form class="form-horizontal"
                        action="{{ url('admin/setting/updatedays', $gift_expire_days->id) }}"
                        name="expire_days_form"  method="POST" id="expire_days_form">
                        @csrf
                        <div class="row">
                        <div class="form-group d-flex justify-content-between col-sm-12">
                            <input type="text" class="form-control " id="expire_days"
                                placeholder="يوم" name="expire_days"
                                value="{{ $gift_expire_days->value }}">
                          
                            <button type="submit" name="btn_expire_days" id="btn_expire_days"
                                class="btn btn-primary mr-3">{{ __('general.save') }}</button>
                        </div>
                        <div class="col-sm-12">
                            <ul class="parsley-errors-list filled">
                                <li class="parsley-required" id="expire_days_error"></li>
                            </ul>
                        </div>
                    </div>
                    </form>

                </div>
            </div>
        </div>
        <!--/div-->


    </div>
    <!-- /div-->
        <!--div-->
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">Stripe Secret key</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="">
                        <form class="form-horizontal" action="{{ url('admin/setting/updatesecretkey',$secret_key->id) }}"
                            name="secret_key_form"   method="POST" id="secret_key_form">
                            @csrf
                            <div class="row">
                                <div class="form-group d-flex justify-content-between col-sm-12">
                                    <input type="text" class="form-control " id="secret_key"
                                        placeholder="Stripe Secret key" name="secret_key"
                                        value="{{ $secret_key->value }}">
                                    <button type="submit" name="btn_secret_key" id="btn_secret_key"
                                        class="btn btn-primary mr-3">{{ __('general.save') }}</button>
                                </div>
                                <div class="col-sm-12">
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required" id="secret_key_error"></li>
                                    </ul>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <!--/div-->


        </div>
        <!-- /div-->
         <!--div-->
         <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">Publishable key</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="">
                        
                        <form class="form-horizontal" action="{{ url('admin/setting/updatepublishablekey', $publishable_key->id) }}"
                            name="publishable_key_form"  method="POST" id="publishable_key_form">
                            @csrf
                            <div class="row">
                                <div class="form-group d-flex justify-content-between col-sm-12">
                                    <input type="text" class="form-control " id="publishable_key"
                                        placeholder="Publishable key" name="publishable_key"
                                        value="{{ $publishable_key->value }}">
                                    <button type="submit" name="btn_publishable_key" id="btn_publishable_key"
                                        class="btn btn-primary mr-3">{{ __('general.save') }}</button>
                                </div>
                                <div class="col-sm-12">
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required" id="publishable_key_error"></li>
                                    </ul>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <!--/div-->


        </div>
        <!-- /div-->
    </div>
    <!-- row closed -->

    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
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
    <script src="{{ URL::asset('assets/js/admin/setting.js') }}"></script>
@endsection
