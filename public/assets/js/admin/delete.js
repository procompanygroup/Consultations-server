var delId ="";
$(document).ready(function () {
 
		$('.delete').on('click', function ( e) {
		 //
		 e.preventDefault();
	
			var effect = $(this).attr('data-effect');
			$('#modaldemo8').addClass(effect);
		 //
			delId = $(this).attr("id");
	
		//	alert(delId);
		});
		$('#btn-modal-del').on('click', function ( e) { 
	
		$('#'+delId).closest('form').submit();
			 $("#btn-cancel-modal").trigger("click");
	
	 });
	 
	 
	});


 