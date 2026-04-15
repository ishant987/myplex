<?php $__env->startSection('dataTables'); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<?php echo e(Breadcrumbs::render('menu.index')); ?> 
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5><?php echo e(__('admin.menu.all_txt')); ?></h5>
        <?php if($roleRights['add']): ?>
          <!-- Add New -->
          <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link_add_new','data' => ['url' => ''.e(route('admin.menutype.create')).'']]); ?>
<?php $component->withName('link_add_new'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('admin.menutype.create')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        <?php endif; ?>
      </div>
      <div class="card-block">
       <!-- Show message. -->
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

        <div class="row align-items-center">
           <div class="col-md-12">
                 <div class="z_form-row align-items-center">
                  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt1_3_7_2','data' => ['label' => ''.e(__('admin.menutype.menu_select_txt')).'','for' => 'menu_type_id','error' => ''.e($errors->first('menu_type_id')).'','required' => 'true']]); ?>
<?php $component->withName('form.group_lyt1_3_7_2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('admin.menutype.menu_select_txt')).'','for' => 'menu_type_id','error' => ''.e($errors->first('menu_type_id')).'','required' => 'true']); ?>
                    <select id="menu_type_id" class="form-control" name="menu_type_id" style="float:left;width:85%;margin-right: 20px;">
                      <option value=""><?php echo e(__('admin.def_drop_optn_styl1_txt')); ?></option>
                      <?php $__currentLoopData = $menuTypeAssoc; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $mname): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($mname['menu_type_id']); ?>" <?php echo e(( $mtid == $mname['menu_type_id'] ) ? 'selected' : ''); ?>><?php echo e($mname['label']); ?> ( <?php echo e($menuforAssoc[$mname['menu_for']]); ?> )</option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <div class="f-left">
                      <a href="<?php echo e(route('admin.menutype.edit',$mtid)); ?>" class="btn waves-effect waves-light btn-sm btn-primary f-right m-r-5"><b><i class="icofont icofont-ui-edit"></i> <!-- <i class="icofont icofont-refresh"></i> <i class="icofont icofont-save"></i> --> </b></a>
                    </div>
                   <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                 </div>
           </div>
        </div>

        <!-- Select a menu to edit section end -->
        <div class="row m-b-20">
          
          <!-- Add to menu left section start -->
          <div class="col-md-4 col-sm-12">
            <form name="add_menu_frm" action="<?php echo e(route('admin.menu.store')); ?>" method="post">
                <?php echo e(csrf_field()); ?>

              <div class="menu-accordion-wrapper">
                <div class="accordion" id="accordion2">
                    <!-- Pages "Add to menu" module start -->
                    <div class="accordion-group">
                      <div class="accordion-heading">
                        <a class="accordion-toggle btn-primary" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne"><?php echo e(__('admin.page.menu_label_txt')); ?></a>
                      </div>
                      <div id="collapseOne" class="accordion-body collapse show">
                        <div class="accordion-inner">
                          <div class="menu_item_scroll border-checkbox-section">
                           <?php $__currentLoopData = $pagesListModel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module_class => $pageListModel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                             <?php $__currentLoopData = $pageListModel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $pageModel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.menu.single_checkbox','data' => ['label' => ''.$pageModel->title.'','for' => ''.e($pageModel->page_id).'','dataModuleClass' => ''.e($module_class).'','dataId' => ''.e($pageModel->page_id).'','dataLabel' => ''.e($pageModel->title).'']]); ?>
<?php $component->withName('form.menu.single_checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.$pageModel->title.'','for' => ''.e($pageModel->page_id).'','dataModuleClass' => ''.e($module_class).'','dataId' => ''.e($pageModel->page_id).'','dataLabel' => ''.e($pageModel->title).'']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </div>
                          <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt1_12','data' => ['class' => 'm-t-10 m-b-0-i']]); ?>
<?php $component->withName('form.group_lyt1_12'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'm-t-10 m-b-0-i']); ?>
                          <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.button','data' => ['id' => 'add_page_menu_btn','name' => 'add_page_menu_btn','class' => 'btn-primary btn-sm','text' => ''.e(__('admin.menu.add_to_menu_txt')).'']]); ?>
<?php $component->withName('form.field.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'add_page_menu_btn','name' => 'add_page_menu_btn','class' => 'btn-primary btn-sm','text' => ''.e(__('admin.menu.add_to_menu_txt')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                          <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.button','data' => ['type' => 'reset','id' => 'cancel','name' => 'cancel','class' => 'btn-danger btn-sm','text' => ''.e(__('admin.cancel_txt')).'']]); ?>
<?php $component->withName('form.field.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'reset','id' => 'cancel','name' => 'cancel','class' => 'btn-danger btn-sm','text' => ''.e(__('admin.cancel_txt')).'']); ?>
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
                    </div>
                    <!-- Pages "Add to menu" module end -->

                    <!-- Links "Add to menu" module start -->
                    <div class="accordion-group">
                      <div class="accordion-heading">
                         <a class="accordion-toggle btn-primary" data-toggle="collapse" data-parent="#accordion2" href="#collapseLink">
                         <?php echo e(__('admin.link.menu_label_txt')); ?></a>
                      </div>
                      <div id="collapseLink" class="accordion-body collapse <?php if(old('add_custom_menu_btn')=='add_custom_menu_btn'): ?>{ show } <?php endif; ?>">
                         <div class="accordion-inner">
                            <div class="custom_menu_link">
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt1_12','data' => ['label' => ''.e(__('admin.link.menu_url_txt')).'','for' => 'link_url','error' => ''.e($errors->first('link_url')).'']]); ?>
<?php $component->withName('form.group_lyt1_12'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('admin.link.menu_url_txt')).'','for' => 'link_url','error' => ''.e($errors->first('link_url')).'']); ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'link_url','placeholder' => 'http:// or https://','name' => 'link_url','value' => ''.e(old('link_url')).'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'link_url','placeholder' => 'http:// or https://','name' => 'link_url','value' => ''.e(old('link_url')).'']); ?>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt1_12','data' => ['label' => ''.e(__('admin.link.menu_link_txt')).'','for' => 'link_text','error' => ''.e($errors->first('link_text')).'']]); ?>
<?php $component->withName('form.group_lyt1_12'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('admin.link.menu_link_txt')).'','for' => 'link_text','error' => ''.e($errors->first('link_text')).'']); ?>
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
                            </div>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt1_12','data' => ['class' => 'm-t-10 m-b-0-i']]); ?>
