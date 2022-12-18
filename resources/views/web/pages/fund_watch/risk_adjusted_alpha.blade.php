
        @forelse($RiskAdjustedAlpha as $key=>$val)
            <tr>
                <td data-label="Ratios">{{ $key }}</td>
                <td data-label="Jensen’s Alpha">
                    {{ round($val['jensen_alpha'], 2) }}</td>
                <td data-label="Beta">{{ round($val['beta'], 2) }}%</td>
                <td data-label="Votality">
                    {{ round($val['volatality'], 2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4">No data</td>
            </tr>
        @endforelse
    </tbody>
</table>