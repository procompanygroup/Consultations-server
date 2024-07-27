    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">تعديل نسبة الخبير للخدمة:  {{ $expertservice->service->name }}</h6> <button aria-label="Close" class="close"
                    data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <!-- row -->
                <div class="row row-sm">
                    <div class="col">
                        <div class="card  box-shadow-0">
                            <div class="card-body pt-4">
                                <h6 class="modal-title">الخبير: {{ $expertservice->expert->full_name }}</h6>
                                <form class="form-horizontal" name="point_form"
                                    action="{{ url('admin/service/percent/save', $expertservice->id) }}" method="POST"
                                    id="point_form">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <input type="text" class="form-control " value="{{ $expertservice->expert_cost }}" id="expert_cost" placeholder="النسبة" name="expert_cost">
                                        <ul class="parsley-errors-list filled" >
                                            <li class="parsley-required" id="expert_cost_error"></li>
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
                <button class="btn ripple btn-primary" type="submit" form="point_form" name="btn_save_percent_form" id="btn_save_percent_form"

                   >حفظ</button>
                <button class="btn ripple btn-secondary" data-dismiss="modal" name="btn_cancel_field"
                    id="btn_cancel_field" type="button"> إلغاء</button>
            </div>
        </div>
    </div>
<!--End Scroll with content modal -->

<script src="{{ URL::asset('assets/js/admin/percent.js') }}"></script>
