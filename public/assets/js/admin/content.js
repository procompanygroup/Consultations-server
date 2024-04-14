var urlval = "";
var urlshowinput = "";
var urlshowexpert = "";
var delinputurl = "";
var urlshowpercent = "";
var  urlpointmodal="";
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
		urlval = $('#create_form').attr("action");
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

			}, finally: function () {
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
		urlval = $('#create_form').attr("action")
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

			}, finally: function () {
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
		urlval = $('#personal_form').attr("action")
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
			}, finally: function () {
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
		urlval = $('#imgrecord_form').attr("action")
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
			}, finally: function () {
				endLoading();

			}


		});



	});
	//save field
	$('#btn_save_field').on('click', function (e) {
		e.preventDefault();
		startLoading();
		ClearErrors();
		//var fdata = $( "#create_form" ).serialize();
		var form = $('#field_form')[0];
		var formData = new FormData(form);
		urlval = $('#field_form').attr("action")
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
					resetfieldForm();
					loadinputsview();
					$("#btn_cancel_field").trigger("click");
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



	});



	$('#btn_showinput').on('click', function () {
		//e.preventDefault();
		resetfieldForm();
		//$("#cars").prop('selectedIndex', 2);
		$(".dynamicdiv").remove();
		//	$('#list_option').hide();
		//	$('#list_option').hide();
		$('#option_append').hide();
		$('#divoptionhide').hide();
		$('#btn_add_option').hide();
		clearInputError($('#field_name'));
		clearInputError($('#field_tooltipe'));
		clearInputError($('#field_icon'));
		clearInputError($('#field_type'));
	});

	$('#btn_show_expertmodal').on('click', function () {
		//e.preventDefault();
		resetexpertForm();

		clearInputError($('#select_expert'));

	});


	/*	
	//delete input .deleteinput
	$('.deleteinput').on('click',function (e) {
		e.preventDefault();	 
		//	startLoading();
		 //ClearErrors();
			//var fdata = $( "#create_form" ).serialize();
			
			//var formData = 21;
			
			//var urlval ='{{url("admin/user")}}';
			//const formData = new FormData("#create_form");
			//  alert(formData.toString());
			var thisId = $(this).prop("id");
			var fullurl=delinputurl.replace("[itemid]",thisId);
			$.ajax({
				url: fullurl,
				type: "POST",
				
			//	data: formData,
			//	contentType: false,
				//processData: false,
				//contentType: 'application/json',
				success: function (data) {
					//	alert(data);
					//endLoading();
					//$('#errormsg').html('');
					//$('#sortbody').html('');
					if (data.length == 0) {
						noteError();
					} else  {
					//$('#div_extrainputs').html(data);
						
					}
	
					// $('.alert').html(result.success);
				}, error: function (errorresult) {
					//endLoading();
					var response = $.parseJSON(errorresult.responseText);
					// $('#errormsg').html( errorresult );
				
	 
				},finally:function () {
					//endLoading();
	
				}
			});
	
	
	
		});
	*/
	function ClearErrors() {

		$('.parsley-required').html('');
		$(":input").removeClass('parsley-error');
		$("#mobile_num").removeClass('parsley-error');
		$("#deptype").removeClass('parsley-error');
		$("#side").removeClass('parsley-error');
	}
	function showimgcount(imgcheck, imgcount) {
		if (imgcheck.is(':checked')) {

			imgcount.show();
		} else {
			imgcount.hide();
		}
	}

	function clearTypeinputs() {
		$('#bool_field').hide();
		$('#list_option').hide();
		$('#btn_add_option').hide();

	}
	$("#image_check").on("change", function () {
		showimgcount($("#image_check"), $('#image_count'));

	});
	$("#image").on("change", function () {
		imageChangeForm("#image", "#image_label", "#imgshow");
	});
	$("#icon").on("change", function () {
		imageChangeForm("#icon", "#icon_label", "#iconshow");
	});
	$("#field_icon").on("change", function () {
		imageChangeForm("#field_icon", "#field_icon_label", "#field_iconshow");
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
	title
	$("#title").focusout(function (e) {
		if (!validatempty($(this))) {
			return false;
		} else {

			return true;
		}
	});
	$("#side").focusout(function (e) {
	 
	$(this).removeClass('parsley-error');
	$("#side"+ "_error").text('');
	});
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

	$('#field_type').on('change', function () {
		var option = $(this).find(":selected").val();
		if (option == 'list') {
			//$('#list_option').show();
			$('#btn_add_option').show();
			//$('#bool_field').hide();
			$('#option_append').show();
		} else {
			$('#btn_add_option').hide();
			$('#option_append').hide();
		}

	});

	$('#field_type_edit').on('change', function () {
		var option = $(this).find(":selected").val();
		if (option == 'text') {

			//	$('#list_option').hide();
			$('#btn_edit_option').hide();

			$('#option_append_edit').hide();
		} else if (option == 'bool') {
			//$('#bool_field').show();
			//$('#list_option').hide();
			$('#btn_edit_option').hide();
			$('#option_append_edit').hide();
		} else if (option == 'list') {
			//$('#list_option').show();
			$('#btn_edit_option').show();
			//$('#bool_field').hide();
			$('#option_append_edit').show();
		} else if (option == 'date') {
			//	$('#bool_field').hide();
			//	$('#list_option').hide();
			$('#btn_edit_option').hide();
			$('#option_append_edit').hide();
		} else if (option == 'longtext') {
			//	$('#bool_field').hide();
			//	$('#list_option').hide();
			$('#btn_edit_option').hide();
			$('#option_append_edit').hide();
		} else {
			//	$('#bool_field').hide();
			//	$('#list_option').hide();
			$('#btn_edit_option').hide();
			$('#option_append_edit').hide();
		}

	});

	$("#expert_percent").focusout(function (e) {
		if (!validatempty($(this))) {
			return false;
		} else {

			return true;
		}
	});
	$("#content").focusout(function (e) {
		if (!validatempty($(this))) {
			return false;
		} else {

			return true;
		}
	});
	$("#type").focusout(function (e) {
		if (!validatempty($(this))) {
			return false;
		} else {

			return true;
		}
	});
	//add input text dynamicly
	var i = 1;
	$('#btn_add_option').on('click', function () {

		var $divclon = $('#divoptionhide').clone().prop('id', 'divoption_' + i).addClass('dynamicdiv').show();

		$divclon.children(':input').first().prop('id', 'list_option_' + i)
			.prop('name', 'list_option' + '[' + i + ']')
			.prop('value', '');
		//$('#divoption').after( $divclon);
		$('#option_append').append($divclon);
		i++;
	});

	//save expert service



	showimgcount($("#image_check"), $('#image_count'));
	clearTypeinputs();

	// loadinputsview();
	//show percent modal
	$('.edit-service-percent').on('click', function (e) {
		e.preventDefault();
		ClearErrors();
		
		var thisId = $(this).attr("id");
		thisId = thisId.replace("edit-", "");
		var urlval = urlshowpercent.replace("itemid", thisId);
		//var formData = 21;
		//var thisform =$(this).closest('form');
		//var urlval ='{{url("admin/user")}}';
		//var thisform = $(this).parents('form:first');
		//var formData = new FormData(thisform);
		//	var	urlval = thisform.attr("action");

		$.ajax({
			url: urlval,
			type: "GET",

			//	data: formData,
			//	contentType: false,
			//processData: false,
			//contentType: 'application/json',
			success: function (data) {

				//$('#errormsg').html('');
				//$('#sortbody').html('');
				if (data.length == 0) {
					//	noteError();
				} else {
					$('#scrollmodal-edit').html(data);

				}

				// $('.alert').html(result.success);
			}, error: function (errorresult) {
				//endLoading();
				var response = $.parseJSON(errorresult.responseText);
				// $('#errormsg').html( errorresult );


			}, finally: function () {
				//endLoading();

			}
		});
	});

	//save percent
	$('#btn_save_percent').on('click', function (e) {
		e.preventDefault();
		//alert("hi");
		//	startLoading();
		ClearErrors();
		//var fdata = $( "#create_form" ).serialize();

		var form = $('#expert_percent_form')[0];
		var formData = new FormData(form);
		urlval = $('#expert_percent_form').attr("action")
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
				//	endLoading();
				//$('#errormsg').html('');
				//$('#sortbody').html('');
				if (data.length == 0) {
					noteError();
				} else if (data == "ok") {
					noteSuccess();

					ClearErrors();
					//$("#btn_cancel_field").trigger("click");
					//loadexperts();
					$("#btn_cancel_field").trigger("click");
				}

				// $('.alert').html(result.success);
			}, error: function (errorresult) {
				//endLoading();
				var response = $.parseJSON(errorresult.responseText);
				// $('#errormsg').html( errorresult );
				noteError();
				$.each(response.errors, function (key, val) {
					$("#" + key + "_error").text(val[0]);
					$("#" + key).addClass('parsley-error');
					//$('#error').append(key+"-"+ val[0] +"/");
				});

			}, finally: function () {
				//	endLoading();

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

//show point modal
$('.btn-edit-point').on('click', function (e) {
	e.preventDefault();
	ClearErrors();
	
	var thisId = $(this).attr("id");
	thisId = thisId.replace("expert-service-", "");
	var url =urlpointmodal.replace("itemid", thisId);
	//var formData = 21;
	//var thisform =$(this).closest('form');
	//var urlval ='{{url("admin/user")}}';
	//var thisform = $(this).parents('form:first');
	//var formData = new FormData(thisform);
	//	var	urlval = thisform.attr("action");

	$.ajax({
		url: url,
		type: "GET",

		//	data: formData,
		//	contentType: false,
		//processData: false,
		//contentType: 'application/json',
		success: function (data) {

			//$('#errormsg').html('');
			//$('#sortbody').html('');
			if (data.length == 0) {
				//	noteError();
			} else {
				$('#scrollmodal-edit-point').html(data);

			}

			// $('.alert').html(result.success);
		}, error: function (errorresult) {
			//endLoading();
			var response = $.parseJSON(errorresult.responseText);
			// $('#errormsg').html( errorresult );


		}, finally: function () {
			//endLoading();

		}
	});
});



function sendformbyid(formid) {
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

			} else   {
				noteSuccess();
				 
				  $('#msg').html(data);
			}

			// $('.alert').html(result.success);
		}, error: function (errorresult) {
			endLoading();
			var response = $.parseJSON(errorresult.responseText);
			// $('#errormsg').html( errorresult );
			noteError(); 

		}, finally: function () {
			endLoading();

		}
	 

	});


 
}
 
