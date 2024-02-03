
------------------------------------
	@foreach ($fieldinputs as $fieldinput)
	<div class="service-field row">
	@if($fieldinput->input->type=='text')
	
		<div class="form-group col-8">
			<input type="text" class="form-control " id="inputfield-{{$fieldinput->input->id}}" placeholder="{{$fieldinput->input->tooltipe}}" name="inputfield-{{$fieldinput->input->id}}">
		</div>
		<div class="col-4">
			<div class="form-group d-inline-block">
				<button class="btn ripple btn-light" data-target="#scrollmodal" data-toggle="modal" ><i class="fa fa-edit"></i></button>
			</div>
			<div class="form-horizontal d-inline-block" >
				<div class="form-group">
					<button type="button" class="btn ripple btn-danger deleteinput" id="{{$fieldinput->input->id}}" ><i class="fa fa-trash"></i></button>
				</div>
			</div>
		</div>
	
	@elseif ($fieldinput->input->type=='bool')
	 
		<div class="form-group col-8">
			<select name="inputfield-{{$fieldinput->input->id}}"   id="inputfield-{{$fieldinput->input->id}}" class="form-control SlectBox" >
				<!--placeholder-->
				<option title=""   class="text-muted">{{$fieldinput->input->tooltipe}}</option>
				<option value="yes">{{ __('general.yes') }}</option>
				<option value="no">{{ __('general.no') }}</option>
			</select>                                            </div>
		<div class="col-4">
			<div class="form-group d-inline-block">
				<button type="submit" class="btn ripple btn-light" data-target="#scrollmodal" data-toggle="modal" href=""><i class="fa fa-edit"></i></button>
			</div>
			<form class="form-horizontal d-inline-block" >
				@csrf
				<div class="form-group">
					<button class="btn ripple btn-danger deleteinput"><i class="fa fa-trash"></i></button>
				</div>
			</form>
		</div>
	 
	
	@elseif ($fieldinput->input->type=='list')
 
		<div class="form-group col-8">
			<select name="inputfield-{{$fieldinput->input->id}}"   id="inputfield-{{$fieldinput->input->id}}" class="form-control SlectBox" >
				<!--placeholder-->
				<option title=""   class="text-muted">{{$fieldinput->input->tooltipe}}</option>				 
				@foreach ($fieldinput->input->inputvalues as $opValue)
				<option value="{{$opValue->value}}">{{$opValue->value}}</option>
				@endforeach
			</select>            
		  </div>
		<div class="col-4">
			<div class="form-group d-inline-block">
				<button type="submit" class="btn ripple btn-light" data-target="#scrollmodal" data-toggle="modal" href=""><i class="fa fa-edit"></i></button>
			</div>
			<form class="form-horizontal d-inline-block" >
				@csrf
				<div class="form-group">
					<button class="btn ripple btn-danger deleteinput"><i class="fa fa-trash"></i></button>
				</div>
			</form>
		</div>
	 
	@elseif ($fieldinput->input->type=='date')
	<div class="form-group col-8 ">
			 					 
		<div class="input-group-prepend "  >
			<div class="input-group-text ">
				<i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>{{$fieldinput->input->tooltipe}}
			</div>
			
		</div><input class="form-control  fc-datepicker " name="inputfield-{{$fieldinput->input->id}}"   id="inputfield-{{$fieldinput->input->id}}"    placeholder="MM/DD/YYYY" type="text"  value="" >
	 
	</div>
	<div class="col-4">
		<div class="form-group d-inline-block">
			<button type="submit" class="btn ripple btn-light" data-target="#scrollmodal" data-toggle="modal" href=""><i class="fa fa-edit"></i></button>
		</div>
		<form class="form-horizontal d-inline-block" >
			@csrf
			<div class="form-group">
				<button class="btn ripple btn-danger"><i class="fa fa-trash"></i></button>
			</div>
		</form>
	</div>
 

	@elseif ($fieldinput->input->type=='longtext')
	<div class="form-group col-8">
			<textarea class="form-control"   rows="3" id="inputfield-{{$fieldinput->input->id}}" placeholder="{{$fieldinput->input->tooltipe}}" name="inputfield-{{$fieldinput->input->id}}" ></textarea>
	</div>
	<div class="col-4">
		<div class="form-group d-inline-block">
			<button class="btn ripple btn-light" data-target="#scrollmodal" data-toggle="modal" ><i class="fa fa-edit"></i></button>
		</div>
		<form class="form-horizontal d-inline-block" >
			<div class="form-group">
				<button type="submit" class="btn ripple btn-danger" ><i class="fa fa-trash"></i></button>
			</div>
		</form>
	</div>
	@endif
	
</div>
	@endforeach
	 -------------------------------------
	 <script  >
		$(document).ready(function () {
	 $('.deleteinput').on('click',function (e) {
		e.preventDefault();	
		
		//	startLoading();
		 //ClearErrors();
			//var fdata = $( "#create_form" ).serialize();
			
			//var formData = 21;
			
			//var urlval ='{{url("admin/user")}}';
			//const formData = new FormData("#create_form");
			//  alert(formData.toString());
			var thisId = $(this).prop("id");
			var fullurl=delinputurl.replace("[itemid]",thisId);
		//	alert(fullurl) ;
			$.ajax({
				url: fullurl,
				type: "GET",
				
			//	data: formData,
			//	contentType: false,
				//processData: false,
				//contentType: 'application/json',
				success: function (data) {
					 	alert("dataok");
					//endLoading();
					//$('#errormsg').html('');
					//$('#sortbody').html('');
					if (data.length == 0) {
						noteError();
					} else  {
					//$('#div_extrainputs').html(data);
						
					}
	
					// $('.alert').html(result.success);
				}, error: function (errorresult) {
					//endLoading();
					var response = $.parseJSON(errorresult.responseText);

					// $('#errormsg').html( errorresult );
				//	alert("error"+errorresult) ;
	 
				},finally:function () {
					//endLoading();
	
				}
			});
	
		});
	
		});
	</script>