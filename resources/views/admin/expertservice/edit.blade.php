    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">نسبة الخبير للخدمة: {{ $service->name }} </h6><button aria-label="Close" class="close"
                    data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <!-- row -->
                <div class="row row-sm">
                    <div class="col">
                        <div class="card  box-shadow-0">
                            <div class="card-body pt-4">
                                <form class="form-horizontal" name="expert_percent_form"
                                    action="{{ url('admin/service/percent/save', $service->id) }}" method="POST"
                                    id="expert_percent_form">
                                    @csrf                        
                                    <div class="form-group mb-3">
                                        <input type="text" class="form-control " value="{{ $service->expert_percent }}" id="expert_percent" placeholder="{{ __('general.field_name') }}" name="expert_percent">
                                        <ul class="parsley-errors-list filled" >
                                            <li class="parsley-required" id="expert_percent_error"></li>
                                        </ul>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- row -->
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" type="submit" form="expert_percent_form" name="btn_save_percent" id="btn_save_percent"   
                
                   >حفظ</button>
                <button class="btn ripple btn-secondary" data-dismiss="modal" name="btn_cancel_field"
                    id="btn_cancel_field" type="button"> إلغاء</button>
            </div>
        </div>
    </div>
<!--End Scroll with content modal -->
 
<script src="{{ URL::asset('assets/js/admin/percent.js') }}"></script>