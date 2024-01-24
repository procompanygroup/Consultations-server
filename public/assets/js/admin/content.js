var urlval="";
$(document).ready(function () {

	// $('#sortbody').html('');
	$('#btn_cancel').on('click', function (e) {
		//	var filename = $('#image').val().split('\\').pop();
		//alert(filename);

		jQuery('#create_form')[0].reset();
		$('#image_label').text("Choose File");
		$('#imgshow').attr("src", emptyimg);
		ClearErrors();
	});
	 
	//{{ route('user.index') }}
	$('#btn_save').on('click', function (e) {
		e.preventDefault()
		ClearErrors();
		//var fdata = $( "#create_form" ).serialize();
		var form = $('#create_form')[0];
		var formData = new FormData(form);

		//var urlval ='{{url("admin/user")}}';
		//const formData = new FormData("#create_form");
		//  alert(formData.toString());

		$.ajax({
			url: urlval,
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
			//contentType: 'application/json',
			success: function (data) {
				//	alert(data);



				//$('#errormsg').html('');
				//$('#sortbody').html('');
				if (data.length == 0) {
					noteError();
				} else if (data == "ok") {
					noteSuccess();
					jQuery('#create_form')[0].reset();
					ClearErrors();
				}

				// $('.alert').html(result.success);
			}, error: function (errorresult) {
				var response = $.parseJSON(errorresult.responseText);
				// $('#errormsg').html( errorresult );
				noteError();
				$.each(response.errors, function (key, val) {
					$("#" + key + "_error").text(val[0]);
					$("#" + key).addClass('parsley-error');
					//$('#error').append(key+"-"+ val[0] +"/");
				});

			}
			/*
			error: function(jqXHR, textStatus, errorThrown) {
			 alert(jqXHR.responseText);
			  // $('#errormsg').html(jqXHR.responseText);
			  //$('#errormsg').html("Error");
			  $('#error').text(jqXHR.responseText);
			}
			*/

		});



	});

	$('#btn_update_user').on('click', function (e) {
		e.preventDefault()
		ClearErrors();
		//var fdata = $( "#create_form" ).serialize();
		var form = $('#create_form')[0];
		var formData = new FormData(form);
		urlval=	$('#create_form').attr("action")
		//var urlval ='{{url("admin/user")}}';
		//const formData = new FormData("#create_form");
		//  alert(formData.toString());

		$.ajax({
			url: urlval,
			type: "POST",
			
			data: formData,
			contentType: false,
			processData: false,
			//contentType: 'application/json',
			success: function (data) {
				//	alert(data);



				//$('#errormsg').html('');
				//$('#sortbody').html('');
				if (data.length == 0) {
					noteError();
				} else if (data == "ok") {
					noteSuccess();
				//	jQuery('#create_form')[0].reset();
					ClearErrors();
				}

				// $('.alert').html(result.success);
			}, error: function (errorresult) {
				var response = $.parseJSON(errorresult.responseText);
				// $('#errormsg').html( errorresult );
				noteError();
				$.each(response.errors, function (key, val) {
					$("#" + key + "_error").text(val[0]);
					$("#" + key).addClass('parsley-error');
					//$('#error').append(key+"-"+ val[0] +"/");
				});

			}
			/*
			error: function(jqXHR, textStatus, errorThrown) {
			 alert(jqXHR.responseText);
			  // $('#errormsg').html(jqXHR.responseText);
			  //$('#errormsg').html("Error");
			  $('#error').text(jqXHR.responseText);
			}
			*/

		});



	});
	function ClearErrors() {

		$('.parsley-required').html('');
		$(":input").removeClass('parsley-error');
	}

	$("#image").on("change", function () {
		imageChangeForm("#image", "#image_label", "#imgshow");
	});

	function imageChangeForm(btn_id, upload_label, imageId) {
		/* Current this object refer to input element */
		var $input = $(btn_id);
		var reader = new FileReader();

		reader.onload = function () {
			$(imageId).attr("src", reader.result);
			//   var filename = $('#photo_edit')[0].files.length ? ('#photo_edit')[0].files[0].name : "";
			var filename = $(btn_id).val().split('\\').pop();
			$(upload_label).text(filename);
		}
		reader.readAsDataURL($input[0].files[0]);

	}

	$("#first_name").focusout(function (e) {
		if (!validatempty($(this))) {
			return false;
		} else {

			return true;
		}
	});
	$("#last_name").focusout(function (e) {
		if (!validatempty($(this))) {
			return false;
		} else {

			return true;
		}
	});
	$("#email").focusout(function (e) {
		if (!validatempty($(this))) {
			return false;
		}
		else if (!validateinputemail($(this), emailmsg)) {
			return false;

		} else {

			return true;
		}
	});
	$("#password").focusout(function (e) {
		if (!validatempty($(this))) {
			return false;
		} else {

			return true;
		}
	});
	$("#confirm_password").focusout(function (e) {
		if (!validatempty($(this))) {
			return false;
		} else {

			return true;
		}
	});
	$("#mobile").focusout(function (e) {
		/*
	if (!validatempty($(this))) {	 
		return false;
	} else {
	 
		return true;
	
	}
	*/
	});
	$("#name").focusout(function (e) {
		if (!validatempty($(this))) {
			return false;
		} else {

			return true;
		}
	});

	$("#role").focusout(function (e) {
		if (!validatempty($(this))) {
			return false;
		} else {

			return true;
		}
	});

});
function noteSuccess() {
	notif({
		msg: "تمت الاضافة بنجاح ",
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

