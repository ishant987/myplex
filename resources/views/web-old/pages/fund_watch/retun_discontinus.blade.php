<tr>
    <td data-label="Return">Benchmark</td>
    <td data-label="6M">@if(!empty($bench_mark) && $bench_mark['SIXMONTHS']){{ round($bench_mark['SIXMONTHS'], 2) }}@else NA @endif</td>
    <td data-label="1Y">@if(!empty($bench_mark) && $bench_mark['ODDONEYEAR']){{ round($bench_mark['ODDONEYEAR'], 2) }}@else NA @endif</td>
    <td data-label="2Y">@if(!empty($bench_mark) && $bench_mark['ODDTWOYEAR']){{ round($bench_mark['ODDTWOYEAR'], 2) }}@else NA @endif</td>
</tr>
<tr>
    <td data-label="Return">Scheme</td>
	<td data-label="6M">@if(!empty($scheme) && $scheme['SIXMONTHS']){{ round($scheme['SIXMONTHS'], 2) }}@else NA @endif</td>
    <td data-label="1Y">@if(!empty($scheme) && $scheme['ODDONEYEAR']){{ round($scheme['ODDONEYEAR'], 2) }}@else NA @endif</td>
    <td data-label="2Y">@if(!empty($scheme) && $scheme['ODDTWOYEAR']){{ round($scheme['ODDTWOYEAR'], 2) }}@else NA @endif</td>
</tr>
<tr>
    <td data-label="Return">Category AV</td>
    <td data-label="6M">@if(!empty($category_average) && $category_average['SIXMONTHS'] && array_key_exists('category_avg', $category_average['SIXMONTHS'])){{ round($category_average['SIXMONTHS']['category_avg'], 2) }}@else NA @endif</td>
    <td data-label="1Y">@if(!empty($category_average) && $category_average['ONEYEAR'] && array_key_exists('category_avg', $category_average['ONEYEAR'])){{ round($category_average['ONEYEAR']['category_avg'], 2) }}@else NA @endif</td>
    <td data-label="2Y">@if(!empty($category_average) && $category_average['TWOYEAR'] && array_key_exists('category_avg', $category_average['TWOYEAR'])){{ round($category_average['TWOYEAR']['category_avg'], 2) }}@else NA @endif</td>
</tr>