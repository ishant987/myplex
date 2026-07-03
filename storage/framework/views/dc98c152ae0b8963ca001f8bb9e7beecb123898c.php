<?php $__env->startSection('editor'); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
  $isEdit = $page->exists;
  $action = $isEdit ? route('admin.seo-pages.update', $page) : route('admin.seo-pages.store');
?>
<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header"><h5><?php echo e($isEdit ? 'Edit SEO Page' : 'Create New Page'); ?></h5></div>
      <div class="card-block">
        <?php if(session('message')): ?><div class="alert alert-success"><?php echo e(session('message')); ?></div><?php endif; ?>
        <?php if($errors->any()): ?><div class="alert alert-danger"><?php echo e($errors->first()); ?></div><?php endif; ?>
        <form method="post" action="<?php echo e($action); ?>" enctype="multipart/form-data" id="seoPageForm">
          <?php echo csrf_field(); ?>
          <?php if($isEdit): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>
          <h6>Basic Info</h6>
          <div class="form-group"><label>Page Title</label><input class="form-control" id="page_title" name="page_title" value="<?php echo e(old('page_title', $page->page_title)); ?>" required></div>
          <div class="form-group"><label>URL Slug</label><input class="form-control" id="url_slug" name="url_slug" value="<?php echo e(old('url_slug', $page->url_slug)); ?>" required><small class="text-muted">Use lowercase letters, numbers, hyphens and optional /blog/path segments.</small></div>
          <div class="row">
            <div class="col-md-6 form-group"><label>Page Type</label><select class="form-control" name="page_type"><?php $__currentLoopData = $pageTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($key); ?>" <?php echo e(old('page_type', $page->page_type) === $key ? 'selected' : ''); ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
            <div class="col-md-6 form-group"><label>Category</label><select class="form-control" name="category"><option value="">Select</option><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($category); ?>" <?php echo e(old('category', $page->category) === $category ? 'selected' : ''); ?>><?php echo e($category); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
          </div>
          <div class="row">
            <div class="col-md-4 form-group"><label>Author</label><input class="form-control" name="author" value="<?php echo e(old('author', $page->author)); ?>"></div>
            <div class="col-md-4 form-group"><label>Publish Date</label><input type="date" class="form-control" name="publish_date" value="<?php echo e(old('publish_date', optional($page->publish_date)->format('Y-m-d') ?: now()->format('Y-m-d'))); ?>"></div>
            <div class="col-md-4 form-group"><label>Status</label><select class="form-control" name="status"><option value="draft" <?php echo e(old('status', $page->status) === 'draft' ? 'selected' : ''); ?>>Draft</option><option value="published" <?php echo e(old('status', $page->status) === 'published' ? 'selected' : ''); ?>>Published</option></select></div>
          </div>
          <h6 class="mt-4">Content</h6>
          <div class="form-group"><label>Featured Image</label><input type="file" class="form-control" name="featured_image" accept="image/png,image/jpeg,image/webp"><input type="text" class="form-control mt-2" name="featured_image_url" value="<?php echo e(old('featured_image_url', $page->featured_image_url)); ?>" placeholder="Or paste image URL"><?php if($page->featured_image_url): ?><img src="<?php echo e($page->featured_image_url); ?>" alt="" class="mt-2" style="max-width:240px"><?php endif; ?></div>
          <div class="form-group"><label>Image Alt Text</label><input class="form-control" id="image_alt_text" name="image_alt_text" value="<?php echo e(old('image_alt_text', $page->image_alt_text)); ?>"></div>
          <div class="form-group"><label>Short Description / Excerpt</label><textarea class="form-control counted" maxlength="160" data-max="160" name="short_description" rows="3"><?php echo e(old('short_description', $page->short_description)); ?></textarea><small class="counter text-muted"></small></div>
          <div class="form-group"><label>Full Page Content</label><textarea class="form-control editor_full" id="full_content" name="full_content" rows="14"><?php echo e(old('full_content', $page->full_content)); ?></textarea><small id="wordCount" class="text-muted"></small></div>
          <div class="form-group"><label>Tags</label><input class="form-control" name="tags" value="<?php echo e(old('tags', $page->tags)); ?>" placeholder="SIP, mutual funds, ELSS"></div>
          <details class="mb-3" open>
            <summary><strong>SEO Settings</strong></summary>
            <div class="row mt-3">
              <div class="col-md-6 form-group"><label>SEO Title</label><input class="form-control counted" maxlength="60" data-max="60" id="seo_title" name="seo_title" value="<?php echo e(old('seo_title', $page->seo_title)); ?>"><small class="counter text-muted"></small></div>
              <div class="col-md-6 form-group"><label>Focus Keyword</label><input class="form-control" name="focus_keyword" value="<?php echo e(old('focus_keyword', $page->focus_keyword)); ?>"></div>
            </div>
            <div class="form-group"><label>Meta Description</label><textarea class="form-control counted" maxlength="160" data-max="160" id="meta_description" name="meta_description" rows="2"><?php echo e(old('meta_description', $page->meta_description)); ?></textarea><small class="counter text-muted"></small></div>
            <div class="form-group"><label>Canonical URL</label><input class="form-control" id="canonical_url" name="canonical_url" value="<?php echo e(old('canonical_url', $page->canonical_url)); ?>"></div>
            <div class="row">
              <div class="col-md-6 form-group"><label>Open Graph Title</label><input class="form-control" name="og_title" value="<?php echo e(old('og_title', $page->og_title)); ?>"></div>
              <div class="col-md-6 form-group"><label>Schema Type</label><select class="form-control" name="schema_type"><?php $__currentLoopData = $schemaTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($type); ?>" <?php echo e(old('schema_type', $page->schema_type ?: 'BlogPosting') === $type ? 'selected' : ''); ?>><?php echo e($type); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
            </div>
            <div class="form-group"><label>Open Graph Image</label><input type="file" class="form-control" name="og_image" accept="image/png,image/jpeg,image/webp"><input type="text" class="form-control mt-2" name="og_image_url" value="<?php echo e(old('og_image_url', $page->og_image_url)); ?>" placeholder="Or paste image URL"></div>
            <div class="form-check"><input type="hidden" name="is_indexed" value="0"><input class="form-check-input" type="checkbox" name="is_indexed" value="1" id="is_indexed" <?php echo e(old('is_indexed', $page->is_indexed ?? true) ? 'checked' : ''); ?>><label class="form-check-label" for="is_indexed">Index, follow</label></div>
          </details>
          <button class="btn btn-primary">Save Page</button>
          <?php if($isEdit && $page->status === 'draft'): ?><button class="btn btn-success" name="status" value="published">Publish Now</button><?php endif; ?>
          <a href="<?php echo e(route('admin.seo-pages.index')); ?>" class="btn btn-secondary">Back</a>
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card"><div class="card-header"><h5>Google Preview</h5></div><div class="card-block"><div style="font-family:Arial"><div id="previewTitle" style="color:#1a0dab;font-size:18px"></div><div id="previewUrl" style="color:#006621;font-size:14px"></div><div id="previewDesc" style="color:#545454;font-size:13px"></div></div></div></div>
    <?php if($isEdit): ?>
    <div class="card"><div class="card-header"><h5>Version History</h5></div><div class="card-block">
      <a class="btn btn-sm btn-info mb-2" target="_blank" href="<?php echo e($page->public_url); ?>">View Live Page</a>
      <?php $__currentLoopData = $versions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $version): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <form method="post" action="<?php echo e(route('admin.seo-pages.restore', [$page, $version])); ?>" class="mb-2"><?php echo csrf_field(); ?><button class="btn btn-sm btn-secondary">Restore <?php echo e($version->saved_at->format('Y-m-d H:i')); ?></button></form>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <form method="post" action="<?php echo e(route('admin.seo-pages.destroy', $page)); ?>" onsubmit="return confirm('Are you sure? This will remove the page from Google too.');"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><label><input type="checkbox" name="confirm_delete" value="1" required> Confirm delete</label><button class="btn btn-sm btn-danger d-block mt-2">Delete</button></form>
    </div></div>
    <?php endif; ?>
  </div>
