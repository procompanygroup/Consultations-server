var expid;
$(document).ready(function () {
 
		$('.btn-modal').on('click', function ( e) {
		 //
		 e.preventDefault();	
			var effect = $(this).attr('data-effect');
			$('#scrollmodal').addClass(effect);
		 //
		   expid= $(this).attr('id');
		 expid  =expid.replace("expert-","");
		 var url =urlgetstate;
		   url =url.replace("itemid",  expid );
		   loadstatus(url);
	 
		});
		$('#btn_update_state').on('click', function ( e) { 
	
			var url= urlupdatestate;
			var url = url.replace("itemid", expid);
			  $('#expert_form').attr("action",url); 
				$('#expert_form').submit();
	
	 });
	 
	 function loadstatus(urlval) {
		 
		//	resetForm();
			ClearErrors();
		$.ajax({
		url: urlval,
		type: "GET",
	 //	data: formData,
	//	contentType: false,
	//	processData: false,
		//contentType: 'application/json',
		success: function (data) {			 
			if (data.length == 0) {			 
			} else   {		 
					$('#status option[value="'+data.status+'"]').attr("selected", "selected");		 	 
			}		 
		}, error: function (errorresult) {			 
		} 
	});
 
		};
		function ClearErrors() {

			$('.parsley-required').html('');
			$(":input").removeClass('parsley-error');
			 
		}

	});


 