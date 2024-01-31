var urlval="";
 
$(document).ready(function () {

	// $('#sortbody').html('');
	$('#btn_cancel').on('click', function (e) {
		//	var filename = $('#image').val().split('\\').pop();
		//alert(filename);

		resetForm();
		ClearErrors();
	});
	 
	//{{ route('user.index') }}
	$('#btn_save').on('click', function (e) {
		e.preventDefault();
		startLoading();
		ClearErrors();
		//var fdata = $( "#create_form" ).serialize();
		var form = $('#create_form')[0];
		var formData = new FormData(form);
		urlval=	$('#create_form').attr("action");
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
				endLoading();

				//$('#errormsg').html('');
				//$('#sortbody').html('');
				if (data.length == 0) {
					noteError();
				} else if (data == "ok") {
					noteSuccess();
					resetForm();
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

			},finally:function () {
				endLoading();

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
		e.preventDefault();
		startLoading();
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

			},finally:function () {
				endLoading();

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

	//save personal
	$('#btn_save_personal').on('click', function (e) {
		e.preventDefault();
		startLoading();
	//	ClearErrors();
		//var fdata = $( "#create_form" ).serialize();
		var form = $('#personal_form')[0];
		var formData = new FormData(form);
		urlval=	$('#personal_form').attr("action")
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
				endLoading();
				//$('#errormsg').html('');
				//$('#sortbody').html('');
				if (data.length == 0) {
					noteError();
				} else if (data == "ok") {
					noteSuccess();
			 
					//ClearErrors();
				}

				// $('.alert').html(result.success);
			}, error: function (errorresult) {
				endLoading();
				var response = $.parseJSON(errorresult.responseText);
				// $('#errormsg').html( errorresult );
				noteError();
				/*
				$.each(response.errors, function (key, val) {
					$("#" + key + "_error").text(val[0]);
					$("#" + key).addClass('parsley-error');
					//$('#error').append(key+"-"+ val[0] +"/");
				});
*/
			},finally:function () {
				endLoading();

			}
			 

		});



	});
		//save image record
		$('#btn_save_imgrecord').on('click', function (e) {
			e.preventDefault();
			startLoading();
		//	ClearErrors();
			//var fdata = $( "#create_form" ).serialize();
			var form = $('#imgrecord_form')[0];
			var formData = new FormData(form);
			urlval=	$('#imgrecord_form').attr("action")
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
					endLoading();
					//$('#errormsg').html('');
					//$('#sortbody').html('');
					if (data.length == 0) {
						noteError();
					} else if (data == "ok") {
						noteSuccess();
				 
						//ClearErrors();
					}
	
					// $('.alert').html(result.success);
				}, error: function (errorresult) {
					endLoading();
					var response = $.parseJSON(errorresult.responseText);
					// $('#errormsg').html( errorresult );
					noteError();
					/*
					$.each(response.errors, function (key, val) {
						$("#" + key + "_error").text(val[0]);
						$("#" + key).addClass('parsley-error');
						//$('#error').append(key+"-"+ val[0] +"/");
					});
	*/
				},finally:function () {
					endLoading();
	
				}
				 
	
			});
	
	
	
		});
		
	function ClearErrors() {

		$('.parsley-required').html('');
		$(":input").removeClass('parsley-error');
	}

	$("#image_check").on("change", function () {
	 if($('#image_check').is(':checked')){
		
		$('#image_count').show();
	 }else{
		$('#image_count').hide();
	 }
	});
	$("#image").on("change", function () {
		imageChangeForm("#image", "#image_label", "#imgshow");
	});
	$("#icon").on("change", function () {
		imageChangeForm("#icon", "#icon_label", "#iconshow");
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
	$(".mobile").focusout(function (e) {
	 
	if (!validatempty($(this))) {	 
		return false;
	} else {
	 
		return true;
	
	}
	
	});
	$("#name").focusout(function (e) {
		if (!validatempty($(this))) {
			return false;
		} else {

			return true;
		}
	});
	$("#user_name").focusout(function (e) {
		if (!validatempty($(this))) {
			return false;
		} else {

			return true;
		}
	});
	$("#gender").focusout(function (e) {
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
	$("#expertdate").focusout(function (e) {
		if (!required($(this).val())) {
			$("#birthdate").addClass("parsley-error");//emptyMsg
		$("#birthdate_error").html(requiredmsg);
		  
			return false; 
	 
		} else {
			$("#birthdate").removeClass("parsley-error");
			$("#birthdate_error").html("");
			return true;
		}
	});
	$("#ui-datepicker-div").focusout(function (e) {
		if (!required($('#expertdate').val())) {
			$("#birthdate").addClass("parsley-error");//emptyMsg
		$("#birthdate_error").html(requiredmsg);
		  
			return false; 
	 
		} else {
			$("#birthdate").removeClass("parsley-error");
			$("#birthdate_error").html("");
			return true;
		}
	});
	
});
$("#count").focusout(function (e) {
	if (!validatempty($(this))) {
		return false;
	} else {

		return true;
	}
});
$("#price").focusout(function (e) {
	if (!validatempty($(this))) {
		return false;
	} else {

		return true;
	}
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
function resetForm() {
	jQuery('#create_form')[0].reset();
	$('#image_label').text("اختر ملف الصورة");
	$('#icon_label').text('اختر ملف SVG');
	$('#imgshow').attr("src", emptyimg);
	$('#iconshow').attr("src", emptyimg);
}

