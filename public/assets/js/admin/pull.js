 
$(document).ready(function () {
//alert( countryurl);
		$('#sel_side').on('change', function () {
			var option = $(this).find(":selected").val();
		//	resetForm();
			ClearErrors();
			var choose="";
			if(option=="expert"){
				choose="اختر الخبير";
			}else if(option=="client"){
				choose="اختر العميل";
			}else{
				choose="اختر";
			}
			$('#sel_side_val').html('<option title="اختر" value="0"  class="text-muted">'+choose+'</option>');
if(option!="0"){	 
	var formData = 'sel_side='+option;
	urlval = blncesidurl;
		$.ajax({
		url: urlval,
		type: "GET",
	 	data: formData,
	//	contentType: false,
	//	processData: false,
		//contentType: 'application/json',
		success: function (data) {			 
			if (data.length == 0) {			 
			} else   {
				datalist=data;
				$(data).each(function(index, item) {
					$('#sel_side_val').append('<option value="'+ item.id +'" >'+ item.name +'</option>');
			});		 
			}		 
		}, error: function (errorresult) {		 
		 
		 
		} 
	 

	});
}	
		});

		
		$('#sel_side_val').on('change', function () {
			var option = $(this).find(":selected").val();
		//	resetForm();
			ClearErrors();
	//var blc=	datalist.name;
	var blc = datalist.filter(function(x){ return x.id == option }) ;
	var blcval=  blc[0].balance;
	$('#p_show_balance').show();
	$('#balance_val').html(blcval);
	
		});

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
					$('#p_show_balance').hide();
					$('#balance_val').html();
					if (data.length == 0) {
						noteError();
					} else if (data == "ok") {
	
						noteSuccess();	
						 
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
});

///////////////////////////////////////////////////////
 


