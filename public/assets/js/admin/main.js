var lastOrderId=0;
$(document).ready(function () {

    function loadlastorders() {	
    var url=    noteOrdersUrl	;
    url= url.replace("itemId",lastOrderId);
        //var formData = 'msg_id='+lastid()+'&client_id='+clientId;
        $.ajax({
            url:  url,
            type: "GET",	
            
            contentType: false,
            processData: false,
            //contentType: 'application/json',
            success: function (data) {				 
                if (data.length == 0) {
                  
                    //noteError();
                } else  {	
                    //noteSuccess();	
                    if(data.orders!=0){
                        $('#orders-num ').text(data.orders) ;                     
                       }
                       if(data.answers!=0){
                       $('#answers-num ').text(data.answers) ;
                       }
                       if(data.comments!=0){
                       $('#comments-num ').text(data.comments) ;
                       }
                       if(data.rates!=0){
                       $('#rates-num ').text(data.rates) ;
                         }
                         fillnotifyorders (data);
                         fillalertorders(data);
                     
                }

               
            }, error: function (errorresult) {
               
                var response = $.parseJSON(errorresult.responseText);
               

            }, finally: function () {
            

            }
         

        });


     
    }

    function fillnotifyorders (data) {
        $('#notify-orders-container').html('');
      //  lastOrderId= data.list[1].id;
        var i=0;
               $.each(data.list,function(index,item) {
                if( i==0){
                    lastOrderId=item.id;
                }
i++;
                    var o_url=item.url;
                    var text=item.type;
                    var since_order=item.created_since;
                 var row=   '<a class="d-flex p-2 border-bottom" href="'+o_url+'"><div class="mr-3"><h5 class="notification-label mb-1">'+
                 text+'</h5><div class="notification-subtext">'+since_order+
                 '</div></div>   <div class="mr-auto"> <i class="las la-angle-left text-left text-muted"></i> </div></a>'		 
                    $('#notify-orders-container').append(row); 
          });							 
                };	
                function fillalertorders (data) {  
                            $.each(data.alert_list,function(index,item) {   
                           showNotification("bg-blue",item.type,"top", "right","animated fadeInRight","animated fadeOutRight",item.url);
                      }) ;							 
                            };	
    loadlastorders();
    setInterval(loadlastorders,30000);
});
function startLoading() {
   
    document.getElementById("loading").style.display = "block";
}
function endLoading() {
     
    document.getElementById("loading").style.display = "none";
}


