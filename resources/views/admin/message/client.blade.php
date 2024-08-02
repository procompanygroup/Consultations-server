@extends('admin.layouts.master')
@section('page-title')
    {{ __('general.clients') }}
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <style type="text/css">
        body {
            margin-top: 20px;
        }

        .chat-online {
            color: #34ce57
        }

        .chat-offline {
            color: #e4606d
        }

        .chat-messages {
            display: flex;
            flex-direction: column;
            max-height: 400px;
            overflow-y: scroll
        }

        .chat-message-left,
        .chat-message-right {
            display: flex;
            flex-shrink: 0
        }

        .chat-message-left {
            margin-left: auto
            /* margin-right: auto */
        }

        .chat-message-right {
            /* flex-direction: row-reverse; */
            margin-left: auto
        }

        .py-3 {
            padding-top: 1rem !important;
            padding-bottom: 1rem !important;
        }

        .px-4 {
            padding-right: 1.5rem !important;
            padding-left: 1.5rem !important;
        }

        .flex-grow-0 {
            flex-grow: 0 !important;
        }

        .border-top {
            border-top: 1px solid #dee2e6 !important;
        }
    </style>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">التواصل مع العملاء</h4>
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
                                        <div class="py-2 px-4 border-bottom d-none d-lg-block">
                                            <div class="d-flex align-items-center py-1">
                                                <div class="position-relative">
                                                    <img src="{{ $client->image_path }}"
                                                        class="rounded-circle mr-1" alt="Sharon Lessman" width="40"
                                                        height="40">
                                                </div>
                                                <div class="flex-grow-1 pl-3 mr-2">
                                                    <strong>{{ $client->user_name }}</strong>
                                                    <div class="text-muted small"><em></em></div>
                                                </div>
                                                <div>
                                                  
                                                        <a href="/admin/message/clients" class="btn btn-light border btn-lg px-3">عودة</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="position-relative">
                                            <div class="chat-messages p-4">
                                                @foreach ($client->messages as $message)
                                                @if($message->user_id)
                                                <div class="chat-message-left pb-4">
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
                                                <div class="chat-message-left pb-4">
                                                    <div>
                                                        <img src="{{ $client->image_path }}"
                                                            class="rounded-circle mr-1" alt="{{ $client->user_name }}"
                                                            width="40" height="40">
                                                        <div class="text-muted small text-nowrap mt-2 text-center">{{  $message->created_at->format('H:m') }}<br>{{  $message->created_at->format('d/m/Y')  }}</div>
                                   
                                                    </div>
                                                    <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                                        <div class="font-weight-bold mb-1">{{ $client->user_name }}</div><p>{{  $message->content }}</p></div>
                                                </div>
                                                @endif
                                               
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="flex-grow-0 py-3 px-4 border-top">
                                            <form  name="send_form" action="{{ url('admin/message/toclient',$client->id) }}" method="POST"   id="send_form">
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
            <div class="text-muted small text-nowrap mt-2 text-center">{{  $message->created_at->format('H:m') }}<br>{{  $message->created_at->format('d/m/Y')  }}</div>

        </div>
        <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
            <div class="font-weight-bold mb-1">{{ __('general.manage') }}</div><p class="msg-content"></p></div>
    </div>
@endsection
@section('css')
   
@endsection
@section('js')
    <!-- Internal Data tables -->
    
    <script src="{{URL::asset('assets/js/admin/message.js')}}"></script>
  
@endsection
