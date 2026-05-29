@if ($result != null)
    @forelse($result as $key=>$val)
        <tr class="{{ $loop->index % 2 ? 'even' : 'odd' }}">
            <td data-label="Time Frame" class="sorting_1" date="{{ $val['date'] }}">{{ $val['period'] }}
            </td>
            <td data-label="Amount">@if($val['rank'] != 0){{ $val['rank'] + 1 }}@else NA @endif
            </td>
            <td data-label="Percentage %">
                @if($val['active_funds']){{ $val['active_funds'] }}@else NA @endif</td>
			<td data-label="Category Decile">
                @if($val['decile']){{ $val['decile'] }}@else NA @endif</td>
			<td data-label="Category Quartile">
                @if($val['quartile']){{ $val['quartile'] }}@else NA @endif</td>
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
