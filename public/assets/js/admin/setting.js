var urlval = "";
var urlshowinput = "";
var urlshowexpert = "";
var delinputurl = "";


$(document).ready(function () {

	// $('#sortbody').html('');
	 
	//save personal
 
	//save image record
	 



	$('#btn_expert_percent').on('click', function (e) {
		e.preventDefault();
		sendform('#expert_percent_form');
		});
	 
		$('#btn_expert_service_points').on('click', function (e) {
			e.preventDefault();
			sendform('#expert_service_points_form');
			});
/////////////////////
	$('#btn_secret_key').on('click', function (e) {
				e.preventDefault();
				sendform('#secret_key_form');
				});
	$('#btn_publishable_key').on('click', function (e) {
					e.preventDefault();
					sendform('#publishable_key_form');
					});

					///
	$('#btn_expire_days').on('click', function (e) {
		e.preventDefault();
		sendform('#expire_days_form');
		});		 

	function ClearErrors() {

		$('.parsley-required').html('');
		$(":input").removeClass('parsley-error');
	}
  
	function sendform(formid) {
		startLoading();
		ClearErrors();
	//	$formid='#create_form';
		 
		var form = $(formid)[0];
		var formData = new FormData(form);
		urlval = $(formid).attr("action")
	 

		$.ajax({
			url: urlval,
			type: "POST",

			data: formData,
			contentType: false,
			processData: false,
			//contentType: 'application/json',
			success: function (data) {
				//	alert(data);
				endLoading();
				//$('#errormsg').html('');
				//$('#sortbody').html('');
				if (data.length == 0) {
					noteError();
				} else if (data == "ok") {
					noteSuccess();

					ClearErrors();
				}

				// $('.alert').html(result.success);
			}, error: function (errorresult) {
				endLoading();
				var response = $.parseJSON(errorresult.responseText);
				// $('#errormsg').html( errorresult );
				noteError();
				$.each(response.errors, function (key, val) {
					$("#" + key + "_error").text(val[0]);
					$("#" + key).addClass('parsley-error');
					//$('#error').append(key+"-"+ val[0] +"/");
				});

			}, finally: function () {
				endLoading();

			}
		 

		});


	 
	}
 
	});
	 
	 

 


 

///////////////////////////////////////////////////////

 
 
function noteSuccess() {
	notif({
		msg: "تمت العملية بنجاح",
		type: "success"
	});
}
function noteError() {
	notif({
		msg: "لم تنجح العملية !",
		position: "right",
		type: "error",
		bottom: '10'
	});
}
 
 
function resetexpertForm() {
	jQuery('#expert_form')[0].reset();


	/*
	$('#imgshow').attr("src", emptyimg);
	$('#iconshow').attr("src", emptyimg);
	*/
}
 

 
 
