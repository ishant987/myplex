<tr>
    <td data-label="Return">Benchmark</td>
    <td data-label="6M"><?php echo e(round($bench_mark['SIXMONTHS'], 2)); ?></td>
    <td data-label="1Y"><?php echo e(round($bench_mark['ONEYEAR'], 2)); ?></td>
    <td data-label="2Y"><?php echo e(round($bench_mark['TWOYEAR'], 2)); ?></td>
    <td data-label="3Y"><?php echo e(round($bench_mark['THREEYEAR'], 2) != 0 ?  round($bench_mark['THREEYEAR'], 2) : "NA"); ?></td>
    <td data-label="5Y"><?php echo e(round($bench_mark['FIVEYEAR'], 2) != 0 ?  round($bench_mark['FIVEYEAR'], 2): "NA"); ?></td>
</tr>
<tr>
    <td data-label="Return">Scheme</td>
   	<td data-label="6M"><?php echo e(round($scheme['SIXMONTHS'], 2)); ?></td>
    <td data-label="1Y"><?php echo e(round($scheme['ONEYEAR'], 2)); ?></td>
    <td data-label="2Y"><?php echo e(round($scheme['TWOYEAR'], 2)); ?></td>
    <td data-label="3Y"><?php if($scheme['THREEYEAR']): ?>
		<?php echo e(round($scheme['THREEYEAR'], 2) != "9999" ? round($scheme['THREEYEAR'], 2) : "NA"); ?><?php endif; ?></td>
	
    <td data-label="5Y"><?php if($scheme['FIVEYEAR']): ?>
		<?php echo e(round($scheme['FIVEYEAR'], 2) != "9999" ? round($scheme['FIVEYEAR'], 2) : "NA"); ?><?php else: ?> NA <?php endif; ?></td>
	
</tr>
<tr>
    <td data-label="Return">Category AV</td>
    <td data-label="6M"><?php echo e(round($category_average['SIXMONTHS']['category_avg'], 2)); ?></td>
    <td data-label="1Y"><?php echo e(round($category_average['ONEYEAR']['category_avg'], 2)); ?></td>
    <td data-label="2Y"><?php echo e(round($category_average['TWOYEAR']['category_avg'], 2)); ?></td>
    <td data-label="3Y">
		<?php if($category_average['THREEYEAR']): ?>
				<?php echo e(round($category_average['THREEYEAR']['category_avg'], 2) != "9999" ? round($category_average['THREEYEAR']['category_avg'], 2) : "NA"); ?>

		<?php else: ?>
		NA
		<?php endif; ?>
	</td>
    <td data-label="5Y">
		<?php if($category_average['FIVEYEAR']): ?>
			<?php echo e(round($category_average['FIVEYEAR']['category_avg'], 2) != "9999" ? round($category_average['THREEYEAR']['category_avg'], 2) : "NA"); ?>

		<?php else: ?>
		NA
		<?php endif; ?>
	</td>
</tr>
<?php /**PATH /var/www/vhosts/new.myplexus.com/httpdocs/my-plexus/resources/views/web/pages/fund_watch/retun_continus.blade.php ENDPATH**/ ?>