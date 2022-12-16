<table id="example"
class="table table-striped dataTable no-footer"
style="width: 100%;">
<thead>
    <tr>
        <th class="green_bg sorting sorting_asc"
            tabindex="0" aria-controls="example"
            rowspan="1" colspan="1"
            aria-sort="ascending"
            aria-label="Time Frame: activate to sort column descending"
            style="width: 213px;">Time Frame</th>
        <th class="dark_bg sorting" tabindex="0"
            aria-controls="example" rowspan="1"
            colspan="1"
            aria-label="Amount: activate to sort column ascending"
            style="width: 156px;">Amount</th>
        <th class="dark_bg sorting" tabindex="0"
            aria-controls="example" rowspan="1"
            colspan="1"
            aria-label="Percentage %: activate to sort column ascending"
            style="width: 244px;">Percentage %</th>
    </tr>
</thead>
<tbody>
    @if ($lumbsum != null)
        @forelse($lumbsum as $key=>$val)
            <tr
                class="{{ $loop->index % 2 ? 'even' : 'odd' }}">
                <td data-label="Time Frame"
                    class="sorting_1">{{ $key }}
                </td>
                <td data-label="Amount">{{ $val['amount'] }}
                </td>
                <td data-label="Percentage %">
                    {{ $val['percentage'] }}%</td>
            </tr>
        @empty
            <tr>
                <td colspan="3">No data</td>
            </tr>
        @endforelse
    @else
        <tr>
            <td colspan="3">No data</td>
        </tr>
    @endif
</table>