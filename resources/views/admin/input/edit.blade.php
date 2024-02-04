
<div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content modal-content-demo">
        <div class="modal-header">
            <h6 class="modal-title">تعديل حقل الخدمة</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <!-- row -->
            <div class="row row-sm">
                <div class="col">
                    <div class="card  box-shadow-0">
                        <div class="card-body pt-4">
                            <form class="form-horizontal" name="field_form_edit" action="{{url('admin/input/update',$input->id )}}" method="POST" enctype="multipart/form-data" id="field_form_edit" >
                              @csrf

                                <div class="form-group">
                                    <input type="text" class="form-control " value="{{ $input->name }}" id="field_name_edit" placeholder="{{ __('general.field_name') }}" name="field_name_edit">
                                    <ul class="parsley-errors-list filled" >
                                        <li class="parsley-required" id="field_name_edit_error"></li>
                                    </ul>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control " id="field_tooltipe_edit" value="{{ $input->tooltipe }}" placeholder="التلميح" name="field_tooltipe_edit">
                                    <ul class="parsley-errors-list filled" >
                                        <li class="parsley-required" id="field_tooltipe_error"></li>
                                    </ul>
                                </div>
                                {{-- icon --}}
                                <div class="form-group mb-4 justify-content-end">
                                    <div class="custom-file">
                                        <input class="custom-file-input" id="field_icon_edit" name="field_icon_edit" type="file"> <label class="custom-file-label" id="field_icon_label" for="customFile">{{ __('general.choose svg') }}</label>
                                        <ul class="parsley-errors-list filled" >
                                            <li class="parsley-required" id="field_icon_edit_error"></li>
                                        </ul>
                                    </div>

                                </div>
                                <div class="form-group mb-3">
                                    <select name="field_type_edit"   id="field_type_edit" class="form-control SlectBox"  >
                                        <!--placeholder-->
                                        <option title=""   class="text-muted">نوع الحقل</option>
                                        <option value="text" @if (  $input->type=='text')selected="selected" @endif >حقل نصي</option>
                                        <option value="bool"  @if (  $input->type=='bool')selected="selected" @endif >قائمة نعم/لا</option>
                                        <option value="list"  @if (  $input->type=='list')selected="selected" @endif >قائمة متعدد</option>
                                        <option value="date"  @if (  $input->type=='date')selected="selected" @endif >حقل تاريخ</option>
                                        <option value="longtext"  @if (  $input->type=='longtext')selected="selected" @endif >حقل نصي طويل</option>
                                    </select>
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required"  id="field_type_edit_error"></li>
                                    </ul>
                                </div>

                                <div id="option_append_edit">    
                                    @if($input->type=='list')  
                                    @php
                                  $i=1;
                                @endphp

                             @foreach ($input->inputvalues as $optionrow )
                             <div class="form-group add-input dynamicdiv" id="divoption_{{$i}}" >
                                <input type="text" class="form-control" id="list_option_{{$i}}" value="{{$optionrow->value}}" placeholder="ادخل الاختيار" name="list_option[{{$i}}]">
                                <button class="close" type="button" onclick="this.parentElement.remove();"><span>×</span></button>
                                <ul class="parsley-errors-list filled">
                                    <li class="parsley-required" id="list_option_error"></li>
                                </ul>
                            </div>  
                            @php
                            $i++;
                          @endphp 
                             @endforeach
                             @endif
                                </div>
                                <div class="form-group mb-4 justify-content-end">
                                    <div>
                                        <button type="button" name="btn_edit_option" @if($input->type!='list') style="display: none;" @endif id="btn_edit_option" class="btn btn-light btn-block"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>


                </div>
            </div>
            <!-- row -->
        </div>
        <div class="modal-footer">
            <button class="btn ripple btn-primary" name="btn_edit_field" id="btn_edit_field" type="submit">حفظ</button>
            <button class="btn ripple btn-secondary" data-dismiss="modal"  name="btn_cancel_field_edit" id="btn_cancel_field_edit" type="button"> إلغاء</button>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    var i=1;

$('#btn_edit_option').on('click', function () {
    //alert("hi");
    var $divclon=	$('#divoptionhide').clone().prop('id', 'divoption_'+i).addClass('dynamicdiv').show();
     
    $divclon.children(':input').first().prop('id', 'list_option_'+i)
    .prop('name', 'list_option'+'['+i+']')
    .prop('value','');
    //$('#divoption').after( $divclon);
    $('#option_append_edit').append($divclon);
    i++;
    });
});
</script>