$("input[name=is_active]").click(function() {
	//  var checkBoxes = $(this).val();
	var checkBoxes = $(this).prop("checked");
if(checkBoxes==true){
 //$("#lbl_is_active").text("مفعل");
$("input[name=is_active]").prop("value",1);
}else{
//$("#lbl_is_active").text("غير مفعل");
$("input[name=is_active]").prop("value",0);
}
	//  alert( $("#status").prop("value"));
   //   checkBoxes.prop("checked", !checkBoxes.prop("checked"));
  }); 
  

});

///////////////////////////////////////////////////////

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
//input
$("#field_name").focusout(function (e) {
	if (!validatempty($(this))) {
		return false;
	} else {

		return true;
	}
});
$("#field_tooltipe").focusout(function (e) {
	if (!validatempty($(this))) {
		return false;
	} else {

		return true;
	}
});
$("#field_type").focusout(function (e) {
	if (!validatempty($(this))) {
		return false;
	} else {

		return true;
	}
});
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
function resetForm() {
	jQuery('#create_form')[0].reset();
	$('#image_label').text("اختر ملف الصورة");
	$('#icon_label').text('اختر ملف SVG');
	$('#imgshow').attr("src", emptyimg);
	$('#iconshow').attr("src", emptyimg);
}
function resetfieldForm() {
	jQuery('#field_form')[0].reset();

	$('#field_icon_label').text('اختر ملف SVG');
	/*
	$('#imgshow').attr("src", emptyimg);
	$('#iconshow').attr("src", emptyimg);
	*/
}
function resetexpertForm() {
	jQuery('#expert_form')[0].reset();
	/*
	$('#imgshow').attr("src", emptyimg);
	$('#iconshow').attr("src", emptyimg);
	*/
}
 
