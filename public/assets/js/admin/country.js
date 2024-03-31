 
$(document).ready(function () {
//alert( countryurl);
 
	
fillCountry();
 
 
	function fillCountry() {
		$.getJSON(countryurl, function(data){
			//	console.log(data.countries);  
			$("#country_sel").html('<option title="" value="0"   class="text-muted">اختر رمز الدولة</option>');
				$.each(data.countries, function( key,value) {
	  selcntry  ;
	 if(selcntry==value.dialCode){
		$("#country_sel").append('<option selected value="' + value.dialCode + '">' + value.dialCode +' '+value.name+ '</option>');
				
					}else{
						$("#country_sel").append('<option value="' + value.dialCode + '">' + value.dialCode +' '+value.name+ '</option>');
				
					}
					}); // close each()
			}).fail(function(){
				console.log("An error has occurred.");
			});
		}
		 
});

///////////////////////////////////////////////////////
 

