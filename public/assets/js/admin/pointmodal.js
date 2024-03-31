var urlallpercent="";
//$(document).ready(function() {
	  jQuery(function($){
//save percent
$('#btn_save_point_form').on('click', function (e) {
  e.preventDefault();	 
 
  ClearErrors();	
  var form = $('#point_form')[0];
  var formData = new FormData(form);
  urlval = $('#point_form').attr("action");
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
		  //	ClearErrors();
			  //$("#btn_cancel_field").trigger("click");
			  //loadexperts();
	 
	//	var url = "{{ url('admin/service/percent/show')}}";
	//	var url =urlpointmodal;
		var url= window.location.href;
		$(location).attr('href',url);      
		  } 
	  }, error: function (errorresult) {			 
		  var response = $.parseJSON(errorresult.responseText);			 
		  noteError();
		  $.each(response.errors, function (key, val) {
			  $("#" + key + "_error").text(val[0]);
			  $("#" + key).addClass('parsley-error');				 
		  });
	  }, finally: function () {
			  }	});});
			
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


			});
		  ///////////
			  function ClearErrors() {    
		  $('.parsley-required').html('');
		  $(":input").removeClass('parsley-error');
	  }  
	 
 