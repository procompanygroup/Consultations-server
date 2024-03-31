var urlval = "";
var urlshowinput = "";
var urlshowexpert = "";
var delinputurl = "";


$(document).ready(function () {

	// $('#sortbody').html('');
	 
	//save personal
 
	//save image record
	 
 



	 

	$('#btn_show_expertmodal').on('click', function () {
		//e.preventDefault();
		resetexpertForm();
		
		clearInputError($('#select_expert'));
	
	});


	 
	function ClearErrors() {

		$('.parsley-required').html('');
		$(":input").removeClass('parsley-error');
	}
  
	//save expert service
	$('#btn_save_expert').on('click', function (e) {
		e.preventDefault();
	//	startLoading();
		ClearErrors();
		//var fdata = $( "#create_form" ).serialize();
		
		var form = $('#expert_form')[0];
		var formData = new FormData(form);
		urlval = $('#expert_form').attr("action")
		//var urlval ='{{url("admin/user")}}';
		//const formData = new FormData("#create_form");
		 

		$.ajax({
			url: urlval,
			type: "POST",

			data: formData,
			contentType: false,
			processData: false,
			//contentType: 'application/json',
			success: function (data) {
			 
			//	endLoading();
				//$('#errormsg').html('');
				//$('#sortbody').html('');
				if (data.length == 0) {
					noteError();
				} else if (data == "ok") {
					noteSuccess();

					ClearErrors();
					$("#btn_cancel_field").trigger("click");
					//$("#btn_cancel_field").trigger("click");
					//loadexperts();
					var url= window.location.href;
					$(location).attr('href',url); 
			
				}

			 
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
			 
			  // $('#errormsg').html(jqXHR.responseText);
			  //$('#errormsg').html("Error");
			  $('#error').text(jqXHR.responseText);
			}
			*/

		});



	});

	//delete expert service
	/*
	$('.btn-delete-expert').on('click', function (e) {
		e.preventDefault();
		var thisform = $(this).parents('form:first');
		startLoading();
		//ClearErrors();
		//var fdata = $( "#create_form" ).serialize();
		
		var form = thisform[0];
		var formData = new FormData(form);
		urlval = thisform.attr("action")
		//var urlval ='{{url("admin/user")}}';
		//const formData = new FormData("#create_form");
	 

		$.ajax({
			url: urlval,
			type: "POST",

			data: formData,
			contentType: false,
			processData: false,
			//contentType: 'application/json',
			success: function (data) {
			 
				endLoading();
				//$('#errormsg').html('');
				//$('#sortbody').html('');
				if (data.length == 0) {
					noteError();
				} else if (data == "ok") {
					noteSuccess();
					//ClearErrors();					
					loadexpertsafterDel();
				}

			 
			}, error: function (errorresult) {
				endLoading();
				var response = $.parseJSON(errorresult.responseText);
				// $('#errormsg').html( errorresult );
				noteError();
				

			}, finally: function () {
				endLoading();

			}
			/*
			error: function(jqXHR, textStatus, errorThrown) {
			  
			  // $('#errormsg').html(jqXHR.responseText);
			  //$('#errormsg').html("Error");
			  $('#error').text(jqXHR.responseText);
			}
		 

		});
*/

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
 

function loadexperts() {

 
 
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

		}, error: function (errorresult) {
			//endLoading();
			var response = $.parseJSON(errorresult.responseText);
			// $('#errormsg').html( errorresult );


		}, finally: function () {
			//endLoading();

		}
	});
}

function loadexpertsafterDel() {


		//var formData = 21;
	
		//var urlval ='{{url("admin/user")}}';
		$('#div_selectedexpert').load(urlshowexpert);
	/*
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
	
				
			}, error: function (errorresult) {
				//endLoading();
				var response = $.parseJSON(errorresult.responseText);
				// $('#errormsg').html( errorresult );
	
	
			}, finally: function () {
				//endLoading();
	
			}
		});
		*/
	}