function loadinputsview() {


	//var formData = 21;

	//var urlval ='{{url("admin/user")}}';


	$.ajax({
		url: urlshowinput,
		type: "GET",

		//	data: formData,
		//	contentType: false,
		//processData: false,
		//contentType: 'application/json',
		success: function (data) {

			//$('#errormsg').html('');
			//$('#sortbody').html('');
			if (data.length == 0) {
				//	noteError();
			} else {
				$('#div_extrainputs').html(data);

			}

			// $('.alert').html(result.success);
		}, error: function (errorresult) {
			//endLoading();
			var response = $.parseJSON(errorresult.responseText);
			// $('#errormsg').html( errorresult );


		}, finally: function () {
			//endLoading();

		}
	});
}

function loadexperts() {


	//var formData = 21;

	//var urlval ='{{url("admin/user")}}';


	$.ajax({
		url: urlshowexpert,
		type: "GET",

		//	data: formData,
		//	contentType: false,
		//processData: false,
		//contentType: 'application/json',
		success: function (data) {

			//$('#errormsg').html('');
			//$('#sortbody').html('');
			if (data.length == 0) {
				//	noteError();
			} else {

				$('#div_selectedexpert').html(data);

			}

			// $('.alert').html(result.success);
		}, error: function (errorresult) {
			//endLoading();
			var response = $.parseJSON(errorresult.responseText);
			// $('#errormsg').html( errorresult );


		}, finally: function () {
			//endLoading();

		}
	});
}


