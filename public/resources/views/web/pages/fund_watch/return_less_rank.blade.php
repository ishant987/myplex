@if ($result != null)
    @forelse($result as $key=>$val)
        <tr class="{{ $loop->index % 2 ? 'even' : 'odd' }}">
            <td data-label="Time Frame" class="sorting_1" date="{{ $val['date'] }}">{{ $val['period'] }}
            </td>
            <td data-label="Amount">{{ $val['rank'] }}
            </td>
            <td data-label="Percentage %">
                {{ $val['active_funds'] }}</td>
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
