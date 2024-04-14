@extends('admin.layouts.master')
@section('page-title')
الاشعارات
@endsection
@section('css')
@endsection
@section('page-header')


				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">Pages</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Empty</span>
						</div>
					</div>
					 
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
<button class="btn  btn-primary" id="btn_sendToken"  >Save token</button>
<br/>
<div id="msg"></div>
<form action="{{ url('admin/sendNotification') }}" name="send-notify-form" id="send-notify-form" method="POST">
	@csrf
	<div class="form-group">
		<label>Message Title</label>
		<input type="text" class="form-control" name="title">
	</div>
	<div class="form-group">
		<label>Message Body</label>
		<textarea class="form-control" name="body"></textarea>
	</div>
	<button type="submit" id="btn-send-notify" name="btn-send-notify" class="btn btn-success btn-block">Send Notification</button>
</form>
 
		<div class="row row-sm">
			<div class="col">
				<div class="card  box-shadow-0">
					<div class="card-header">
						<h4 class="card-title mb-1">Send By Token</h4>
						<p class="mb-2 text-danger" id="msgtoken"></p>
					</div>
					<div class="card-body row pt-0">
						<div class="col-lg-8">
							<form action="{{ url('admin/sendbytoken')}}" name="send-withtoken-form" id="send-withtoken-form" method="POST">
								@csrf
								<div class="form-group">
									<label>Token</label>
								 
									 
										<textarea class="form-control"   rows="3" name="input_token"></textarea>
									 
								</div>
								<div class="form-group">
									<label>Message Title</label>
									<input type="text" class="form-control" name="title">
								</div>
								<div class="form-group">
									<label>Message Body</label>
									<textarea class="form-control" name="body"></textarea>
								</div>
								<button type="submit" id="btn-send-withtoken" name="btn-send-withtoken" class="btn btn-success btn-block">Send Notification</button>
							</form>
					</div> 

					</div>
				</div>
			</div>
		</div>


@endsection
@section('js')
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js"></script>
<script>
	$(document).ready(function () {
	$('#btn_sendToken').on('click', function () {
		sendToken();
	});
});
 // Import the functions you need from the SDKs you need
// import { initializeApp } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-app.js";
  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

	// Your web app's Firebase configuration
	const firebaseConfig = {
		apiKey: "AIzaSyAu00t4wAHnmdrPfFpbMhKvsaU96f-l-r4",
    authDomain: "rouh-app.firebaseapp.com",
    projectId: "rouh-app",
    storageBucket: "rouh-app.appspot.com",
    messagingSenderId: "1005936827413",
    appId: "1:1005936827413:web:ff97a7ec1b190354f3421c",
    measurementId: "G-DBQZ0Q3M8H"
  };
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();
 function sendToken(){
	messaging
            .requestPermission()
            .then(function() {
                return messaging.getToken()
 }) .then(function(value) {

	$.ajax({
                    url: '{{ url("admin/saveToken") }}',
                    type: 'POST',
					headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {token: value },
                   
                    success: function(res) {
                        alert(res);
                    },
                    error: function(error) {
 
                        alert(error);
                    },
                });
			}).catch(function(error) {
                alert(error);
            });
 }
 
    
 
</script>
<script src="{{URL::asset('assets/js/admin/validate.js')}}"></script>
<script src="{{URL::asset('assets/js/admin/notify.js')}}"></script>
 
@endsection