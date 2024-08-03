@extends('admin.layouts.master')
@section('page-title')
    {{ __('general.experts') }}
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/admin/chat.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">التواصل مع الخبراء</h4>
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
               
                <div class="card-body">

                    <main class="content">
                        <div class="container p-0">
                            <h1 class="h3 mb-3"></h1>
                            <div class="card">
                                <div class="row g-0">
                                     
                                    <div class="col-12 col-lg-12 col-xl-12">
                                        <div class="py-2 px-4 border-bottom   d-lg-block">
                                            <div class="d-flex align-items-center py-1">
                                                <div class="position-relative">
                                                    <img src="{{ $expert->image_path }}"
                                                        class="rounded-circle mr-1" alt="" width="40"
                                                        height="40">
                                                </div>
                                                <div class="flex-grow-1 pl-3 mr-2">
                                                    <strong>{{ $expert->full_name }}</strong>
                                                    <div class="text-muted small"><em></em></div>
                                                </div>
                                                <div>
                                                  
                                                        <a href="/admin/message/experts" class="btn btn-light border btn-lg px-3">عودة</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="position-relative">
                                            <div class="chat-messages p-4">
                                                @foreach ($expert->messages as $message)
                                                @if($message->user_id)
                                                <div class="chat-message-left pb-4" id="{{$message->id}}">
                                                    <div>
                                                        <img src="{{ $manage_img}}"
                                                            class="rounded-circle mr-1" alt="{{ __('general.manage') }}"
                                                            width="40" height="40">
                                                        <div class="text-muted small text-nowrap mt-2 text-center">{{  $message->created_at->format('H:m') }}<br>{{  $message->created_at->format('d/m/Y')  }}</div>
                                   
                                                    </div>
                                                    <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                                        <div class="font-weight-bold mb-1">{{ __('general.manage') }}</div><p>{{  $message->content }}</p></div>
                                                </div>
                                                @else
                                                <div class="chat-message-left pb-4" id="{{$message->id}}" >
                                                    <div>
                                                        <img src="{{ $expert->image_path }}"
                                                            class="rounded-circle mr-1" alt="{{ $expert->full_name }}"
                                                            width="40" height="40">
                                                        <div class="text-muted small text-nowrap mt-2 text-center">{{  $message->created_at->format('H:m') }}<br>{{  $message->created_at->format('d/m/Y')  }}</div>
                                   
                                                    </div>
                                                    <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                                        <div class="font-weight-bold mb-1">{{ $expert->full_name }}</div><p>{{  $message->content }}</p></div>
                                                </div>
                                                @endif
                                               
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="flex-grow-0 py-3 px-4 border-top">
                                            <form  name="send_form" action="{{ url('admin/message/toexpert',$expert->id) }}" method="POST"   id="send_form">
                                                @csrf
                                            <div class="input-group">
                                                <input type="text" name="message" class="form-control"  
                                                    placeholder="اكتب الرسالة هنا">
                                                <button type="submit" id="btn-send" class="btn btn-primary"  >إرسال</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>


                </div>
            </div>
        </div>
        <!--/div-->


    </div>
    <!-- /row -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
     
    <div class="chat-message-left pb-4" style="display: none" id="admin-msg">
        <div>
            <img src="{{ $manage_img}}"
                class="rounded-circle mr-1" alt="{{ __('general.manage') }}"
                width="40" height="40">
            <div class="text-muted small text-nowrap mt-2 text-center"></div>

        </div>
        <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
            <div class="font-weight-bold mb-1">{{ __('general.manage') }}</div><p class="msg-content"></p></div>
    </div>
    {{-- from client --}}
    <div class="chat-message-left pb-4" style="display: none" id="client-msg" >
        <div>
            <img src="{{ $expert->image_path }}"
                class="rounded-circle mr-1" alt="{{ $expert->full_name }}"
                width="40" height="40">
            <div class="text-muted small text-nowrap mt-2 text-center"></div>
        </div>
        <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
            <div class="font-weight-bold mb-1">{{ $expert->full_name }}</div><p class="msg-content"></p></div>
    </div>
@endsection
@section('css')
   
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script>
        var expertId={{ $expert->id }};
        var expertlasturl="{{url('admin/message/expertlast') }}";
    </script>
    <script src="{{URL::asset('assets/js/admin/message-expert.js')}}"></script>
  
@endsection
