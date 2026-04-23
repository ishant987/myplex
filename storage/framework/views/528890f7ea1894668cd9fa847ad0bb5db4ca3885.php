<tr>
    <td data-label="Return">Benchmark</td>
    <td data-label="6M"><?php if(!empty($bench_mark) && $bench_mark['SIXMONTHS']): ?><?php echo e(round($bench_mark['SIXMONTHS'], 2)); ?><?php else: ?> NA <?php endif; ?></td>
    <td data-label="1Y"><?php if(!empty($bench_mark) && $bench_mark['ODDONEYEAR']): ?><?php echo e(round($bench_mark['ODDONEYEAR'], 2)); ?><?php else: ?> NA <?php endif; ?></td>
    <td data-label="2Y"><?php if(!empty($bench_mark) && $bench_mark['ODDTWOYEAR']): ?><?php echo e(round($bench_mark['ODDTWOYEAR'], 2)); ?><?php else: ?> NA <?php endif; ?></td>
</tr>
<tr>
    <td data-label="Return">Scheme</td>
	<td data-label="6M"><?php if(!empty($scheme) && $scheme['SIXMONTHS']): ?><?php echo e(round($scheme['SIXMONTHS'], 2)); ?><?php else: ?> NA <?php endif; ?></td>
    <td data-label="1Y"><?php if(!empty($scheme) && $scheme['ODDONEYEAR']): ?><?php echo e(round($scheme['ODDONEYEAR'], 2)); ?><?php else: ?> NA <?php endif; ?></td>
    <td data-label="2Y"><?php if(!empty($scheme) && $scheme['ODDTWOYEAR']): ?><?php echo e(round($scheme['ODDTWOYEAR'], 2)); ?><?php else: ?> NA <?php endif; ?></td>
</tr>
<tr>
    <td data-label="Return">Category AV</td>
    <td data-label="6M"><?php if(!empty($category_average) && $category_average['SIXMONTHS'] && array_key_exists('category_avg', $category_average['SIXMONTHS'])): ?><?php echo e(round($category_average['SIXMONTHS']['category_avg'], 2)); ?><?php else: ?> NA <?php endif; ?></td>
    <td data-label="1Y"><?php if(!empty($category_average) && $category_average['ONEYEAR'] && array_key_exists('category_avg', $category_average['ONEYEAR'])): ?><?php echo e(round($category_average['ONEYEAR']['category_avg'], 2)); ?><?php else: ?> NA <?php endif; ?></td>
    <td data-label="2Y"><?php if(!empty($category_average) && $category_average['TWOYEAR'] && array_key_exists('category_avg', $category_average['TWOYEAR'])): ?><?php echo e(round($category_average['TWOYEAR']['category_avg'], 2)); ?><?php else: ?> NA <?php endif; ?></td>
</tr><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/pages/fund_watch/retun_discontinus.blade.php ENDPATH**/ ?>