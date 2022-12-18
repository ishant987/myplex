
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