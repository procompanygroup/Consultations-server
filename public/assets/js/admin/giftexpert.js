 
$(document).ready(function () {
 

		$('#btn_save_pull').on('click', function (e) {
			e.preventDefault();	 
			sendform('#save_pull_form' );
			});
			//////////////////////
		function ClearErrors() {

			$('.parsley-required').html('');
			$(":input").removeClass('parsley-error');
			$("#mobile_num").removeClass('parsley-error');
		} 

		function sendform(formid ) {
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
					resetForm();
					ClearErrors();
					 
					if (data.length == 0) {
						noteError();
					} else if (data == "ok") {
	
						noteSuccess();	
						loadclients() ;
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

		function resetForm() {
			jQuery('#save_pull_form')[0].reset();
		 
		}
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

		$("#amount").focusout(function (e) {
			if (!validatempty($(this))) {
				return false;
			} else {
	
				return true;
			}
		});
		$("#sel_side_val").focusout(function (e) {
		 
		$(this).removeClass('parsley-error');
		$("#sel_side_val"+ "_error").text('');
		});
});

///////////////////////////////////////////////////////
 


