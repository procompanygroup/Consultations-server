
@foreach ($fieldinputs as $fieldinput)
    <div class="service-field row">
        @if ($fieldinput->input->type == 'text')
            <div class="form-group col-8">
                <input type="text" class="form-control " id="inputfield-{{ $fieldinput->input->id }}"
                    placeholder="{{ $fieldinput->input->tooltipe }}" name="inputfield-{{ $fieldinput->input->id }}">
            </div>
            <div class="col-4">
                <div class="form-group d-inline-block">
                    <button  type="button"  class="btn ripple btn-light editinput" id="edit-{{ $fieldinput->input->id }}" data-target="#scrollmodal-edit" data-toggle="modal"><i
                            class="fa fa-edit"></i></button>
                </div>
                <div class="form-horizontal d-inline-block">
                    <div class="form-group">

                        <button type="button" class="btn ripple btn-danger deleteinput"
                            id="{{ $fieldinput->input->id }}"><i class="fa fa-trash"></i></button>
                    </div>
                </div>
            </div>
        @elseif ($fieldinput->input->type == 'bool')
            <div class="form-group col-8">
                <select name="inputfield-{{ $fieldinput->input->id }}" id="inputfield-{{ $fieldinput->input->id }}"
                    class="form-control SlectBox">
                    <!--placeholder-->
                    <option title="" class="text-muted">{{ $fieldinput->input->tooltipe }}</option>
                    <option value="yes">{{ __('general.yes') }}</option>
                    <option value="no">{{ __('general.no') }}</option>
                </select>
            </div>
            <div class="col-4">
				<div class="form-group d-inline-block">
                    <button type="button" class="btn ripple btn-light editinput" id="edit-{{ $fieldinput->input->id }}" data-target="#scrollmodal-edit" data-toggle="modal"><i
                            class="fa fa-edit"></i></button>
                </div>
                <div class="form-horizontal d-inline-block">
                    
                    <div class="form-group">
                        <button type="button" class="btn ripple btn-danger deleteinput"
                            id="{{ $fieldinput->input->id }}"><i class="fa fa-trash"></i></button>
                    </div>
                </div>
            </div>
        @elseif ($fieldinput->input->type == 'list')
            <div class="form-group col-8">
                <select name="inputfield-{{ $fieldinput->input->id }}" id="inputfield-{{ $fieldinput->input->id }}"
                    class="form-control SlectBox">
                    <!--placeholder-->
                    <option title="" class="text-muted">{{ $fieldinput->input->tooltipe }}</option>
                    @foreach ($fieldinput->input->inputvalues as $opValue)
                        <option value="{{ $opValue->value }}">{{ $opValue->value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-4">
				<div class="form-group d-inline-block">
                    <button  type="button"  class="btn ripple btn-light editinput" id="edit-{{ $fieldinput->input->id }}" data-target="#scrollmodal-edit" data-toggle="modal"><i
                            class="fa fa-edit"></i></button>
                </div>
                <div class="form-horizontal d-inline-block">

                    <div class="form-group">
                        <button type="button" class="btn ripple btn-danger deleteinput"
                            id="{{ $fieldinput->input->id }}"><i class="fa fa-trash"></i></button>
                    </div>
                </div>
            </div>
        @elseif ($fieldinput->input->type == 'date')
		<div class="col-8">
			<div class="input-group"  id="birthdate" >
		
				<div class="input-group-prepend" style="padding-right: 1px;">
					<div class="input-group-text">
						<i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>{{ $fieldinput->input->tooltipe }}
					</div>
				</div><input class="form-control fc-datepicker "  name="inputfield-{{ $fieldinput->input->id }}"
				id="inputfield-{{ $fieldinput->input->id }}"   placeholder="MM/DD/YYYY" type="text">
		
			</div>
		</div>
		<div class="col-4">
			<div class="form-group d-inline-block">
				<button  type="button"  class="btn ripple btn-light editinput" id="edit-{{ $fieldinput->input->id }}" data-target="#scrollmodal-edit" data-toggle="modal"><i
						class="fa fa-edit"></i></button>
			</div>
			<div class="form-horizontal d-inline-block" >
				 
				<div class="form-group">
					<button class="btn ripple btn-danger deleteinput" id="{{ $fieldinput->input->id }}"><i class="fa fa-trash"></i></button>
				</div>
			</div>
		</div>
        @elseif ($fieldinput->input->type == 'longtext')
            <div class="form-group col-8">
                <textarea class="form-control" rows="3" id="inputfield-{{ $fieldinput->input->id }}"
                    placeholder="{{ $fieldinput->input->tooltipe }}" name="inputfield-{{ $fieldinput->input->id }}"></textarea>
            </div>
            <div class="col-4">
				{{-- edit --}}
				<div class="form-group d-inline-block">
                    <button  type="button"  class="btn ripple btn-light editinput" id="edit-{{ $fieldinput->input->id }}" data-target="#scrollmodal-edit" data-toggle="modal"><i
                            class="fa fa-edit"></i></button>
                </div>
{{-- delete --}}
                <div class="form-horizontal d-inline-block">
                    <div class="form-group">
                        <button type="button" class="btn ripple btn-danger deleteinput"
                            id="{{ $fieldinput->input->id }}"><i class="fa fa-trash"></i></button>
                    </div>
                </div>

            </div>
        @endif

    </div>
@endforeach







<script>
	var editinputurl='{{url("admin/input/edit/[itemid]")}}';
    $(document).ready(function() {
        $('.deleteinput').on('click', function(e) {
            e.preventDefault();

            	startLoading();
            //ClearErrors();
            //var fdata = $( "#create_form" ).serialize();

            //var formData = 21;

            //var urlval ='{{ url('admin/user') }}';
            //const formData = new FormData("#create_form");
            //  alert(formData.toString());
            var thisId = $(this).prop("id");
            var fullurl = delinputurl.replace("[itemid]", thisId);
            //	alert(fullurl) ;
            $.ajax({
                url: fullurl,
                type: "GET",

                //	data: formData,
                //	contentType: false,
                //processData: false,
                //contentType: 'application/json',
                success: function(data) {
                   // alert("dataok");
					
                     endLoading();
                    //$('#errormsg').html('');
                    //$('#sortbody').html('');
                    if (data.length == 0) {
                        noteError();
                    } else {
                        loadinputsview();

                    }

                    // $('.alert').html(result.success);
                },
                error: function(errorresult) {
                   endLoading();
                    var response = $.parseJSON(errorresult.responseText);

                    // $('#errormsg').html( errorresult );
                    //	alert("error"+errorresult) ;

                },
                finally: function() {
                    endLoading();

                }
            });

        });
		$('.editinput').on('click', function () {
		//	startLoading();
			//e.preventDefault();
          
			reseteditForm();
			//$("#cars").prop('selectedIndex', 2);
			$(".dynamicdiv").remove();
			//$('#list_option').hide();
			//$('#list_option').hide();
			$('#option_append_edit').hide();
		//	$('#divoptionhide').hide();
			$('#btn_edit_option').hide();
			clearInputError($('#field_name_edit'));
			clearInputError($('#field_tooltipe_edit'));
			clearInputError($('#field_icon_edit'));
			clearInputError($('#field_type_edit'));

			//load data

		 
            //ClearErrors();
            //var fdata = $( "#create_form" ).serialize();

            //var formData = 21;

            //var urlval ='{{ url('admin/user') }}';
            //const formData = new FormData("#create_form");
            //  alert(formData.toString());
            var thisId = $(this).prop("id");
			thisId =thisId.replace("edit-", "");
            var fullediturl = editinputurl.replace("[itemid]", thisId);
            //	alert(fullurl) ;
            $.ajax({
                url: fullediturl,
                type: "GET",

                //	data: formData,
                //	contentType: false,
                //processData: false,
                //contentType: 'application/json',
                success: function(data) {
                   // alert("dataok");
					
                  //   endLoading();
                    //$('#errormsg').html('');
                    //$('#sortbody').html('');
                    if (data.length == 0) {
                        noteError();
                    } else {
                     $('#scrollmodal-edit').html(data);

                    }

                    // $('.alert').html(result.success);
                },
                error: function(errorresult) {
                  // endLoading();
                  noteError();
                  //  var response = $.parseJSON(errorresult.responseText);
                    $("#btn_cancel_field_edit").trigger("click");
                    // $('#errormsg').html( errorresult );
                    //	alert("error"+errorresult) ;

                },
                finally: function() {
                 //   endLoading();

                }
            });



		});	
      

    });
	function reseteditForm() {
	 //jQuery('#field_form_edit')[0].reset();
	 $('#field_name_edit').val('');
     $('#field_tooltipe_edit').val('');
  
     $("#field_type_edit").prop("selectedIndex", 0);
	$('#field_icon_label').text('اختر ملف SVG');
	/*
	$('#imgshow').attr("src", emptyimg);
	$('#iconshow').attr("src", emptyimg);
	*/
}
</script>
