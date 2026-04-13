<tr>
    <td data-label="Return">Benchmark</td>
    <td data-label="6M"><?php if($bench_mark['SIXMONTHS']): ?><?php echo e(round($bench_mark['SIXMONTHS'], 2)); ?><?php else: ?> NA <?php endif; ?></td>
    <td data-label="1Y"><?php if($bench_mark['ODDONEYEAR']): ?><?php echo e(round($bench_mark['ODDONEYEAR'], 2)); ?><?php else: ?> NA <?php endif; ?></td>
    <td data-label="2Y"><?php if($bench_mark['ODDTWOYEAR']): ?><?php echo e(round($bench_mark['ODDTWOYEAR'], 2)); ?><?php else: ?> NA <?php endif; ?></td>
</tr>
<tr>
    <td data-label="Return">Scheme</td>
	<td data-label="6M"><?php if($category_average['SIXMONTHS']): ?><?php echo e(round($category_average['SIXMONTHS']['cagr_value'], 2)); ?><?php else: ?> NA <?php endif; ?></td>
    <td data-label="1Y"><?php if($category_average['ONEYEAR']): ?><?php echo e(round($category_average['ONEYEAR']['cagr_value'], 2)); ?><?php else: ?> NA <?php endif; ?></td>
    <td data-label="2Y"><?php if($category_average['TWOYEAR']): ?><?php echo e(round($category_average['TWOYEAR']['cagr_value'], 2)); ?><?php else: ?> NA <?php endif; ?></td>
</tr>
<tr>
    <td data-label="Return">Category AV</td>
    <td data-label="6M"><?php if($category_average['SIXMONTHS']): ?><?php echo e(round($category_average['SIXMONTHS']['category_avg'], 2)); ?><?php else: ?> NA <?php endif; ?></td>
    <td data-label="1Y"><?php if($category_average['ONEYEAR']): ?><?php echo e(round($category_average['ONEYEAR']['category_avg'], 2)); ?><?php else: ?> NA <?php endif; ?></td>
    <td data-label="2Y"><?php if($category_average['TWOYEAR']): ?><?php echo e(round($category_average['TWOYEAR']['category_avg'], 2)); ?><?php else: ?> NA <?php endif; ?></td>
</tr><?php /**PATH /var/www/vhosts/new.myplexus.com/httpdocs/my-plexus/resources/views/web/pages/fund_watch/retun_discontinus.blade.php ENDPATH**/ ?>