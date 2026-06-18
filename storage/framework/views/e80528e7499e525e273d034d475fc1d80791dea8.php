<?php $__env->startSection('editor'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('fancybox'); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<?php echo e(Breadcrumbs::render('banner.create')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5 class="card-header-text"><?php echo e(__('banner.add_txt')); ?></h5>
      </div>
      <div class="card-block">
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.alert','data' => ['type' => ''.e(session()->get('alert')).'','title' => ''.e(session()->get('title')).'','message' => ''.e(session()->get('message')).'']]); ?>
<?php $component->withName('form.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => ''.e(session()->get('alert')).'','title' => ''.e(session()->get('title')).'','message' => ''.e(session()->get('message')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        <form name="aeDataFrm" id="aeDataFrm" action="<?php echo e(route('admin.banner.store')); ?>" method="POST">
          <?php echo e(csrf_field()); ?>


          <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt1_2_10','data' => ['label' => ''.e(__('admin.featured_img_txt')).'','for' => 'media_id','error' => ''.e($errors->first('media_id')).'','info' => ''.__('admin.info.featured_img').'','required' => 'true']]); ?>
<?php $component->withName('form.group_lyt1_2_10'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('admin.featured_img_txt')).'','for' => 'media_id','error' => ''.e($errors->first('media_id')).'','info' => ''.__('admin.info.featured_img').'','required' => 'true']); ?>
            <div class="media_img_area">
              <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link_media_popup','data' => ['href' => '0','src' => ''.e(route('admin.media.gallery', 0)).'']]); ?>
<?php $component->withName('link_media_popup'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['href' => '0','src' => ''.e(route('admin.media.gallery', 0)).'']); ?>
                <?php echo e(__('admin.browse_media_txt')); ?>

               <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
              <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.hidden','data' => ['value' => '','name' => 'media_id','id' => 'featuredImgVal-0']]); ?>
<?php $component->withName('form.field.hidden'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['value' => '','name' => 'media_id','id' => 'featuredImgVal-0']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
              <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.button_def','data' => ['class' => 'btn-danger btn-mini waves-effect waves-light remove_featured show-scn m-t-10 d-none','id' => 'featuredImgRemov-0','text' => ''.e(__('admin.remove_media_txt')).'']]); ?>
<?php $component->withName('form.field.button_def'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'btn-danger btn-mini waves-effect waves-light remove_featured show-scn m-t-10 d-none','id' => 'featuredImgRemov-0','text' => ''.e(__('admin.remove_media_txt')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            </div>
           <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

          <?php if($fldsHide['title'] == $boolFalse): ?>
          <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt1_2_10','data' => ['label' => ''.e(__('admin.title_txt')).'','for' => 'title','error' => ''.e($errors->first('title')).'']]); ?>
<?php $component->withName('form.group_lyt1_2_10'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('admin.title_txt')).'','for' => 'title','error' => ''.e($errors->first('title')).'']); ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'title','name' => 'title','value' => ''.e(old('title')).'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'title','name' => 'title','value' => ''.e(old('title')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
           <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
          <?php endif; ?>

          <?php if($fldsHide['descp'] == $boolFalse): ?>
          <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt1_2_10','data' => ['label' => ''.e(__('admin.description_txt')).'','for' => 'descp','error' => ''.e($errors->first('descp')).'']]); ?>
<?php $component->withName('form.group_lyt1_2_10'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('admin.description_txt')).'','for' => 'descp','error' => ''.e($errors->first('descp')).'']); ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.textarea','data' => ['id' => 'descp','name' => 'descp','value' => ''.old('descp').'','rows' => '8','class' => 'editor_full']]); ?>
<?php $component->withName('form.field.textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'descp','name' => 'descp','value' => ''.old('descp').'','rows' => '8','class' => 'editor_full']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
           <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
          <?php endif; ?>

          <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt1_2_10','data' => ['label' => ''.e(__('admin.link_txt')).'','for' => 'link','error' => ''.e($errors->first('link')).'']]); ?>
<?php $component->withName('form.group_lyt1_2_10'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('admin.link_txt')).'','for' => 'link','error' => ''.e($errors->first('link')).'']); ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'link','name' => 'link','value' => ''.e(old('link')).'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'link','name' => 'link','value' => ''.e(old('link')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
           <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

          <?php if($fldsHide['link_text'] == $boolFalse): ?>
          <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt1_2_10','data' => ['label' => ''.e(__('admin.link_text_txt')).'','for' => 'link_text','error' => ''.e($errors->first('link_text')).'']]); ?>
