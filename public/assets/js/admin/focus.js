var urlval = "";
var urlshowinput = "";
var urlshowexpert = "";
var delinputurl = "";


$(document).ready(function () {

	 
	$('#btn-modal-delrecord').on('click', function (e) {
		e.preventDefault();	 
		sendform('#del_record_form','form');
		$("#btn-cancel-modal").trigger("click");
		});

		$('#btn_del_record').on('click', function ( e) {
			//
			e.preventDefault();
	   
			   var effect = $(this).attr('data-effect');
			    $('#modaldemo8').addClass(effect);
			//
			   
	    
		   });

		   ////////////
	function sendform(formid) {
		startLoading();
 
		 
		var form = $(formid)[0];
		var formData = new FormData(form);
		urlval = $(formid).attr("action")
	 

		$.ajax({
			url: urlval,
			type: "POST",

			data: formData,
			contentType: false,
			processData: false,
		 
			success: function (data) {
			 
				endLoading();
			 
				if (data.length == 0) {
					noteError();
				} else if (data == "ok") {
					$('#div_record').remove();
					noteSuccess();	
					 
				}
 
			}, error: function (errorresult) {
				endLoading();
				var response = $.parseJSON(errorresult.responseText);
			 
				noteError();
			

			}, finally: function () {
				endLoading();

			}
		 

		});


	 
	}
 

	});
	 
///////////////////////////////////////////////////////

 
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



 