</div>
<script>
(function(){
  function slugify(value){return value.toLowerCase().trim().replace(/^https?:\/\/[^/]+/,'').replace(/^\/+|\/+$/g,'').split('/').map(function(p){return p.replace(/[^a-z0-9]+/g,'-').replace(/^-+|-+$/g,'')}).filter(Boolean).join('/')}
  var title=document.getElementById('page_title'), slug=document.getElementById('url_slug'), canonical=document.getElementById('canonical_url');
  function updatePreview(){document.getElementById('previewTitle').textContent=(document.getElementById('seo_title').value||title.value||'SEO title');document.getElementById('previewUrl').textContent='https://www.myplexus.com/'+(slug.value||'url-slug');document.getElementById('previewDesc').textContent=(document.getElementById('meta_description').value||document.querySelector('[name=short_description]').value||'Meta description');}
  if(title && slug){title.addEventListener('blur',function(){if(!slug.value){slug.value=slugify(title.value)} if(!canonical.value){canonical.value='https://www.myplexus.com/'+slug.value} document.getElementById('image_alt_text').value=document.getElementById('image_alt_text').value||title.value; updatePreview();}); slug.addEventListener('input',function(){slug.value=slugify(slug.value); canonical.value='https://www.myplexus.com/'+slug.value; updatePreview();});}
  document.querySelectorAll('.counted').forEach(function(el){function count(){var n=el.value.length,max=el.dataset.max,next=el.parentNode.querySelector('.counter');next.textContent=n+'/'+max;next.className='counter '+(n>max?'text-danger':'text-success');updatePreview();}el.addEventListener('input',count);count();});
  var content=document.getElementById('full_content'), wc=document.getElementById('wordCount');function words(){var text=content.value.replace(/<[^>]*>/g,' '), n=(text.trim().match(/\S+/g)||[]).length;wc.textContent=n+' words'+(n<300?' - add more depth for SEO':'');} if(content){content.addEventListener('input',words);words();}
  updatePreview();
})();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/backend/pages/seo_pages/form.blade.php ENDPATH**/ ?>