var selectedid ="";
$(document).ready(function () {
 
		$('.rate_btn').on('click', function ( e) {
		 //
		 e.preventDefault();
	
			var effect = $(this).attr('data-effect');
			$('#modaldemo8').addClass(effect);
		 //
		 selectedid = $(this).attr("id");
	
		// alert( itemid);
		});
		$('#btn_agree_state').on('click', function (e) { 
	var url= urlagree;
	var url = url.replace("itemid", selectedid);
	  $('#agree_form').attr("action",url); 
		$('#agree_form').submit();
			 $("#btn-cancel-modal").trigger("click");
	
	 });
	 $('#btn_reject_state').on('click', function (e) { 
		var url= urlreject;
		var url = url.replace("itemid", selectedid);
		  $('#reject_form').attr("action",url); 
			$('#reject_form').submit();
				 $("#btn-cancel-modal").trigger("click");
		
		 });
	 
	});


 