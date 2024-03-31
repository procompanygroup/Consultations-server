var urlallpercent="";
//$(document).ready(function() {
	  jQuery(function($){
//save percent
$('#btn_save_percent').on('click', function (e) {
  e.preventDefault();	 
  ClearErrors();	
  var form = $('#expert_percent_form')[0];
  var formData = new FormData(form);
  urlval = $('#expert_percent_form').attr("action");
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
		var url =urlallpercent;
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
			  }	});});});
		  ///////////
			  function ClearErrors() {    
		  $('.parsley-required').html('');
		  $(":input").removeClass('parsley-error');
	  }   
	 