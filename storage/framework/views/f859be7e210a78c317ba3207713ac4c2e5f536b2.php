<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5>SEO Pages</h5>
        <a href="<?php echo e(route('admin.seo-pages.create')); ?>" class="btn btn-primary btn-sm float-right ml-2">Create New Page</a>
        <a href="<?php echo e(route('admin.seo-pages.bulk')); ?>" class="btn btn-info btn-sm float-right">Bulk Upload</a>
      </div>
      <div class="card-block">
        <?php if(session('message')): ?><div class="alert alert-success"><?php echo e(session('message')); ?></div><?php endif; ?>
        <form method="get" class="row mb-3">
          <div class="col-md-3"><input class="form-control" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search title, keyword or tags"></div>
          <div class="col-md-2"><select name="status" class="form-control"><option value="">All Status</option><option value="published" <?php echo e(request('status') === 'published' ? 'selected' : ''); ?>>Published</option><option value="draft" <?php echo e(request('status') === 'draft' ? 'selected' : ''); ?>>Draft</option></select></div>
          <div class="col-md-2"><select name="page_type" class="form-control"><option value="">All Types</option><?php $__currentLoopData = $pageTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($key); ?>" <?php echo e(request('page_type') === $key ? 'selected' : ''); ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
          <div class="col-md-2"><select name="category" class="form-control"><option value="">All Categories</option><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($category); ?>" <?php echo e(request('category') === $category ? 'selected' : ''); ?>><?php echo e($category); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
          <div class="col-md-2"><select name="sort" class="form-control"><option value="updated_at" <?php echo e(request('sort') === 'updated_at' ? 'selected' : ''); ?>>Last updated</option><option value="created_at" <?php echo e(request('sort') === 'created_at' ? 'selected' : ''); ?>>Date created</option><option value="seo_score" <?php echo e(request('sort') === 'seo_score' ? 'selected' : ''); ?>>SEO score lowest</option></select></div>
          <div class="col-md-1"><button class="btn btn-secondary btn-block">Filter</button></div>
        </form>
        <div class="table-responsive">
          <table class="table table-striped table-bordered">
            <thead><tr><th>Title</th><th>URL Slug</th><th>Type</th><th>Category</th><th>Status</th><th>SEO Score</th><th>Last Updated</th><th>Actions</th></tr></thead>
            <tbody>
              <?php $__empty_1 = true; $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <?php $color = $page->seo_score <= 40 ? '#dc3545' : ($page->seo_score <= 70 ? '#ffc107' : '#28a745'); ?>
              <tr>
                <td><a href="<?php echo e(route('admin.seo-pages.edit', $page)); ?>"><?php echo e($page->page_title); ?></a></td>
                <td><a href="<?php echo e($page->public_url); ?>" target="_blank"><?php echo e($page->public_url); ?></a></td>
                <td><span class="badge badge-info"><?php echo e($pageTypes[$page->page_type] ?? $page->page_type); ?></span></td>
                <td><?php echo e($page->category); ?></td>
                <td><span class="badge badge-<?php echo e($page->status === 'published' ? 'success' : 'secondary'); ?>"><?php echo e(ucfirst($page->status)); ?></span></td>
                <td style="min-width:120px"><div class="progress" style="height:18px"><div class="progress-bar" style="width:<?php echo e($page->seo_score); ?>%;background:<?php echo e($color); ?>"><?php echo e($page->seo_score); ?></div></div></td>
                <td><?php echo e(optional($page->updated_at)->format('Y-m-d')); ?></td>
                <td>
                  <a class="btn btn-sm btn-primary" href="<?php echo e(route('admin.seo-pages.edit', $page)); ?>">Edit</a>
                  <a class="btn btn-sm btn-secondary" target="_blank" href="<?php echo e($page->public_url); ?>">Preview</a>
                  <form method="post" action="<?php echo e(route('admin.seo-pages.duplicate', $page)); ?>" class="d-inline"><?php echo csrf_field(); ?><button class="btn btn-sm btn-info">Duplicate</button></form>
                </td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
              <tr><td colspan="8" class="text-center">No SEO pages found.</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
        <?php echo e($pages->links()); ?>

      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/backend/pages/seo_pages/index.blade.php ENDPATH**/ ?>