<?php $component->withName('form.group_lyt1_2_10'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('admin.link_text_txt')).'','for' => 'link_text','error' => ''.e($errors->first('link_text')).'']); ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'link_text','name' => 'link_text','value' => ''.e(old('link_text')).'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'link_text','name' => 'link_text','value' => ''.e(old('link_text')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
           <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
          <?php endif; ?>

          <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt1_2_10','data' => ['label' => ''.e(__('admin.target_txt')).'','for' => 'link_target','error' => ''.e($errors->first('link_target')).'','info' => ''.__('admin.info.link_target').'']]); ?>
<?php $component->withName('form.group_lyt1_2_10'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('admin.target_txt')).'','for' => 'link_target','error' => ''.e($errors->first('link_target')).'','info' => ''.__('admin.info.link_target').'']); ?>
            <select id="link_target" class="form-control" name="link_target">
              <option value=""><?php echo e(__('admin.def_drop_optn_styl1_txt')); ?></option>
              <?php $__currentLoopData = $linkTargetArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $optVal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($optVal); ?>" <?php echo e(( $optVal == old('link_target') ) ? 'selected' : ''); ?>><?php echo e($optVal); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
           <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

          <div class="form-group has-primary row">
            <label class="col-sm-2 col-form-label"><?php echo e(__('banner.group_txt')); ?> <span class="required">*</span></label>
            <div class="col-sm-5">
              <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'bnr_group','name' => 'bnr_group','value' => ''.e(old('bnr_group') != '' ? old('bnr_group') : 'group').'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'bnr_group','name' => 'bnr_group','value' => ''.e(old('bnr_group') != '' ? old('bnr_group') : 'group').'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            </div>
            <div class="col-sm-5">
              <select id="bnr_group_dd" class="form-control" name="bnr_group_dd">
                <option value=""><?php echo e(__('admin.def_drop_optn_styl6_txt')); ?></option>
                <?php $__currentLoopData = $groupArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $optValGrp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($optValGrp); ?>" <?php echo e(( $optValGrp == old('bnr_group_dd') ) ? 'selected' : ''); ?>><?php echo e($optValGrp); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>
          </div>

          <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt1_2_10','data' => ['label' => ''.e(__('admin.order_txt')).'','for' => 'c_order','error' => ''.e($errors->first('c_order')).'']]); ?>
<?php $component->withName('form.group_lyt1_2_10'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('admin.order_txt')).'','for' => 'c_order','error' => ''.e($errors->first('c_order')).'']); ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'c_order','name' => 'c_order','value' => ''.e(old('c_order') > 0 ? old('c_order') : '').'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'c_order','name' => 'c_order','value' => ''.e(old('c_order') > 0 ? old('c_order') : '').'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
           <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

          <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt1_2_10','data' => ['label' => ''.e(__('admin.status_txt')).'','for' => 'status','error' => ''.e($errors->first('status')).'','required' => 'true']]); ?>
<?php $component->withName('form.group_lyt1_2_10'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('admin.status_txt')).'','for' => 'status','error' => ''.e($errors->first('status')).'','required' => 'true']); ?>
            <select id="status" class="form-control" name="status">
              <?php $__currentLoopData = $statusArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($id); ?>" <?php echo e(( $id == old('status') ) ? 'selected' : ''); ?>><?php echo e($status); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
           <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

          <div class="row">
            <div class="col-sm-12">
              <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt1_2_10','data' => ['class' => 'm-t-10']]); ?>
<?php $component->withName('form.group_lyt1_2_10'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'm-t-10']); ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.button','data' => ['id' => 'submit','name' => 'submit']]); ?>
<?php $component->withName('form.field.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'submit','name' => 'submit']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.button','data' => ['type' => 'reset','id' => 'cancel','name' => 'cancel','class' => 'btn-danger','text' => ''.e(__('admin.cancel_txt')).'']]); ?>
<?php $component->withName('form.field.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'reset','id' => 'cancel','name' => 'cancel','class' => 'btn-danger','text' => ''.e(__('admin.cancel_txt')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
               <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            </div>
          </div>

        </form>
      </div>
      <!-- end of card-block -->
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
  $("#bnr_group_dd").change(function() {
    var data = $("#bnr_group_dd").val();
    /*alert(data);*/
    /*if(data != ""){*/
    $("#bnr_group").val(data);
    /*}*/
  });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('themes.backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/backend/pages/banner/createform.blade.php ENDPATH**/ ?>