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
                            name="expert_percent_form" method="POST" id="expert_percent_form">
                            @csrf
                            <div class="row">
                                <div class="form-group d-flex justify-content-between col-sm-12">
                                    <input type="text" class="form-control " id="expert_percent"
                                        placeholder="نسبة الخبير" name="expert_percent"
                                        value="{{ $expert_percent->value }}">
                                    <button type="submit" name="btn_expert_percent" id="btn_expert_percent"
                                        class="btn btn-primary mr-3 send-btn">{{ __('general.save') }}</button>
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
                            name="expert_service_points_form" method="POST" id="expert_service_points_form">
                            @csrf
                            <div class="row">
                                <div class="form-group d-flex justify-content-between col-sm-12">
                                    <input type="text" class="form-control " id="expert_service_points"
                                        placeholder="نقاط الخدمة" name="expert_service_points"
                                        value="{{ $expert_service_points->value }}">

                                    <button type="submit" name="btn_expert_service_points" id="btn_expert_service_points"
                                        class="btn btn-primary mr-3 send-btn">{{ __('general.save') }}</button>
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
                        <h4 class="card-title mg-b-0">كلفة دقيقة الاتصال </h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="">
                        <form class="form-horizontal" action="{{ url('admin/setting/updatecallcost', $call_cost->id) }}"
                            name="call_cost_form" method="POST" id="call_cost_form">
                            @csrf
                            <div class="row">
                                <div class="form-group d-flex justify-content-between col-sm-12">
                                    <input type="text" class="form-control " id="call_cost" placeholder="الكلفة * "
                                        name="call_cost" value="{{ $call_cost->value }}">

                                    <button type="submit" name="btn_call_cost" id="btn_call_cost"
                                        class="btn btn-primary mr-3 send-btn">{{ __('general.save') }}</button>
                                </div>
                                <div class="col-sm-12">
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required" id="call_cost_error"></li>
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
                            action="{{ url('admin/setting/updatedays', $gift_expire_days->id) }}" name="expire_days_form"
                            method="POST" id="expire_days_form">
                            @csrf
                            <div class="row">
                                <div class="form-group d-flex justify-content-between col-sm-12">
                                    <input type="text" class="form-control " id="expire_days" placeholder="يوم"
                                        name="expire_days" value="{{ $gift_expire_days->value }}">

                                    <button type="submit" name="btn_expire_days" id="btn_expire_days"
                                        class="btn btn-primary mr-3 send-btn">{{ __('general.save') }}</button>
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
                            <h4 class="card-title mg-b-0">عدد ايام صلاحية هدية الدقائق</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <form class="form-horizontal"
                                action="{{ url('admin/setting/updatedaysminute', $gift_minute_expire_days->id) }}" name="expire_days_minute_form"
                                method="POST" id="expire_days_minute_form">
                                @csrf
                                <div class="row">
                                    <div class="form-group d-flex justify-content-between col-sm-12">
                                        <input type="text" class="form-control " id="expire_days_minute" placeholder="يوم"
                                            name="expire_days_minute" value="{{ $gift_minute_expire_days->value }}">
    
                                        <button type="submit" name="btn_expire_days_minute" id="btn_expire_days_minute"
                                            class="btn btn-primary mr-3 send-btn">{{ __('general.save') }}</button>
                                    </div>
                                    <div class="col-sm-12">
                                        <ul class="parsley-errors-list filled">
                                            <li class="parsley-required" id="expire_days_minute_error"></li>
                                        </ul>
                                    </div>
                                </div>
                            </form>
    
                        </div>
                    </div>
                </div>
                <!--/div-->
    
    
            </div>
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
                        <form class="form-horizontal"
                            action="{{ url('admin/setting/updatesecretkey', $secret_key->id) }}" name="secret_key_form"
                            method="POST" id="secret_key_form">
                            @csrf
                            <div class="row">
                                <div class="form-group d-flex justify-content-between col-sm-12">
                                    <input type="text" class="form-control " id="secret_key"
                                        placeholder="Stripe Secret key" name="secret_key"
                                        value="{{ $secret_key->value }}">
                                    <button type="submit" name="btn_secret_key" id="btn_secret_key"
                                        class="btn btn-primary mr-3 send-btn">{{ __('general.save') }}</button>
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
       
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">Publishable key</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="">

                        <form class="form-horizontal"
                            action="{{ url('admin/setting/updatepublishablekey', $publishable_key->id) }}"
                            name="publishable_key_form" method="POST" id="publishable_key_form">
                            @csrf
                            <div class="row">
                                <div class="form-group d-flex justify-content-between col-sm-12">
                                    <input type="text" class="form-control " id="publishable_key"
                                        placeholder="Publishable key" name="publishable_key"
                                        value="{{ $publishable_key->value }}">
                                    <button type="submit" name="btn_publishable_key" id="btn_publishable_key"
                                        class="btn btn-primary mr-3 send-btn">{{ __('general.save') }}</button>
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
        {{-- رابط التطبيق --}}
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <form class="form-horizontal" action="{{ url('admin/setting/updateapplink') }}" name="applink_form"
                    method="POST" id="applink_form">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">رابط التطبيق على Google Play</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="">

                            @csrf
                            <div class="row">
                                <div class="form-group d-flex justify-content-between col-sm-11">
                                    <input type="text" class="form-control " id="gplay_link"
                                        placeholder="Google Play " name="gplay_link" value="{{ $gplay_link->value }}">

                                </div>
                                <div class="col-sm-11">
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required" id="gplay_link_error"></li>
                                    </ul>
                                </div>
                            </div>


                        </div>
                    </div>


                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">رابط التطبيق على App Store</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="">


                            <div class="row">
                                <div class="form-group d-flex justify-content-between col-sm-11">
                                    <input type="text" class="form-control " id="appstor_link"
                                        placeholder="App Store" name="appstor_link" value="{{ $appstor_link->value }}">

                                </div>
                                <div class="col-sm-12">
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required" id="appstor_link_error"></li>
                                    </ul>
                                    <button type="submit" name="btn_app_link" id="btn_app_link"
                                        class="btn btn-primary mr-3 send-btn">{{ __('general.save') }}</button>
                                </div>
                            </div>
                </form>

            </div>
        </div>


     

    </div>
    <!--/div-->



    {{-- رابط السوشيال --}}
   
    </div>
    <!-- /div-->
    </div>
    <div class="col-xl-12" style="padding-right:0px;padding-left:0px; ">
        <div class="card mg-b-20">
            <form class="form-horizontal" action="{{ url('admin/setting/updatesociallink') }}" name="social_form"
                method="POST" id="social_form">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">رابط حساب X</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="">

                        @csrf
                        <div class="row">
                            <div class="form-group d-flex justify-content-between col-sm-11">
                                <input type="text" class="form-control " id="x_link" placeholder="رابط حساب X"
                                    name="x_link" value="{{ $x_link->value }}">

                            </div>
                            <div class="col-sm-11">
                                <ul class="parsley-errors-list filled">
                                    <li class="parsley-required" id="x_link_error"></li>
                                </ul>
                            </div>
                        </div>


                    </div>
                </div>


                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">رابط حساب Facebook</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="">


                        <div class="row">
                            <div class="form-group d-flex justify-content-between col-sm-11">
                                <input type="text" class="form-control " id="facebook_link"
                                    placeholder="رابط حساب Facebook" name="facebook_link"
                                    value="{{ $facebook_link->value }}">

                            </div>
                            <div class="col-sm-12">
                                <ul class="parsley-errors-list filled">
                                    <li class="parsley-required" id="facebook_link_error"></li>
                                </ul>
                                <button type="submit" name="btn_app_link" id="btn_social_link"
                                    class="btn btn-primary mr-3 send-btn">{{ __('general.save') }}</button>
                            </div>
                        </div>
            </form>

        </div>

    </div>
    <!-- row closed -->
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0"> ايميل الادارة</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="">

                    <form class="form-horizontal"
                        action="{{ url('admin/setting/update_admin_email', $admin_email->id) }}"
                        name="admin_email_form" method="POST" id="admin_emailform">
                        @csrf
                        <div class="row">
                            <div class="form-group d-flex justify-content-between col-sm-12">
                                <input type="text" class="form-control " id="admin_email"
                                    placeholder=" ايميل الادارة" name="admin_email"
                                    value="{{ $admin_email->value }}">
                                <button type="submit" name="btn_admin_email" id="btn_admin_email"
                                    class="btn btn-primary mr-3 send-btn">{{ __('general.save') }}</button>
                            </div>
                            <div class="col-sm-12">
                                <ul class="parsley-errors-list filled">
                                    <li class="parsley-required" id="admin_email_error"></li>
                                </ul>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <!--/div-->


    </div>
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
