var urlval = "";
 
 
$(document).ready(function () {
	$('#btn_agree_state').on('click', function (e) {
		e.preventDefault();	 
		sendform('#agree_form','form');
		});
	
		$('#btn_reject_state').on('click', function (e) {
			e.preventDefault();
			sendfromModal('#reject_form','#form_reject_reason','form');
			});
	 /////////

		$('#btn_agree_answer').on('click', function (e) {
			e.preventDefault();
			sendanswerform('#answer_agree_form');
			});
		 $('#btn_reject_answer').on('click', function (e) {
			e.preventDefault();
			sendrejectfromModal('#reject-answer-f');
			});
	 //////// commemt
	 $('#btn_agree_comment').on('click', function (e) {
		e.preventDefault();	 
		sendform('#agree_comment_form','comment');
		});
		// rate comment
		$('#btn_rate_comment').on('click', function (e) {
			e.preventDefault();
			sendfromModal('#rate_comment_form','#comment_rate','rate');
			});
	function ClearErrors() {

		$('.parsley-required').html('');
		$(":input").removeClass('parsley-error');
	}
  
	function sendform(formid,type) {
		startLoading();
	//	ClearErrors();
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
					if(type=='form'){
						afterOkForm();
					}	else if(type=='comment'){
						afterOkComment();
					}			
				
					
				//	ClearErrors();
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
	function afterOkComment() {
		$('#span_wait').hide();
		$('.agree-state').show();
		$('#btn_agree_comment').remove();
		$('.rate-btn').show();
	}
	function afterOkCommentRate(selectid) {	 		 				
		$('.rated-hide').remove();
		var option=$(selectid).find(":selected").text();
	 $('#p_rate_value').html(option);
	 $('.rated-h').show();	
	 $('#p_rate_value').show();		 
	}

	function afterOkForm() {
		$('#span_wait').hide();
		$('.agree-state').show();
		$('#div_btns').remove();
	}
	function afterOkFormReject(selectid) {	 
		$('#span_wait').hide();					
		$('#div_btns').remove();
		var option=$(selectid).find(":selected").text();
	 $('#span_reason').html(option);
	 $('.reject-state').show();	
	}
// #form_reject_reason'
//#comment_reject_reason
	function sendfromModal(formid,selectid,type) {
		//startLoading();
		ClearErrors();
	//	$formid='#create_form';		 
		var form = $(formid)[0];
		var formData = new FormData(form);
		urlval = $(formid).attr("action");
				$.ajax({
			url: urlval,
			type: "POST",

			data: formData,
			contentType: false,
			processData: false,
			//contentType: 'application/json',
			success: function (data) {
				//	alert(data);
				//endLoading();
				//$('#errormsg').html('');
				//$('#sortbody').html('');
				if (data.length == 0) {
					noteError();
				} else if (data == "ok") {
					noteSuccess();
if(type=='form'){
	afterOkFormReject(selectid);
}else if(type=='rate'){
	afterOkCommentRate(selectid);
}


					$("#btn_cancel_field").trigger("click");
					ClearErrors();
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
		 

		});


	 
	}

	function sendanswerform(formid) {
		startLoading();
	//	ClearErrors();
	//	$formid='#create_form';
		 
		var form = $(formid)[0];
		var formData = new FormData(form);
		urlval = $(formid).attr("action");
	 

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
					$('#span_wait').hide();
					$('#div_last_answer').remove();
					
					$('.agree-state').show();
					$('#div_btns').remove();
					getanswertable() ;
				//	ClearErrors();
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
	function sendrejectfromModal(formid) {
	 
		ClearErrors();
 
		 
		 var form = $(formid)[0];
		 
		 var formData = new FormData(form);
		urlval = $(formid).attr("action");
	 

		$.ajax({
			url: urlval,
			type: "POST",

			data: formData,
			contentType: false,
			processData: false,
		 
			success: function (data) {
				 
				if (data.length == 0) {
					noteError();
				} else if (data == "ok") {
					noteSuccess();					
					$('#span_wait').hide();					
					$('#div_btns').remove();
					$('#div_last_answer').remove();
					var option=$('#answer_reject_reason').find(":selected").text();
				 $('#span_reason').html(option);
				 $('.reject-state').show();	
				 getanswertable() ;
					$("#btn_cancel_field").trigger("click");
					ClearErrors();
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
				});	 
	}
	function getanswertable() {
	 
	 
		 
		 
var ans=	answerurlval;

		$.ajax({
			url: answerurlval,
			type: "GET",
 
			success: function (data) {
			 
				if (data.length == 0) {
				 
				} else   {
				$('#div_answer_table').html(data); 				  
				}

				 
			}, error: function (errorresult) {			 
				var response = $.parseJSON(errorresult.responseText);
			 
				noteError();
			 

			}, finally: function () {
				 

			}
		 

		});


	 
	}
	$('#form_state').on('change', function () {
		 
		var option = $(this).find(":selected").val();
		if (option == 'reject') { 
			$('#reason-div').show();	 
		} else if (option == 'agree') {		 
			$('#reason-div').hide();		 
		}  else{
			$('#reason-div').hide();
		}
	});
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
 

 
 
