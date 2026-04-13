<tr>
    <td data-label="Return">Benchmark</td>
    <td data-label="6M"><?php echo e(!empty($bench_mark) && $bench_mark['SIXMONTHS'] !='' ? round($bench_mark['SIXMONTHS'], 2) : 'NA'); ?></td>
    <td data-label="1Y"><?php echo e(!empty($bench_mark) && $bench_mark['ONEYEAR'] !='' ? round($bench_mark['ONEYEAR'], 2) : 'NA'); ?></td>
    <td data-label="2Y"><?php echo e(!empty($bench_mark) && $bench_mark['TWOYEAR'] !='' ? round($bench_mark['TWOYEAR'], 2) : 'NA'); ?></td>
    <td data-label="3Y"><?php echo e(!empty($bench_mark) && $bench_mark['THREEYEAR'] !='' ? round($bench_mark['THREEYEAR'], 2) : "NA"); ?></td>
    <td data-label="5Y"><?php echo e(!empty($bench_mark) && $bench_mark['FIVEYEAR'] !='' ? round($bench_mark['FIVEYEAR'], 2): "NA"); ?></td>
</tr>
<tr>
    <td data-label="Return">Scheme</td>
   	<td data-label="6M"><?php echo e(!empty($scheme) && $scheme['SIXMONTHS'] != '' ? round($scheme['SIXMONTHS'], 2) : 'NA'); ?></td>
    <td data-label="1Y"><?php echo e(!empty($scheme) && $scheme['ONEYEAR'] != '' ? round($scheme['ONEYEAR'], 2) : 'NA'); ?></td>
    <td data-label="2Y"><?php echo e(!empty($scheme) && $scheme['TWOYEAR'] != '' ? round($scheme['TWOYEAR'], 2) : 'NA'); ?></td>
    <td data-label="3Y"><?php if(!empty($scheme) && $scheme['THREEYEAR']): ?>
		<?php echo e(round($scheme['THREEYEAR'], 2) != "9999" ? round($scheme['THREEYEAR'], 2) : "NA"); ?><?php endif; ?></td>
	
    <td data-label="5Y"><?php if(!empty($scheme) && $scheme['FIVEYEAR']): ?>
		<?php echo e(round($scheme['FIVEYEAR'], 2) != "9999" ? round($scheme['FIVEYEAR'], 2) : "NA"); ?><?php else: ?> NA <?php endif; ?></td>
	
</tr>
<tr>
  <td data-label="Return">Category AV</td>
    <td data-label="6M">
      <?php if(!empty($category_average) && !empty($category_average['SIXMONTHS']) && array_key_exists('category_avg', $category_average['SIXMONTHS'])): ?>
          <?php echo e(round($category_average['SIXMONTHS']['category_avg'], 2)); ?>

      <?php else: ?>
          <?php echo e('NA'); ?>

      <?php endif; ?>
    </td>

    <td data-label="1Y">
        <?php if(!empty($category_average) && !empty($category_average['ONEYEAR']) && array_key_exists('category_avg', $category_average['ONEYEAR'])): ?>
            <?php echo e(round($category_average['ONEYEAR']['category_avg'], 2)); ?>

        <?php else: ?>
            <?php echo e('NA'); ?>

        <?php endif; ?>
    </td>

    <td data-label="2Y">
        <?php if(!empty($category_average) && !empty($category_average['TWOYEAR']) && array_key_exists('category_avg', $category_average['TWOYEAR'])): ?>
            <?php echo e(round($category_average['TWOYEAR']['category_avg'], 2)); ?>

        <?php else: ?>
            <?php echo e('NA'); ?>

        <?php endif; ?>
    </td>

    <td data-label="3Y">
		<?php if(!empty($category_average) && !empty($category_average['THREEYEAR']) && array_key_exists('category_avg', $category_average['THREEYEAR'])): ?>
				<?php echo e(round($category_average['THREEYEAR']['category_avg'], 2) != "9999" ? round($category_average['THREEYEAR']['category_avg'], 2) : "NA"); ?>

		<?php else: ?>
		NA
		<?php endif; ?>
	</td>
    <td data-label="5Y">
		<?php if(!empty($category_average) && !empty($category_average['FIVEYEAR']) && array_key_exists('category_avg', $category_average['FIVEYEAR'])): ?>
			<?php echo e(round($category_average['FIVEYEAR']['category_avg'], 2) != "9999" ? round($category_average['THREEYEAR']['category_avg'], 2) : "NA"); ?>

		<?php else: ?>
		NA
		<?php endif; ?>
	</td>
</tr>
<?php /**PATH /var/www/vhosts/myplexus.com/httpdocs/resources/views/web/pages/fund_watch/retun_continus.blade.php ENDPATH**/ ?>