<div class="table-responsive">
    <table id="example" class="table text-md-nowrap">
        <thead>
            <tr>

                <th class="border-bottom-0">اسم الخبير</th>
                <th class="border-bottom-0">النقاط</th>

                <th class="border-bottom-0">{{ __('general.action') }}</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($selectedexperts as $selectedexpert)
                <tr>

                    <td>{{ $selectedexpert->expert->first_name . ' ' . $selectedexpert->expert->last_name }}
                    </td>
                    <td>{{ $selectedexpert->points }}</td>

                    <td>
                        <button   class="btn btn-success btn-sm btn-edit-point" id="expert-service-{{ $selectedexpert->id }}"
                            data-target="#scrollmodal-edit-point" data-toggle="modal"
                            title="{{ __('general.edit') }}"><i class="fa fa-edit"></i></button>

                        <form action="{{ url('admin/service/expert/deleteselected', $selectedexpert->id) }}" method="POST" class="d-inline" id="delete_expert_form">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm btn-delete-expert"
                            id="expert-{{ $selectedexpert->expert->id }}"><i
                                class="fa fa-trash"></i></button>
                        </form>

                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>



    <!-- Internal Data tables -->


    <script src="{{ URL::asset('assets/js/admin/expert.js') }}"></script>
    <script src="{{ URL::asset('assets/js/admin/pointmodal.js') }}"></script>

