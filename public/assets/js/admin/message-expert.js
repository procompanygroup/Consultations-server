 
$(document).ready(function () {
 
	 
		$('#btn-send').on('click', function (e) {
			e.preventDefault();	 
			sendform('#send_form' );
			});
			//////////////////////
		function ClearErrors() {

			$('.parsley-required').html('');
			$(":input").removeClass('parsley-error');
			$("#mobile_num").removeClass('parsley-error');
		} 

		function sendform(formid ) {
			startLoading();
			//ClearErrors();
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
					resetForm();
					ClearErrors();
					 
					if (data.length == 0) {
						noteError();
					} else if (data.res == "ok") {	
						noteSuccess();	
						addAdminMsg(data);
						 
					}
	
					// $('.alert').html(result.success);
				}, error: function (errorresult) {
					endLoading();
					var response = $.parseJSON(errorresult.responseText);
					// $('#errormsg').html( errorresult );
					noteError();
					// $.each(response.errors, function (key, val) {
					// 	$("#" + key + "_error").text(val[0]);
					// 	$("#" + key).addClass('parsley-error');
					// 	//$('#error').append(key+"-"+ val[0] +"/");
					// });
	
				}, finally: function () {
					endLoading();	
				}
			});		 
		}

		function loadlast() {	
		 
			var formData = 'msg_id='+lastid()+'&expert_id='+expertId;
			$.ajax({
				url: expertlasturl,
				type: "GET",	
				data: formData,
				contentType: false,
				processData: false,
				//contentType: 'application/json',
				success: function (data) {				 
					if (data.length == 0) {
						//noteError();
					} else if (data.res == "ok") {	
						//noteSuccess();	
						addClientMsg(data);
						 
					}
	
					// $('.alert').html(result.success);
				}, error: function (errorresult) {
					//endLoading();
					var response = $.parseJSON(errorresult.responseText);
					// $('#errormsg').html( errorresult );
				//	noteError();
					// $.each(response.errors, function (key, val) {
					// 	$("#" + key + "_error").text(val[0]);
					// 	$("#" + key).addClass('parsley-error');
					// 	//$('#error').append(key+"-"+ val[0] +"/");
					// });
	
				}, finally: function () {
				//	endLoading();
	
				}
			 
	
			});
		 
		}
		function resetForm() {
			jQuery('#send_form')[0].reset();
		 
		}
		function noteSuccess() {
			notif({
				msg: "تم الارسال بنجاح",
				type: "success"
			});
		}
		function noteError() {
			notif({
				msg: "!لم يتم الارسال",
				position: "right",
				type: "error",
				bottom: '10'
			});
		}

		  function addAdminMsg (data) {
// .removeProp( "luggageCode" )
		//	var $divclon = $('#admin-msg').clone().removeProp( "id" ).show();
		var $divclon = $('#admin-msg').clone().prop('id', data.id).show();
		 
			$divclon.find('.text-muted').html(data.ctime+'<br>'+data.cdate);
			$divclon.find('.msg-content').html(data.content);
		 
			$('.chat-messages').append($divclon);
			 
		};
		function lastid (){
			var lastId = $('.chat-messages>.chat-message-left').last().attr('id');
			//alert(lastId);
			return lastId;
		//	var lastid = $(".chat-message-left:last").attr("id");
		} 
		function addClientMsg (data) {
			// .removeProp( "luggageCode" )
					//	var $divclon = $('#admin-msg').clone().removeProp( "id" ).show();
					$(data.messages).each(function(index, item) {
						var $divclon = $('#client-msg').clone().prop('id',item.id).show();					 
						$divclon.find('.text-muted').html(item.create_time+'<br>'+item.create_date);
						$divclon.find('.msg-title').html(item.title);
						$divclon.find('.msg-content').html(item.content);					 
						$('.chat-messages').append($divclon); 
				});							 
					};				
					 setInterval(loadlast,10000);
					//loadlast();
				});

///////////////////////////////////////////////////////
 


