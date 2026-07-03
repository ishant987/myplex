<?php $__env->startSection('content'); ?>
<div class="row"><div class="col-sm-12"><div class="card"><div class="card-header"><h5>Bulk Upload SEO Pages</h5></div><div class="card-block">
  <?php if($errors->any()): ?><div class="alert alert-danger"><?php echo e($errors->first()); ?></div><?php endif; ?>
  <a class="btn btn-info mb-3" href="<?php echo e(route('admin.seo-pages.template')); ?>">Download CSV Template</a>
  <form method="post" action="<?php echo e(route('admin.seo-pages.preview-csv')); ?>" enctype="multipart/form-data" class="mb-4"><?php echo csrf_field(); ?><input type="file" name="csv_file" accept=".csv,text/csv" required><button class="btn btn-primary">Preview CSV</button></form>
  <?php if($rows): ?>
  <form method="post" action="<?php echo e(route('admin.seo-pages.publish-csv')); ?>"><?php echo csrf_field(); ?>
    <div class="table-responsive"><table class="table table-bordered"><thead><tr><th>#</th><th>Title</th><th>Slug</th><th>Status</th><th>Warnings</th></tr></thead><tbody>
      <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><tr><td><?php echo e($i+1); ?></td><td><?php echo e($row['page_title'] ?? ''); ?></td><td><?php echo e($row['url_slug'] ?? ''); ?></td><td><?php echo e($row['status'] ?? ''); ?></td><td class="<?php echo e(empty($errorsByRow[$i+1]) ? 'text-success' : 'text-danger'); ?>"><?php echo e(empty($errorsByRow[$i+1]) ? 'Ready' : implode(' ', $errorsByRow[$i+1])); ?></td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody></table></div>
    <button class="btn btn-success" name="bulk_status" value="published" <?php echo e(!empty($errorsByRow) ? 'disabled' : ''); ?>>Publish All</button>
    <button class="btn btn-secondary" name="bulk_status" value="draft" <?php echo e(!empty($errorsByRow) ? 'disabled' : ''); ?>>Save All as Draft</button>
  </form>
  <?php endif; ?>
</div></div></div></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/backend/pages/seo_pages/bulk.blade.php ENDPATH**/ ?>