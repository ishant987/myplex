<tr>
    <td data-label="Return">Benchmark</td>
    <td data-label="6M">{{ !empty($bench_mark) && $bench_mark['SIXMONTHS'] !='' ? round($bench_mark['SIXMONTHS'], 2) : 'NA' }}</td>
    <td data-label="1Y">{{ !empty($bench_mark) && $bench_mark['ONEYEAR'] !='' ? round($bench_mark['ONEYEAR'], 2) : 'NA' }}</td>
    <td data-label="2Y">{{ !empty($bench_mark) && $bench_mark['TWOYEAR'] !='' ? round($bench_mark['TWOYEAR'], 2) : 'NA' }}</td>
    <td data-label="3Y">{{ !empty($bench_mark) && $bench_mark['THREEYEAR'] !='' ? round($bench_mark['THREEYEAR'], 2) : "NA" }}</td>
    <td data-label="5Y">{{ !empty($bench_mark) && $bench_mark['FIVEYEAR'] !='' ? round($bench_mark['FIVEYEAR'], 2): "NA" }}</td>
</tr>
<tr>
    <td data-label="Return">Scheme</td>
   	<td data-label="6M">{{ !empty($scheme) && $scheme['SIXMONTHS'] != '' ? round($scheme['SIXMONTHS'], 2) : 'NA' }}</td>
    <td data-label="1Y">{{ !empty($scheme) && $scheme['ONEYEAR'] != '' ? round($scheme['ONEYEAR'], 2) : 'NA' }}</td>
    <td data-label="2Y">{{ !empty($scheme) && $scheme['TWOYEAR'] != '' ? round($scheme['TWOYEAR'], 2) : 'NA' }}</td>
    <td data-label="3Y">@if(!empty($scheme) && $scheme['THREEYEAR'])
		{{ round($scheme['THREEYEAR'], 2) != "9999" ? round($scheme['THREEYEAR'], 2) : "NA" }}@endif</td>
	
    <td data-label="5Y">@if(!empty($scheme) && $scheme['FIVEYEAR'])
		{{ round($scheme['FIVEYEAR'], 2) != "9999" ? round($scheme['FIVEYEAR'], 2) : "NA" }}@else NA @endif</td>
	
</tr>
<tr>
  <td data-label="Return">Category AV</td>
    <td data-label="6M">
      @if(!empty($category_average) && !empty($category_average['SIXMONTHS']) && array_key_exists('category_avg', $category_average['SIXMONTHS']))
          {{ round($category_average['SIXMONTHS']['category_avg'], 2) }}
      @else
          {{ 'NA' }}
      @endif
    </td>

    <td data-label="1Y">
        @if(!empty($category_average) && !empty($category_average['ONEYEAR']) && array_key_exists('category_avg', $category_average['ONEYEAR']))
            {{ round($category_average['ONEYEAR']['category_avg'], 2) }}
        @else
            {{ 'NA' }}
        @endif
    </td>

    <td data-label="2Y">
        @if(!empty($category_average) && !empty($category_average['TWOYEAR']) && array_key_exists('category_avg', $category_average['TWOYEAR']))
            {{ round($category_average['TWOYEAR']['category_avg'], 2) }}
        @else
            {{ 'NA' }}
        @endif
    </td>

    <td data-label="3Y">
		@if(!empty($category_average) && !empty($category_average['THREEYEAR']) && array_key_exists('category_avg', $category_average['THREEYEAR']))
				{{ round($category_average['THREEYEAR']['category_avg'], 2) != "9999" ? round($category_average['THREEYEAR']['category_avg'], 2) : "NA" }}
		@else
		NA
		@endif
	</td>
    <td data-label="5Y">
		@if(!empty($category_average) && !empty($category_average['FIVEYEAR']) && array_key_exists('category_avg', $category_average['FIVEYEAR']))
			{{ round($category_average['FIVEYEAR']['category_avg'], 2) != "9999" ? round($category_average['THREEYEAR']['category_avg'], 2) : "NA"}}
		@else
		NA
		@endif
	</td>
</tr>
