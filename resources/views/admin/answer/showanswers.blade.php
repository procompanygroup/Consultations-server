<div class="table-responsive">
    <table   class="table text-md-nowrap">
        <thead>
            <tr>

                <th class="border-bottom-0">{{ __('general.answer') }}</th>
                <th class="border-bottom-0">الرد الصوتي</th>
                <th class="border-bottom-0">تاريخ الرد</th>
                <th class="border-bottom-0">{{ __('general.status') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($answers->whereNotIn('answer_state',['wait']) as $answer)
            <tr>

                <td>{{$answer->content}}</td>
                <td> <audio controls >
                    <source src="{{ $answer->record_path }}" type="audio/mpeg">
                </audio></td>
                <td>{{ $answer->created_at}}</td>
                <td>{{ $answer->answer_state_conv}}</td>                     

            </tr>
            @endforeach
    </tbody>
    </table>
</div>