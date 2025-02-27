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
                <h4 class="content-title mb-0 my-auto">الصفحات الثابتة</h4>
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
                        <h4 class="card-title mg-b-0">سياسة الخصوصية</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="">
                        <form class="form-horizontal"
                            action="{{ url('admin/setting/pages/update', $privacy->id) }}" name="privacy_form"
                            method="POST" id="privacy_form">
                            @csrf
                            <div class="row">
                                <div class="form-group d-flex justify-content-between col-sm-12">
                                    <textarea  class="form-control " id="privacy" rows="10"
                                    placeholder="سياسة الخصوصية" name="privacy">{{ $privacy->value }}</textarea>
                                   
                                      </div>
                                      <button type="submit" name="btn_privacy" id="btn_privacy"
                                      class="btn btn-primary mr-3 send-btn">{{ __('general.save') }}</button>
                           
                                <div class="col-sm-12">
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required" id="privacy_error"></li>
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
                        <h4 class="card-title mg-b-0">دليل المستخدم </h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="">
                        <form class="form-horizontal"
                            action="{{ url('admin/setting/pages/update', $user_guide->id) }}" name="user_guide_form"
                            method="POST" id="user_guide_form">
                            @csrf
                            <div class="row">
                                <div class="form-group d-flex justify-content-between col-sm-12">
                                    <textarea  class="form-control " id="user_guide" rows="10"
                                    placeholder="دليل المستخدم" name="user_guide">{{ $user_guide->value }}</textarea>    
                                </div>
                                <button type="submit" name="btn_user_guide" id="btn_user_guide"
                                class="btn btn-primary mr-3 send-btn">{{ __('general.save') }}</button>
                                <div class="col-sm-12">
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required" id="privacy_error"></li>
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
