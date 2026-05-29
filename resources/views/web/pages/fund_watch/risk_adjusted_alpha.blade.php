
        @forelse($RiskAdjustedAlpha as $key=>$val)
            <tr>
                <td data-label="Ratios">{{ $val->label }}</td>
                <td data-label="Jensen’s Alpha">
                    {{ number_format($val->jensens_alpha, 2) }}</td>
                <td data-label="Beta">{{ number_format($val->beta, 2) }}</td>
                <td data-label="Votality">
                    {{ number_format($val->volatality, 2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4">No data</td>
            </tr>
        @endforelse
  