<?php $component->withName('form.group_lyt1_12'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'm-t-10 m-b-0-i']); ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'menu_type_id','name' => 'menu_type_id','type' => 'hidden','value' => ''.e($mtid).'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'menu_type_id','name' => 'menu_type_id','type' => 'hidden','value' => ''.e($mtid).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.button','data' => ['id' => 'add_custom_menu_btn','name' => 'add_custom_menu_btn','class' => 'btn-primary btn-sm','text' => ''.e(__('admin.menu.add_to_menu_txt')).'','value' => 'add_custom_menu_btn']]); ?>
<?php $component->withName('form.field.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'add_custom_menu_btn','name' => 'add_custom_menu_btn','class' => 'btn-primary btn-sm','text' => ''.e(__('admin.menu.add_to_menu_txt')).'','value' => 'add_custom_menu_btn']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.button','data' => ['type' => 'reset','id' => 'cancel','name' => 'cancel','class' => 'btn-danger btn-sm','text' => ''.e(__('admin.cancel_txt')).'']]); ?>
<?php $component->withName('form.field.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'reset','id' => 'cancel','name' => 'cancel','class' => 'btn-danger btn-sm','text' => ''.e(__('admin.cancel_txt')).'']); ?>
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
                   </div>
                    <!-- Links "Add to menu" module end -->
                </div>
              </div>
            </form>
          </div>
          <!-- Add to menu left section end -->

          <!-- Menu Structure right section start -->
          <div class="col-md-8 col-xs-12">
            <div class="menu_area">
              
              <?php if( $dataListModel ): ?> 
              <form name="menuformsubmit" id="menuformsubmit" method="POST" action="<?php echo e(route('admin.menu.update', $mtid)); ?>">
               <?php echo e(csrf_field()); ?>

               <?php echo e(method_field('PATCH')); ?>


                <div class="form_row">
                  <h6>Menu Structure</h6>
                  <p>Click the arrow on the left of the item to reveal additional configuration options.</p>
                  <div class="menu-accordion-wrapper">
                    <div class="accordion" id="accordion3">
                    <?php $__currentLoopData = $dataListModel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $menuModel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                      
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.menu.single_structure','data' => ['label' => ''.$menuModel->label.'','for' => ''.e($menuModel->menu_id).'','dataMenuId' => ''.e($menuModel->menu_id).'','dataId' => ''.e($menuModel->data_id).'','dataLabel' => ''.e($menuModel->label).'','dataOrder' => ''.e($menuModel->c_order).'','dataImageUrl' => ''.e($menuModel->image_url).'','dataIsLink' => ''.e($menuModel->is_link).'','dataExternalLink' => ''.e($menuModel->external_link).'','dataLinkTarget' => ''.e($menuModel->link_target).'','dataMenuClass' => ''.e($menuModel->menu_class).'','dataModulePageName' => ''.e($menuModel->getModulePageName()).'','dataIsSubMenu' => '','subMenuClass' => '']]); ?>
<?php $component->withName('form.menu.single_structure'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.$menuModel->label.'','for' => ''.e($menuModel->menu_id).'','dataMenuId' => ''.e($menuModel->menu_id).'','dataId' => ''.e($menuModel->data_id).'','dataLabel' => ''.e($menuModel->label).'','dataOrder' => ''.e($menuModel->c_order).'','dataImageUrl' => ''.e($menuModel->image_url).'','dataIsLink' => ''.e($menuModel->is_link).'','dataExternalLink' => ''.e($menuModel->external_link).'','dataLinkTarget' => ''.e($menuModel->link_target).'','dataMenuClass' => ''.e($menuModel->menu_class).'','dataModulePageName' => ''.e($menuModel->getModulePageName()).'','dataIsSubMenu' => '','subMenuClass' => '']); ?>
                          <select name="menu_item[<?php echo e($menuModel->menu_id); ?>][parent_menu_id]" id="parent_menu_<?php echo e($menuModel->menu_id); ?>" class="form-control my-1">
                             <option value="">--please select--</option>
                             <?php $__currentLoopData = $menuModel->getSubMenuAssoc(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subMenuModel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                             <option value="<?php echo e($subMenuModel->menu_id); ?>"><?php echo e($subMenuModel->label); ?></option>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </select>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php if(isset($menuModel->menuchildren) && $menuModel->menuchildren->count()>0): ?>
                          <?php $__currentLoopData = $menuModel->menuchildren; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cmModel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.menu.single_structure','data' => ['label' => ''.$cmModel->label.'','for' => ''.e($cmModel->menu_id).'','dataMenuId' => ''.e($cmModel->menu_id).'','dataId' => ''.e($cmModel->data_id).'','dataLabel' => ''.e($cmModel->label).'','dataOrder' => ''.e($cmModel->c_order).'','dataImageUrl' => ''.e($cmModel->image_url).'','dataIsLink' => ''.e($cmModel->is_link).'','dataExternalLink' => ''.e($cmModel->external_link).'','dataLinkTarget' => ''.e($cmModel->link_target).'','dataMenuClass' => ''.e($cmModel->menu_class).'','dataModulePageName' => ''.e($cmModel->getModulePageName()).'','dataIsSubMenu' => 'sub-titel','subMenuClass' => '']]); ?>
<?php $component->withName('form.menu.single_structure'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.$cmModel->label.'','for' => ''.e($cmModel->menu_id).'','dataMenuId' => ''.e($cmModel->menu_id).'','dataId' => ''.e($cmModel->data_id).'','dataLabel' => ''.e($cmModel->label).'','dataOrder' => ''.e($cmModel->c_order).'','dataImageUrl' => ''.e($cmModel->image_url).'','dataIsLink' => ''.e($cmModel->is_link).'','dataExternalLink' => ''.e($cmModel->external_link).'','dataLinkTarget' => ''.e($cmModel->link_target).'','dataMenuClass' => ''.e($cmModel->menu_class).'','dataModulePageName' => ''.e($cmModel->getModulePageName()).'','dataIsSubMenu' => 'sub-titel','subMenuClass' => '']); ?>
                              <select name="menu_item[<?php echo e($cmModel->menu_id); ?>][parent_menu_id]" id="parent_menu_<?php echo e($cmModel->menu_id); ?>" class="form-control my-1">
                                 <option value="">--please select--</option>
                                 <?php $__currentLoopData = $cmModel->getSubMenuAssoc(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subMenuModel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <option value="<?php echo e($subMenuModel->menu_id); ?>"><?php echo e($subMenuModel->label); ?></option>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                            <?php if(isset($cmModel->menuchildren) && $cmModel->menuchildren->count()>0): ?>
                              <?php $__currentLoopData = $cmModel->menuchildren; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $gcmModel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.menu.single_structure','data' => ['label' => ''.$gcmModel->label.'','for' => ''.e($gcmModel->menu_id).'','dataMenuId' => ''.e($gcmModel->menu_id).'','dataId' => ''.e($gcmModel->data_id).'','dataLabel' => ''.e($gcmModel->label).'','dataOrder' => ''.e($gcmModel->c_order).'','dataImageUrl' => ''.e($gcmModel->image_url).'','dataIsLink' => ''.e($gcmModel->is_link).'','dataExternalLink' => ''.e($gcmModel->external_link).'','dataLinkTarget' => ''.e($gcmModel->link_target).'','dataMenuClass' => ''.e($gcmModel->menu_class).'','dataModulePageName' => ''.e($gcmModel->getModulePageName()).'','dataIsSubMenu' => 'sub-titel2','subMenuClass' => 'd-none']]); ?>
<?php $component->withName('form.menu.single_structure'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.$gcmModel->label.'','for' => ''.e($gcmModel->menu_id).'','dataMenuId' => ''.e($gcmModel->menu_id).'','dataId' => ''.e($gcmModel->data_id).'','dataLabel' => ''.e($gcmModel->label).'','dataOrder' => ''.e($gcmModel->c_order).'','dataImageUrl' => ''.e($gcmModel->image_url).'','dataIsLink' => ''.e($gcmModel->is_link).'','dataExternalLink' => ''.e($gcmModel->external_link).'','dataLinkTarget' => ''.e($gcmModel->link_target).'','dataMenuClass' => ''.e($gcmModel->menu_class).'','dataModulePageName' => ''.e($gcmModel->getModulePageName()).'','dataIsSubMenu' => 'sub-titel2','subMenuClass' => 'd-none']); ?>
                                  <!-- <select name="menu_item[<?php echo e($gcmModel->menu_id); ?>][parent_menu_id]" id="parent_menu_<?php echo e($gcmModel->menu_id); ?>" class="form-control my-1">
                                     <option value="">--please select--</option>
                                     <?php $__currentLoopData = $gcmModel->getSubMenuAssoc(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subMenuModel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                     <option value="<?php echo e($subMenuModel->menu_id); ?>"><?php echo e($subMenuModel->label); ?></option>
                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                  </select> -->
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                           
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                  </div>   
                  <!-- Action buttons -->             
                  <div class="form-group">
                    <div class="f-left">
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
                    </div>
                    <?php if($roleRights['delete']): ?>
                    <div class="f-right">
                      <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e(route('admin.menutype.destroy.custom',$mtid)).'','class' => 'btn waves-effect waves-light btn-sm btn-danger f-right m-r-5 delLink']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('admin.menutype.destroy.custom',$mtid)).'','class' => 'btn waves-effect waves-light btn-sm btn-danger f-right m-r-5 delLink']); ?><i class="icofont icofont-ui-delete"></i> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>
                    <?php endif; ?>
                  </div>

                </div>
              </form>
              <?php endif; ?>

            </div>
          </div>
          <!-- Menu Structure right section end -->
        </div>
     </div>
   </div>
 </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?> 
  <script>
  $('#menu_type_id').bind('change', function() {
    var menu_type_id = $(this).val();
    var url = '';
    if(menu_type_id > 0){
      url = '<?php echo e(route("admin.menu.index.custom")); ?>'+'/'+menu_type_id;  
      // alert(url);    
      // url = url.replace('menu_type_id', menu_type_id);
    }
    else{
      url = '<?php echo e(route("admin.menu.index.custom")); ?>';
    }
    window.location.href = url;
  });
  </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('themes.backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/backend/pages/menu/index.blade.php ENDPATH**/ ?>